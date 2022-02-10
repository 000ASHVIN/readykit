@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<div class="content-wrapper">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-12">
            <h2 class="mb-0">House Lots</h2>
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
            <table id="house_lots_table" class=" table mb-0">
                <thead>
                    <tr>
                        <th track-by="0" class="datatable-th pt-0">
                            <span class="font-size-default"><span> id </span></span>
                        </th>
                        <th track-by="1" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Serial No </span></span>
                        </th>
                        <th track-by="2" class="datatable-th pt-0">
                            <span class="font-size-default"><span> House Lot </span></span>
                        </th>
                        <th track-by="2" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Created on </span></span>
                        </th>
                        <th track-by="4" class="datatable-th pt-0">
                            <span class="font-size-default"><span> Actions </span></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($houselots as $houselot)
                    <tr>
                        <td>{{$houselot->id }}</td>
                        <td>{{$houselot->serial_num }}</td>
                        <td>{{$houselot->house_lot_num }}</td>
                        <td>{{ date('Y/m/d',strtotime($houselot->created_at)) }}</td>
                        <td class="datatable-td" style="display: flex;"><a href="{{ route('admin.houselot-edit',$houselot->id) }}" type="button" class="btn btn-primary table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.houselot-delete',$houselot->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" type="button" class="btn btn-danger table-btn mr-2 mb-2 mb-sm-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection