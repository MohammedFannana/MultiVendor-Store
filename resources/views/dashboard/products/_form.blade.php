<div class="form-group">
    <x-form.input name="name" label="Product Name" role="input" :value="$product->name" />
</div>

<div class="form-group">
    <label> Category Parent</label>
    <select name="parent_id" class="form-control form-select @is-invalid => $errors->has(category_id)">
        <option value="">Primary Category</option>
        @foreach(App\Models\Category::all() as $category)
        <option value="{{$category->id}}" @selected(old('parent_id', $product->category_id) == $category->id)>{{$category->name}}</option>
        @endforeach

    </select>
</div>

<div class="form-group">
    <label>Description</label>
    <!-- $product from compact from Product Controller -->
    <x-form.textarea name="description" :value="$product->description" />
</div>


<div class="form-group">
    <label>Image</label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" alt="" height="60" />
    @endif
</div>

<div class="form-group">
    <x-form.input name="price" label="Price" :value="$product->price" />
</div>

<div class="form-group">
    <x-form.input name="compare_price" label="Compare Price" :value="$product->compare_price" />
</div>

<div class="form-group">
    <!-- :value == value = "{{}}" -->
    <x-form.input name="tags" label="Tags" :value="$tags" />
</div>

<div class="form-group">

    <label>Status</label>

    <div>
        <input type="radio" name="status" id="active" value="active" @checked($product->status == 'active') ">
        <label for="active">Active</label>
    </div>

    <div>
        <input type="radio" name="status" id="draft" value="draft" @checked($product->status == 'draft') ">
        <label for="draft">Draft</label>
    </div>

    <div>
        <input type="radio" name="status" id="archvied" value="archvied" @checked($product->status == 'archvied')">
        <label for="archvied">Archvied</label>
    </div>

</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{$button_lable??'save'}}</button>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
    // name in input
    var inputElm = document.querySelector('[name=tags]'),
        tagify = new Tagify(inputElm);
</script>
@endpush