@push('third_party_stylesheets')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="form-group col-sm-6">
    {!! Form::label('customer', 'Customer:') !!}
    <select id="customer" name="customer" class="js-data-example-ajax form-control"></select>
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Due Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('due_date', 'Due Date:') !!}
    {!! Form::date('due_date', null, ['class' => 'form-control','id'=>'due_date']) !!}
</div>

<!-- Vat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vat', 'Vat:') !!}
    {!! Form::text('vat', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Vat Inclusive Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vat_inclusive', 'Vat Inclusive:') !!}
    {!! Form::select('vat_inclusive', ['1' => 'Yes', '0' => 'No'], null, ['class' => 'form-control custom-select']) !!}
</div>

@push('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var $customer_id = $("#customer");

        $customer_id.select2({
            ajax: {
                url: "{{ route('getCustomers')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
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
            placeholder: 'Search for a Customer',
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
