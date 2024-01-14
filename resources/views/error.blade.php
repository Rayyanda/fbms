@extends('template')
@section('title','Error Page')
@section('content')
    <div class="container-xxl" style="min-height:600px" >
        <h1>Error - {{ $message }}</h1>
        <p>Please re-sign in the url or click some menu</p>
    </div>
@endsection