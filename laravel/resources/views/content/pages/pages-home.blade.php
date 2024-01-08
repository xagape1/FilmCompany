@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')

@role('admin|pay')

@include('movies.index')

@endrole

@endsection