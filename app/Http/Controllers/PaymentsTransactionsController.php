<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentsTransactionsRequest;
use App\Http\Requests\UpdatePaymentsTransactionsRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PaymentsTransactionsRepository;
use App\Repositories\TransactionsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Yajra\DataTables\DataTables;

class PaymentsTransactionsController extends AppBaseController
{
    /** @var PaymentsTransactionsRepository $paymentsTransactionsRepository*/
    private $paymentsTransactionsRepository;

    /** @var TransactionsRepository $transactionsRepository*/
    private $transactionsRepository;

    public function __construct(PaymentsTransactionsRepository $paymentsTransactionsRepo, TransactionsRepository $transactionsRepo)
    {
        $this->paymentsTransactionsRepository = $paymentsTransactionsRepo;
        $this->transactionsRepository = $transactionsRepo;
    }

    /**
     * Display a listing of the PaymentsTransactions.
     */
    public function index(Request $request)
    {
        $paymentsTransactions = $this->paymentsTransactionsRepository->paginate(10);

        return view('payments_transactions.index')
            ->with('paymentsTransactions', $paymentsTransactions);
    }

    /**
     * Show the form for creating a new PaymentsTransactions.
     */
    public function create()
    {
        return view('payments_transactions.create');
    }

    /**
     * Store a newly created PaymentsTransactions in storage.
     */
    public function store(CreatePaymentsTransactionsRequest $request)
    {
        try {
            $input = $request->all();

            $paymentsTransactions = $this->paymentsTransactionsRepository->create($input);
            $this->transactionsRepository->updateStatusFromPayment($paymentsTransactions);
            Flash::success('Payments Transactions saved successfully.');

            return redirect(route('payments-transactions.index'));
        } catch (\Exception $e) {
            Flash::error('something_went_wrong');
            return redirect(route('payments-transactions.index'));
        }
    }

    /**
     * Display the specified PaymentsTransactions.
     */
    public function show($id)
    {
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            Flash::error('Payments Transactions not found');

            return redirect(route('paymentsTransactions.index'));
        }

        return view('payments_transactions.show')->with('paymentsTransactions', $paymentsTransactions);
    }

    /**
     * Show the form for editing the specified PaymentsTransactions.
     */
    public function edit($id)
    {
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            Flash::error('Payments Transactions not found');

            return redirect(route('paymentsTransactions.index'));
        }

        return view('payments_transactions.edit')->with('paymentsTransactions', $paymentsTransactions);
    }

    /**
     * Update the specified PaymentsTransactions in storage.
     */
    public function update($id, UpdatePaymentsTransactionsRequest $request)
    {
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            Flash::error('Payments Transactions not found');

            return redirect(route('paymentsTransactions.index'));
        }

        $paymentsTransactions = $this->paymentsTransactionsRepository->update($request->all(), $id);

        Flash::success('Payments Transactions updated successfully.');

        return redirect(route('paymentsTransactions.index'));
    }

    /**
     * Remove the specified PaymentsTransactions from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $paymentsTransactions = $this->paymentsTransactionsRepository->find($id);

        if (empty($paymentsTransactions)) {
            Flash::error('Payments Transactions not found');

            return redirect(route('paymentsTransactions.index'));
        }

        $this->paymentsTransactionsRepository->delete($id);

        Flash::success('Payments Transactions deleted successfully.');

        return redirect(route('paymentsTransactions.index'));
    }

    /**
     * Get Tasks For Datatable
     * @return \Illuminate\Http\JsonResponse
     */
    function getData()
    {
        try {
            $transactions = $this->paymentsTransactionsRepository->model()::with(['transaction']);
            return Datatables::of($transactions)
                ->editColumn('paid_on', function($resource) {
                    return Carbon::parse($resource->paid_on)->format('Y-m-d');
                })
                ->make(true);
        } catch (\Exception $e) {
            return $this->sendError('Something Went Wrong', 500);
        }
    }
}
