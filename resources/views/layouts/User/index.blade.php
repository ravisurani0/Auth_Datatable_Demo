@extends('layouts.admin')

@section('main-content')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Users') }}</h1>
@if (session('msg'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('msg') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between py-3">
            <h6 class="m-0 font-weight-bold text-primary">User List</h6>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>

        </div>
        <div class="card-body">
            <table class="table table-bordered data-table" id="data-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead> 
                <tbody>
                </table>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(function() {
        var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: 
            [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },  {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: "d-flex w-100",
                    // render: function(data, type, row, meta) {
                    //     return `<div class=''>${data}</div>`;
                    // }

                },
        ]
        });
    });  
</script>
@endsection