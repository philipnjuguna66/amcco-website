@extends('errors::minimal')

@section('title', __('Service Unavailable'))

<h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Under Maintenance </h1>

@section('code', '503')
@section('message', __('Service Unavailable'))
