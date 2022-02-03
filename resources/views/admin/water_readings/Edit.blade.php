@extends('layouts.app')

@section('title', 'Users Management')

@section('contents')
<admin-water_reading-edit :water_reading="{{ json_Encode($water_reading)}}">
</admin-water_reading-edit>
@endsection