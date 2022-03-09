@extends('layouts.app')

@section('title', 'Users Management')
@section('contents')
<div class="content-wrapper">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-6">
            <h2 class="mb-0">Water Tank Readings</h2>
        </div>
        <export :branch_id="{{$branch_id}}"></export>
        <div class="col-sm-12">
            <div class="float-right">
                <a class="btn btn-info btn-with-shadow" href="/admin/water_readings/branch/export/{{$branch_id}}/all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg> Export All Data
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
          pt-primary">
        <div id="id" class="mt-3 mb-3 mr-3 ml-3">
            <admin-water-readings-branch :branch_id="{{$branch_id}}" />
        </div>
        </div>
    </div>
</div>
@endsection
