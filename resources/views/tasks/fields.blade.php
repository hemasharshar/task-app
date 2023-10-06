@push('third_party_stylesheets')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Assigned To Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('assigned_to_id', 'Assigned User:') !!}
    <select id="assigned_to_id" name="assigned_to_id" class="js-data-example-ajax form-control"></select>
{{--    {!! Form::text('assigned_to_id', null, ['class' => 'form-control', 'required']) !!}--}}
</div>

<!-- Assigned By Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('assigned_by_id', 'Admin Name:') !!}
    <select id="assigned_by_id" name="assigned_by_id" class="js-data-example-ajax form-control"></select>
{{--    {!! Form::text('assigned_by_id', null, ['class' => 'form-control']) !!}--}}
</div>


@push('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var $assigned_user = $("#assigned_to_id");

        $assigned_user.select2({
            ajax: {
                url: "{{ route('tasks.getUsers', 'user')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 1) < data.total
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for a user',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        var $assigned_admin = $("#assigned_by_id");
        $assigned_admin.select2({
            ajax: {
                url: "{{ route('tasks.getUsers', 'admin')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 1) < data.total
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for a user',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.text);

            return $container;
        }

        function formatRepoSelection (repo) {
            return repo.text;
        }

    </script>
@endpush
