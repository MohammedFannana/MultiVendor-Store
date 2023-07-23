<!-- to define variable and default variable to pass to components-->
@props([
'name',
'options',
'selected' =>null,
])

<select name="{{$name}}" {{$attributes->class(['form-control','form-select','is-invalid'=> $errors->has($name)]) }} style="width:100%; border-radius: 0.375rem;    border-color: rgb(209 213 219);">

    @foreach($options as $value => $text)
    <option value="{{ $value }}" @selected($value==$selected)> {{$text}} </option>
    @endforeach
</select>

<x.form.validation-feedback :name="$name" />