<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\LoginAPIRequest;
use App\Http\Resources\TransactionsResource;
use App\Repositories\TransactionsRepository;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;

/**
 * Class UsersAPIController
 */
class UsersAPIController extends AppBaseController
{
    /** @var UserRepository $userRepository*/
    private $userRepository;

    /** @var TransactionsRepository $transactionsRepository*/
    private $transactionsRepository;

    public function __construct(UserRepository $userRepo, TransactionsRepository $transactionsRepo)
    {
        $this->userRepository = $userRepo;
        $this->transactionsRepository = $transactionsRepo;
    }

    public function login(LoginAPIRequest $request)
    {
        try {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (!auth()->attempt($data)) {
                return $this->sendApiError(__('auth.failed'), 500);
            }

            $token = auth()->user()->createToken('API Token');
            $user = $this->userRepository->getById(auth()->id());

            return $this->sendApiResponse(['user' => $user, 'token' => $token->accessToken], __('auth.login_success'));

        } catch (\Exception $e) {
            return $this->sendApiError(__('messages.something_went_wrong'), 500);
        }
    }

    public function getTransactions()
    {
        try {
            $limit = \request('limit') ? \request('limit') : 20;
            $transactions = $this->transactionsRepository->getUserTransactions($this->getUser()->id, $limit);

            return $this->sendApiResponsePaginate(TransactionsResource::collection($transactions), __('messages.retrieved_successfully'));
        } catch (\Exception $e) {
            return $this->sendApiError(__('messages.something_went_wrong'), 500);
        }
    }
}
