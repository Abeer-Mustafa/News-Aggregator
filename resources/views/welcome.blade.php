@extends('layouts/app' )

@section('content')

<div class="row">
        <x-news-org></x-news-org>
        <x-nytimes></x-nytimes>
        <x-the-guardian></x-the-guardian>
    </div>
</div>


<div class="card" style="padding: 0 10px">
    <div class="card-datatable table-responsive">
        <table id="records_table" class="table table-hover">
            <thead class="border-top">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>NEWS_API</th>
                    <th>URL</th>
                    <th>DATE</th>
                    <th>CATEGORY</th>
                    <th>SOURCE</th>
                    <th>AUTHOR</th>
                    <th>TITLE</th>
                    <th>DESCRIPTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection


@push('AJAX')

<script type="text/javascript">
$(document).ready(function () {
    // datatable
    load_datatable({
        'url' : "{{ route('index') }}",
        'columns' : [
            {data: 'id', sortable: false},
            {data: 'id', name: 'id', render: function (data, type, full, meta) {return `<strong>${data}</strong>`;}},
            {data: 'news_api', name: 'news_api'},
            {data: 'url', name: 'url'},
            {data: 'date', name: 'date'},
            {data: 'category', name: 'category'},
            {data: 'source', name: 'source'},
            {data: 'author', name: 'author'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
        ],
        'buttons' : {
            'export' : true,
        },
        'file_name' : 'news',
        'columnDefs' : [
            {
                targets: 3,
                render: function (data, type, full, meta) {
                    return `<a class="btn btn-outline-info btn-sm" href="${full['url']}" target="_blank">View</a>`;
                }
            }
        ]
    })
});

</script>

@endpush
