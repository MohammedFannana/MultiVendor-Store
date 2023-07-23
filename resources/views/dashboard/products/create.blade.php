@extends('layouts.dashboard')

@section('title','Edit Products')

@section('breadcrumb') <!--Override into parent page dashboard page not display section parent page to show parent section use @parent  -->
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">Create Products</li>


@endsection

@section('content')


<!-- invoke component alert components -->
<x-alert type="success" />

<form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data" class="m-3">
    @csrf
    @include('dashboard.products._form')

</form>

@endsection