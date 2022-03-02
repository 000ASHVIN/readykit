@extends('layouts.app')

@section('title', 'Water Readings Management')

@push('after-styles')

@endpush

@section('contents')
<div class="content-wrapper">
    <admin-water-datatable></admin-water-datatable>
</div>
@endsection