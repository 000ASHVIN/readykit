@extends('layouts.app')

@section('title', 'Users Management')

@push('after-styles')
    <style>
        .datatable .btn {
            height: 28px !important;
        }
        .datatable svg {
            height: 14px !important;
        }
        
        .datatable td {
            padding: 10px 30px 10px 15px;
            vertical-align: middle;
        } 
        .datatable td:first-child {
            padding: 10px 30px;
        }
    </style>
@endpush

@section('contents')
<div class="content-wrapper">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-12">
            <h2 class="mb-0">USers</h2>
        </div>
    </div>
    <div class="datatable">
        <div class="
          table-responsive
          custom-scrollbar
          table-view-responsive
          shadow
          pt-primary
        ">

            <table id="users_table" class="table mb-0">
                <thead>
                    <tr>
                        <th track-by="0" class="datatable-th pt-0">
                            <span class="font-size-default"><span> id </span></span>
                        </th>
                        <th track-by="1" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Name </span></span>
                        </th>
                        <th track-by="2" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Email </span></span>
                        </th>
                        <th track-by="3" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Branch</span></span>
                        </th>
                        <th track-by="3" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Status</span></span>
                        </th>
                        <th track-by="4" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Actions </span></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($users as $user)
                    <tr>
                        <td class="datatable-td">{{$user->id }}</td>
                        <td class="datatable-td">{{$user->full_name }}</td>
                        <td class="datatable-td">{{$user->email }}</td>
                        <td class="datatable-td">{{$user->status_id == 1 ?'Active': 'Inactive' }}</td>
                        <td class="datatable-td" style="display: flex;">
                            <a href="{{ route('admin.user-edit',$user->id) }}" type="button" class="btn btn-primary table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.user-delete',$user->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" type="button" class="btn btn-danger table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@push('after-scripts')
<script type="text/javascript">
    $(function () {
        
        var table = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.list') }}",
            columns: [
                {data: 'id'},
                {data: 'first_name'},
                {data: 'email'},
                {data: 'branch', name:'branch.name'},
                {data: 'status', name: 'status_id'},
                // {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs: [
                {
                    "targets": 3,
                    "data": "branch",
                    "render": function ( data, type, row, meta ) {
                        return data ? data : 'N/A'
                    }
                },
            ]
        });
        
    });
</script>
@endpush