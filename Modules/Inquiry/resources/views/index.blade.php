@extends('inquiry::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('inquiry.name') !!}</p>
@endsection
