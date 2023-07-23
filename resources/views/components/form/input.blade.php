<!-- to define variable and default variable to pass to components-->
@props([
'type' => 'text',
'name',
'value' => '',
'label' => false,
])

<!-- {{$attributes}} to echo any un except attribute insert into input -->
<!-- {{$attributes}} to allow insert attributes into input  -->
<!-- the old('اسم الحقل',default value) -->
<div>
    @if($label)
    <label> {{$label}}</label>
    @endif
    <input type="{{$type}}" name="{{$name}}" value="{{ old($name ,$value ) }}" {{$attributes->class(['form-control','is-invalid'=> $errors->has($name)]) }}>
    @error($name)
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror
</div>