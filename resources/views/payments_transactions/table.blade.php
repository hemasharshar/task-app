@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush
<div class="card-body p-3">
    <div class="">
        <table class="table" id="payments-transactions-table">
            <thead>
            <tr>
                <th>Transaction Id</th>
                <th>Amount</th>
                <th>Paid On</th>
                <th>Details</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $paymentsTransactions])
        </div>
    </div>
</div>


@push('third_party_scripts')
    @include('layouts.datatables_js')
    <script>
        $(function () {
            var dataTableTable = $('#payments-transactions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('paymentsTransactions.getData') }}",
                    "type": "get"
                },
                columns: [
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'paid_on', name: 'paid_on'},
                    {data: 'details', name: 'details'},
                ]
            });
        });
    </script>
@endpush
