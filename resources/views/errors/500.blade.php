@extends('errors.minimal')

@section('title', __('Server Error'))
@section('message')
    <img class="img-fluid mix-blend-multiply" src="/images/serverError.jpg" alt="not found">
    <p>Sorry,we have problem on our server.</p>
    <a class="btn w-50 mt-5 text-white" style="background-color: red" href="{{ url('/') }}">Go back home</a>

@endsection