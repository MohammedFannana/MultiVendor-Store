@extends('layouts.dashboard')

@section('title','Create Categoreis')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

<form action="{{route('dashboard.categories.store')}}" method="post" class="ml-3" enctype="multipart/form-data">
    @csrf

    <!-- to echo error result of validate -->
    <!-- @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif -->


    <div class="form-group">
        <x-form.input label="Category Name" name="name" type="text" />

        <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parent_id" class="form-control form-select">
                <option value="">Primary Category</option> <!--Value is empty to return null if choose the backend is handle with value-->

                @foreach($parents as $parent)
                <option value="{{$parent->id}}">{{$parent->name}}</option>
                @endforeach

            </select>

        </div>


        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control">{{old('description')}}</textarea>
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Status</label>
            <div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="active">
                    <label class="form-check-label" for="exampleRadios1">
                        Active
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="inactived">
                    <label class="form-check-label" for="exampleRadios2">
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