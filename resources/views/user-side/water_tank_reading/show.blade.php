@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<div id="app">
    <user-show-reading :house_lot="{{$house_lot}}" :branch="{{$branch}}" :water_reading="{{$water_reading}}">
    </user-show-reading>
</div>
@endsection