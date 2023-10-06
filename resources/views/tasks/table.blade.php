@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="card-body p-3">
    <div class="">
        <table class="table" id="tasks-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>assigned name</th>
                <th>admin name</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('third_party_scripts')
    @include('layouts.datatables_js')
    <script>
        $(function () {
            var dataTableTable = $('#tasks-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('tasks.getData') }}",
                    "type": "get"
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'admin.name', name: 'admin.name'}

                ]
            });
        });
    </script>
@endpush
