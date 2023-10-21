@extends('admin.layouts.app')

@section('title')
    Add product
@endsection

@section('content')


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add product</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Add product </a> --}}
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif

        <!-- Content Row -->
        <div class="card m-auto"style="height: 60vh; width: 82%;background-color: #ececed6b;">
            <div class="col-6 m-auto">
                <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name*</label>
                        <input required name="name" type="text" class="form-control" id="product_name">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category*</label>
                        <select name="category_id" id="category" required class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Description*</label>
                        <textarea name="description" id="desc" class="form-control" cols="10" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price*</label>
                        <input required name="price" type="text" class="form-control" id="price">
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Images*</label>
                        <input required name="image[]" type="file" class="form-control"
                            id="images" multiple>
                    </div>

                    <div class="mb-3">
                        <label for="product_slug" class="form-label">Product Slug*</label>
                        <input required name="slug" type="text" class="form-control" id="product_slug">
                    </div>
                    <div class="mb-3 form-check">
                        <input checked name="status" value="1" type="checkbox" class="form-check-input"
                            id="status">
                        <label class="form-check-label" for="staus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Add product</button>
                </form>
            </div>
        </div>



    </div>
    <!-- /.container-fluid -->



@endsection

@section('script')
@endsection
