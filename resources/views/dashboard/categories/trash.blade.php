@extends('layouts.dashboard')

@section('title','Trashed Categories')

@section('breadcrumb') <!--Override into parent page dashboard page not display section parent page to show parent section use @parent  -->
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Trash</li>


@endsection

@section('content')

<div class="mb-5 ml-3">
    <a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-primary mr-2"> Back </a>

</div>

<!-- check if the flash message send from categoriesController the massge in session -->

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
            <th>Status</th>
            <th>Deleted At</th>
            <th colspan="2"></th>
        </tr>
    </thead>

    <tbody>



        @forelse($categories as $category)

        <tr>
            <td><img src="{{asset('storage/'. $category->image)}}" alt="" height="50"></td>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->deleted_at}}</td>
            <td>

                <form action="{{route('dashboard.categories.restore',$category->id)}}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-outline-primary">Restore</button>

                </form>

            </td>

            <td>

                <form action="{{route('dashboard.categories.force-delete',$category->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>

                </form>


            </td>
        </tr>

        @empty

        <tr>
            <td colspan="7">No Categoreis defined.</td>
        </tr>

        @endforelse


    </tbody>
</table>

{{$categories->withQueryString()->links()}}

@endsection