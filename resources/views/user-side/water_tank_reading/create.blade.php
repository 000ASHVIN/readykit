@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<div id="app">
    <user-create-reading :user="{{ json_encode($user)}}"></user-create-reading>
</div>
@endsection