@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<admin-area-edit :area="{{ json_Encode($area)}}">
</admin-area-edit>
@endsection