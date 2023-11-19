<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Http\Requests\CreateTransactionsRequest;
use App\Http\Requests\UpdateTransactionsRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TransactionsResource;
use App\Repositories\TransactionsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TransactionsController extends AppBaseController
{
    /** @var TransactionsRepository $transactionsRepository*/
    private $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepo)
    {
        $this->transactionsRepository = $transactionsRepo;
    }

    /**
     * Display a listing of the Transactions.
     */
    public function index(Request $request)
    {
        $transactions = $this->transactionsRepository->paginate(10);

        return view('transactions.index')
            ->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new Transactions.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created Transactions in storage.
     */
    public function store(CreateTransactionsRequest $request)
    {
        try {
            $input = $request->all();

            $this->transactionsRepository->newTransaction($input);
            Flash::success('Transactions saved successfully.');

            return redirect(route('transactions.index'));
        } catch (\Exception $e) {
            Flash::error('something_went_wrong');

            return redirect(route('tasks.index'));
        }
    }

    /**
     * Display the specified Transactions.
     */
    public function show($id)
    {
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            Flash::error('Transactions not found');

            return redirect(route('transactions.index'));
        }

        return view('transactions.show')->with('transactions', $transactions);
    }

    /**
     * Show the form for editing the specified Transactions.
     */
    public function edit($id)
    {
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            Flash::error('Transactions not found');

            return redirect(route('transactions.index'));
        }

        return view('transactions.edit')->with('transactions', $transactions);
    }

    /**
     * Update the specified Transactions in storage.
     */
    public function update($id, UpdateTransactionsRequest $request)
    {
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            Flash::error('Transactions not found');

            return redirect(route('transactions.index'));
        }

        $transactions = $this->transactionsRepository->update($request->all(), $id);

        Flash::success('Transactions updated successfully.');

        return redirect(route('transactions.index'));
    }

    /**
     * Remove the specified Transactions from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $transactions = $this->transactionsRepository->find($id);

        if (empty($transactions)) {
            Flash::error('Transactions not found');

            return redirect(route('transactions.index'));
        }

        $this->transactionsRepository->delete($id);

        Flash::success('Transactions deleted successfully.');

        return redirect(route('transactions.index'));
    }

    /**
     * Get Tasks For Datatable
     * @return \Illuminate\Http\JsonResponse
     */
    function getData()
    {
        try {
            $transactions = $this->transactionsRepository->model()::with(['user']);
            return Datatables::of($transactions)
                ->editColumn('due_date', function($resource) {
                    return Carbon::parse($resource->due_date)->format('Y-m-d');
                })
                ->make(true);
        } catch (\Exception $e) {
            return $this->sendError('Something Went Wrong', 500);
        }
    }

    public function exportTransactions()
    {
        return Excel::download(new TransactionsExport($this->transactionsRepository), 'transactions_' .date('Y-m-d H:i:s'). '.xlsx');
    }
}
