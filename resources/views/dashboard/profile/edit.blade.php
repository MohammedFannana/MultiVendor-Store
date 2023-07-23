@extends('layouts.dashboard')

@section('title','Edit Profile')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Profile</li>
<li class="breadcrumb-item active">Edit Profile</li>

@endsection

@section('content')

<x-alert type="success" />

<form action="{{route('dashboard.profile.update')}}" method="post" class="ml-3" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name" />
        </div>

        <div class="col-md-6">
            <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
        </div>
    </div>

    <div class="form-row">

        <div class="col-md-6">
            <x-form.input type="date" name="birthday" label="Birthday" :value="$user->profile->birthday" />
        </div>


        <div class="col-md-6">

            <label>Gender</label>

            <div class="d-flex " style="gap:30px">
                <div>
                    <input type="radio" name="gender" id="male" value="male" @checked($user->profile->gender == 'male') ">
                    <label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" name="gender" id="female" value="female" @checked($user->profile->gender == 'female')">
                    <label for="female">Female</label>
                </div>
            </div>

        </div>

    </div>

    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address" />
        </div>

        <div class="col-md-4">
            <x-form.input name="city" label="City" :value="$user->profile->city" />
        </div>

        <div class="col-md-4">
            <x-form.input name="state" label="State" :value="$user->profile->state" />
        </div>

    </div>



    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code" />
        </div>

        <div class="col-md-4">
            <x-input-label :value="__('Country')" />
            <x-form.select name="country" :options="$countries" :selected="$user->profile->country" />
        </div>

        <div class="col-md-4">
            <x-input-label :value="__('Locale')" />
            <x-form.select name="locale" :options="$locales" :selected="$user->profile->locale" />
        </div>
    </div>





    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>




</form>

@endsection