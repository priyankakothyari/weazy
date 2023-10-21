@extends('admin.layouts.app')

@section('title')
    Edit Category
@endsection

@section('content')


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Add Category </a> --}}
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif

        <!-- Content Row -->
        <div class="card m-auto"style="height: 60vh; width: 82%;background-color: #ececed6b;">
            <div class="col-6 m-auto">
                <form method="post" action="{{ route('admin.category.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name*</label>
                        <input required value="{{ $category->name }}" name="name" type="text" class="form-control"
                            id="category_name">
                    </div>

                    <div class="mb-3">
                        <label for="category_slug" class="form-label">Category Slug*</label>
                        <input required value="{{ $category->slug }}" name="slug" type="text" class="form-control"
                            id="category_slug">
                    </div>
                    <div class="mb-3 form-check">
                        <input {{ $category->status == 1 ? 'checked' : '' }} name="status" value="1" type="checkbox"
                            class="form-check-input" id="status">
                        <label class="form-check-label" for="staus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>



    </div>
    <!-- /.container-fluid -->

@endsection

@section('script')
@endsection
