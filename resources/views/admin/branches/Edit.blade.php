@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<admin-branch-edit :branch="{{ json_Encode($branch)}}">
</admin-branch-edit>
@endsection