@extends('errors.minimal')

@section('title', __('Forbidden'))
@section('message')
    <img class="img-fluid mix-blend-multiply" src="/images/forbidden.jpg" alt="not found">
    <p>Sorry, forbidden page.</p>
    <a class="btn w-50 mt-5 text-white" style="background-color: red" href="{{ url('/') }}">Go back home</a>

@endsection