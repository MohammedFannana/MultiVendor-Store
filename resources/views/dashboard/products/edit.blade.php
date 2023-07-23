@extends('layouts.dashboard')

@section('title','Edit Products')

@section('breadcrumb') <!--Override into parent page dashboard page not display section parent page to show parent section use @parent  -->
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">Edit Products</li>


@endsection

@section('content')


<!-- invoke component alert components -->
<x-alert type="success" />

<form action="{{route('dashboard.products.update',$product->id)}}" method="post" enctype="multipart/form-data" class="m-3">
    @csrf
    @method('put')

    @include('dashboard.products._form')

</form>

@endsection