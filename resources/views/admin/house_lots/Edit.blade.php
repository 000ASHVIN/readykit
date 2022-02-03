@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<admin-house_lot-edit :houselot="{{ json_Encode($houselot)}}">
</admin-house_lot-edit>
@endsection