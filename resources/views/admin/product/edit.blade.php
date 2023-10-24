@extends('admin.layouts.app')

@section('title')
    Edit Product
@endsection

@section('content')

    <style>
        /* Style for the checkbox container */
        .checkbox-container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-top: 5px;
        }

        /* Hide the default checkbox input */
        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom checkbox design */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #ccc;
        }

        /* Style the custom checkbox when it's checked */
        .checkbox-container input:checked+.checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark symbol using a pseudo-element */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark symbol when the checkbox is checked */
        .checkbox-container input:checked+.checkmark:after {
            display: block;
        }

        /* Style the checkmark symbol itself */
        .checkbox-container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
    </style>


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Add Category </a> --}}
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif

        <!-- Content Row -->
        <div class="card m-auto"style=" width: 82%;background-color: #ececed6b;">
            <div class="col-6 m-auto">
                <form method="post" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name*</label>
                        <input required name="name" type="text" class="form-control" id="product_name"
                            value="{{ $product->name }}">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category*</label>
                        <select name="category_id" id="category" required class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Description*</label>
                        <textarea name="description" id="desc" class="form-control" cols="10" rows="4">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price*</label>
                        <input required name="price" type="text" class="form-control" id="price"
                            value="{{ $product->price }}">
                    </div>
                    <label for="images" class="form-label">Selected Images</label>
                    @foreach ($product->images as $image)
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="checkbox-container">
                                    <input name="removed_image[]" type="checkbox" class="form-check-input" value="{{ $image->id }}">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <img style="width: 10em; height: 10em;" src="{{ asset($image->image) }}" alt="img">
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        <input name="image[]" type="file" class="form-control" id="images" multiple>
                    </div>

                    <div class="mb-3">
                        <label for="product_slug" class="form-label">Product Slug*</label>
                        <input required name="slug" type="text" class="form-control" id="product_slug"
                            value="{{ $product->name }}">
                    </div>
                    <div class="mb-3 form-check">
                        <input {{ $product->status == 1 ? 'checked' : '' }} name="status" value="1" type="checkbox"
                            class="form-check-input" id="status">
                        <label class="form-check-label" for="staus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update product</button>
                </form>
            </div>
        </div>



    </div>
    <!-- /.container-fluid -->

@endsection

@section('script')
@endsection
