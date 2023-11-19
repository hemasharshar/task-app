<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTransactionsAPIRequest;
use App\Http\Requests\API\UpdateTransactionsAPIRequest;
use App\Models\Transactions;
use App\Repositories\TransactionsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TransactionsAPIController
 */
class TransactionsAPIController extends AppBaseController
{
    private TransactionsRepository $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepo)
    {
        $this->transactionsRepository = $transactionsRepo;
    }

    /**
     * Display a listing of the Transactions.
     * GET|HEAD /transactions
     */
    public function index(Request $request): JsonResponse
    {
        $transactions = $this->transactionsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Store a newly created Transactions in storage.
     * POST /transactions
     */
    public function store(CreateTransactionsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $transactions = $this->transactionsRepository->create($input);

        return $this->sendResponse($transactions->toArray(), 'Transactions saved successfully');
    }

    /**
     * Display the specified Transactions.
     * GET|HEAD /transactions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Transactions $transactions */
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            return $this->sendError('Transactions not found');
        }

        return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Update the specified Transactions in storage.
     * PUT/PATCH /transactions/{id}
     */
    public function update($id, UpdateTransactionsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Transactions $transactions */
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            return $this->sendError('Transactions not found');
        }

        $transactions = $this->transactionsRepository->update($input, $id);

        return $this->sendResponse($transactions->toArray(), 'Transactions updated successfully');
    }

    /**
     * Remove the specified Transactions from storage.
     * DELETE /transactions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Transactions $transactions */
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            return $this->sendError('Transactions not found');
        }

        $transactions->delete();

        return $this->sendSuccess('Transactions deleted successfully');
    }
}
