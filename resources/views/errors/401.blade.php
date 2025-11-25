@extends('errors.minimal')

@section('title', __('Unauthorized'))
@section('message')
    <img class="w-75 mx-auto mix-blend-multiply" src="/images/unauthorized.jpg" alt="unauthorized">
    <p>Sorry, you are restricted to access this page.</p>
    <a class="btn w-100 mt-5 text-white" style="background-color: red" href="{{ url('/') }}">Go back home</a>

@endsection
