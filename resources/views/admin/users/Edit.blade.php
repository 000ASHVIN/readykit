@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<admin-user-edit :user="{{ json_Encode($user)}}"></admin-user-edit>
@endsection