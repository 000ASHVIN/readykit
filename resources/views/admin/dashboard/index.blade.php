@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
    <admin-dashboard :branches="{{ $branches }}"></admin-dashboard>
@endsection