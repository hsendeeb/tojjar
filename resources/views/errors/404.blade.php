@extends('errors.minimal')

@section('title', __('Not Found'))
@section('message')
    <img class="img-fluid mix-blend-multiply" src="/images/notFound.jpg" alt="not found">
    <p>Sorry, the page you are looking for could not be found.</p>
    <a class="btn w-50 mt-5 text-white" style="background-color: red" href="{{ url('/') }}">Go back home</a>

@endsection

