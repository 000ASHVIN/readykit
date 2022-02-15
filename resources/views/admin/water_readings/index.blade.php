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
        <div class="col-sm-12 col-md-6">
            <h2 class="mb-0">Water Tank Readings</h2>
        </div>
        <div class="col-sm-12 col-md-6 breadcrumb-side-button">
            <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
                <a class="btn btn-primary btn-with-shadow" href="/admin/get-all-export-data">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg> Export All data
                </a>
            </div>
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
            <table id="water_reading_table" class="table mb-0">
                <thead>
                    <tr>
                        <th track-by="0" class="datatable-th pt-0">
                            <span class="font-size-default"><span> House Lot </span></span>
                        </th>
                        <th track-by="1" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Branch </span></span>
                        </th>
                        <th track-by="2" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Serial No</span></span>
                        </th>
                        <th track-by="3" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Curr. Reading</span></span>
                        </th>
                        <th track-by="4" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Last Reading</span></span>
                        </th>
                        <th track-by="4" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Date Submitted</span></span>
                        </th>
                        <th track-by="5" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Image</span></span>
                        </th>
                        <th track-by="6" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Create By</span></span>
                        </th>
                        <th track-by="7" class="datatable-th pt-0">
                            <span class="font-size-default"><span>Actions</span></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($water_readings as $reading)
                    <tr>
                        <td class="datatable-td">{{$reading->house_lot ? $reading->house_lot->house_lot : 'N/A' }}</td>
                        <td class="datatable-td">{{$reading->branch ? $reading->branch->name : 'N/A' }}</td>
                        <td class="datatable-td">{{$reading->serial_num }}</td>
                        <td class="datatable-td">{{$reading->current_reading ? (strlen($reading->current_reading) > 5 ? substr($reading->current_reading, 0, 5).'..' : $reading->current_reading ): 'N/A'  }}</td>
                        <td class="datatable-td">{{$reading->last_reading ? (strlen($reading->last_reading) > 5 ? substr($reading->last_reading, 0, 5).'..' : $reading->last_reading ): 'N/A'  }}</td>
                        <td class="datatable-td">{{ date('Y/m/d',strtotime($reading->created_at)) }}</td>
                        <td class="avatars-w-50 datatable-td"><img class="rounded-circle" src="{{ asset('storage\images\meter_readings\\'.$reading->image) }}" alt="parth"></td>
                        <td class="datatable-td">{{ $reading->user ? $reading->user->first_name : 'N/A' }}</td>
                        <td class="datatable-td" style="display: flex;"><a href="{{ route('admin.water_reading-edit',$reading->id) }}" type="button" class="btn btn-primary table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.water_reading-delete',$reading->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" type="button" class="btn btn-danger table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                            <a href="{{ route('admin.get_reading_info',$reading->id) }}" type="button" class="btn btn-info table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
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
        
        var table = $('#water_reading_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.water_readings.list') }}",
            columns: [
                {data: 'house_lot_num', name: 'house_lot.house_lot_num'},
                {data: 'branch', name:'branch.name'},
                {data: 'serial_num', name: 'house_lot.serial_num'},
                {data: 'current_reading'},
                {data: 'last_reading'},
                {data: 'created_at'},
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'first_name', name: 'users.first_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs: [
                {
                    "targets": 0,
                    "data": "house_lot_num",
                    "render": function ( data, type, row, meta ) {
                        return data ? data : 'N/A'
                    }
                },
                {
                    "targets": 1,
                    "data": "branch",
                    "render": function ( data, type, row, meta ) {
                        return data ? data : 'N/A'
                    }
                },
                {
                    "targets": 4,
                    "data": "last_reading",
                    "render": function ( data, type, row, meta ) {
                        return parseInt(data) > 0 ? data : '-'
                    }
                },
            ]
        });
        
    });
</script>
@endpush