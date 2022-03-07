@extends('layouts.app')

@section('title', 'Users Management')
@section('contents')
<div class="content-wrapper">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-6">
            <h2 class="mb-0">Water Tank Readings</h2>
        </div>
        <export></export>        
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
