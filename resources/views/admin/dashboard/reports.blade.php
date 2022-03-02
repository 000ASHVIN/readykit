@extends('layouts.app')

@section('title', 'Reports by area')

@section('contents')
    <admin-reports :areas="{{ $areas }}"></admin-reports>
@endsection