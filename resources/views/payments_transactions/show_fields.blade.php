<!-- Transaction Id Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_id', 'Transaction Id:') !!}
    <p>{{ $paymentsTransactions->transaction_id }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $paymentsTransactions->amount }}</p>
</div>

<!-- Paid On Field -->
<div class="col-sm-12">
    {!! Form::label('paid_on', 'Paid On:') !!}
    <p>{{ $paymentsTransactions->paid_on }}</p>
</div>

<!-- Details Field -->
<div class="col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    <p>{{ $paymentsTransactions->details }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $paymentsTransactions->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $paymentsTransactions->updated_at }}</p>
</div>

