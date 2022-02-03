@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<div id="app">
    <user-edit-reading :water_reading="{{$water_reading}}">
    </user-edit-reading>
</div>
@endsection