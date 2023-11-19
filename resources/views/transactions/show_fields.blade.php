<!-- Customer Field -->
<div class="col-sm-12">
    {!! Form::label('customer', 'Customer:') !!}
    <p>{{ $transactions->customer }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $transactions->amount }}</p>
</div>

<!-- Due Date Field -->
<div class="col-sm-12">
    {!! Form::label('due_date', 'Due Date:') !!}
    <p>{{ $transactions->due_date }}</p>
</div>

<!-- Vat Field -->
<div class="col-sm-12">
    {!! Form::label('vat', 'Vat:') !!}
    <p>{{ $transactions->vat }}</p>
</div>

<!-- Vat Inclusive Field -->
<div class="col-sm-12">
    {!! Form::label('vat_inclusive', 'Vat Inclusive:') !!}
    <p>{{ $transactions->vat_inclusive }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $transactions->status }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $transactions->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $transactions->updated_at }}</p>
</div>

