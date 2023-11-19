<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentsTransactionsAPIRequest;
use App\Http\Requests\API\UpdatePaymentsTransactionsAPIRequest;
use App\Models\PaymentsTransactions;
use App\Repositories\PaymentsTransactionsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PaymentsTransactionsAPIController
 */
class PaymentsTransactionsAPIController extends AppBaseController
{
    private PaymentsTransactionsRepository $paymentsTransactionsRepository;

    public function __construct(PaymentsTransactionsRepository $paymentsTransactionsRepo)
    {
        $this->paymentsTransactionsRepository = $paymentsTransactionsRepo;
    }

    /**
     * Display a listing of the PaymentsTransactions.
     * GET|HEAD /payments-transactions
     */
    public function index(Request $request): JsonResponse
    {
        $paymentsTransactions = $this->paymentsTransactionsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($paymentsTransactions->toArray(), 'Payments Transactions retrieved successfully');
    }

    /**
     * Store a newly created PaymentsTransactions in storage.
     * POST /payments-transactions
     */
    public function store(CreatePaymentsTransactionsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $paymentsTransactions = $this->paymentsTransactionsRepository->create($input);

        return $this->sendResponse($paymentsTransactions->toArray(), 'Payments Transactions saved successfully');
    }

    /**
     * Display the specified PaymentsTransactions.
     * GET|HEAD /payments-transactions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PaymentsTransactions $paymentsTransactions */
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            return $this->sendError('Payments Transactions not found');
        }

        return $this->sendResponse($paymentsTransactions->toArray(), 'Payments Transactions retrieved successfully');
    }

    /**
     * Update the specified PaymentsTransactions in storage.
     * PUT/PATCH /payments-transactions/{id}
     */
    public function update($id, UpdatePaymentsTransactionsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PaymentsTransactions $paymentsTransactions */
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            return $this->sendError('Payments Transactions not found');
        }

        $paymentsTransactions = $this->paymentsTransactionsRepository->update($input, $id);

        return $this->sendResponse($paymentsTransactions->toArray(), 'PaymentsTransactions updated successfully');
    }

    /**
     * Remove the specified PaymentsTransactions from storage.
     * DELETE /payments-transactions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PaymentsTransactions $paymentsTransactions */
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            return $this->sendError('Payments Transactions not found');
        }

        $paymentsTransactions->delete();

        return $this->sendSuccess('Payments Transactions deleted successfully');
    }
}
