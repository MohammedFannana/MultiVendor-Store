@extends('layouts.dashboard')

@section('title','Products')

@section('breadcrumb') <!--Override into parent page dashboard page not display section parent page to show parent section use @parent  -->
@parent
<li class="breadcrumb-item active">Products</li>

@endsection

@section('content')

<div class="mb-5 ml-3">
    <a href="{{route('dashboard.products.create')}}" class="btn btn-sm btn-outline-primary"> Create </a>

</div>


<!-- invoke component alert components -->
<x-alert type="success" />

<!-- Start Filter Serach -->
<form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <input name="name" placeholder="Name" class="form-control mx-2" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active">Active</option>
        <option value="inactive">InActive</option>

    </select>

    <button class="btn btn-dark mx-2">Filter</button>

</form>

<!-- End Filter Serach -->



<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>

    <tbody>

        @forelse($products as $product)

        <tr>
            <td><img src="{{asset('storage/' . $product->image)}}" alt="" height="50"></td>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <!-- use relationship Category , Store =>is proparty  function in products Models -->
            <td>{{$product->category->name}}</td>
            <td>{{$product->store->name}}</td>
            <td>{{$product->status}}</td>
            <td>{{$product->created_at}}</td>
            <td>

                <!-- [$category->id,....] or ['category  parameterName' => $category->id, ...] -->
                <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-sm btn-success">Edit</a>
            </td>

            <td>

                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>

                </form>


            </td>
        </tr>

        @empty

        <tr>
            <td colspan="9">No products defined.</td>
        </tr>

        @endforelse


    </tbody>
</table>

{{$products->withQueryString()->links()}}

@endsection