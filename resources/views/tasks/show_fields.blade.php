<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $task->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $task->description }}</p>
</div>

<!-- Assigned To Id Field -->
<div class="col-sm-12">
    {!! Form::label('assigned_to_id', 'Assigned To Id:') !!}
    <p>{{ $task->assigned_to_id }}</p>
</div>

<!-- Assigned By Id Field -->
<div class="col-sm-12">
    {!! Form::label('assigned_by_id', 'Assigned By Id:') !!}
    <p>{{ $task->assigned_by_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $task->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $task->updated_at }}</p>
</div>

