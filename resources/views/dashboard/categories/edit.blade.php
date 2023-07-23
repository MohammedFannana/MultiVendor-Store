@extends('layouts.dashboard')

@section('title','Edit Categoreis')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Edit Categories</li>

@endsection

@section('content')

<form action="{{route('dashboard.categories.update',$category->id)}}" method="post" class="ml-3" enctype="multipart/form-data"> <!-- you must use enctype if input type file-->
    @csrf
    @method('put')

    <div class="form-group">
        <label for="">Category Name</label>
        <!-- the old('اسم الحقل',default value) -->
        <input type="text" name="name" class="form-control" value="{{old('name', $category->name)}}" @class(['form-control','is-invalid'=> $errors->has('name')])> <!-- ?? if the first null event after ?? -->
    </div>

    <div class="form-group">
        <label for="">Category Parent</label>
        <select name="parent_id" class="form-control form-select">
            <option value="">Primary Category</option> <!--Value is empty to return null if choose the backend is handle with value-->

            @foreach($parents as $parent)
            <option value="{{$parent->id}}" @selected(old('parent_id',$category->parent_id) == $parent->id) > {{$parent->name}} </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" class="form-control">{{ old('description',$category->description)}}</textarea>
    </div>

    <div class="form-group">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control">
        @if($category->image)
        <img src="{{asset('storage/' . $category->image)}}" alt="" height="50">
        @endif
    </div>



    <div class="form-group">
        <label for="">Status</label>
        <div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="Radios1" value="active" @checked($category->status == 'active')>
                <label class="form-check-label" for="Radios1">
                    Active
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="Radios2" value="inactived" @checked($category->status == 'inactived')>
                <label class="form-check-label" for="Radios2">
                    Inactived
                </label>
            </div>

        </div>
    </div>



    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>




</form>

@endsection