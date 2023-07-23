@extends('layouts.dashboard')

@section('title','Categories')

@section('breadcrumb') <!--Override into parent page dashboard page not display section parent page to show parent section use @parent  -->
@parent
<li class="breadcrumb-item active">Categories</li>

@endsection

@section('content')

<div class="mb-5 ml-3">
    <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-primary"> Create </a>
    <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-primary"> Trash </a>

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
            <th>Parent</th>
            <th>Products #</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>

    <tbody>

        <!-- @if($categories->count())  $categories is object you can not use the empty() beacaue the object always return true to slve problem use count() 
            @foreach($categories as $category)
                <tr>
                    <td></td>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->parent_id}}</td>
                    <td>{{$category->created_at}}</td>
                    <td>
                        <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-sm btn-success">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>

                        </form>

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">No Categoreis defined.</td>
            </tr>  
        @endif     OR use forelse  -->

        @forelse($categories as $category)

        <tr>
            <td><img src="{{asset('storage/' . $category->image)}}" alt="" height="50"></td>
            <td> {{$category->id}} </td>
            <td> <a href="{{route('dashboard.categories.show',$category->id)}}">{{$category->name}} </a></td>
            <td>{{$category->parent_name}}</td>

            <!-- to show count name of function relationship Name_count -->
            <td>{{$category->products_count}}</td>
            <td>{{$category->status}}</td>

            <td>{{$category->created_at}}</td>
            <td>

                <!-- [$category->id,....] or ['category  parameterName' => $category->id, ...] -->
                <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-sm btn-success">Edit</a>
            </td>

            <td>

                <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>

                </form>


            </td>
        </tr>

        @empty

        <tr>
            <td colspan="8">No Categoreis defined.</td>
        </tr>

        @endforelse


    </tbody>
</table>

{{$categories->withQueryString()->links()}}

@endsection