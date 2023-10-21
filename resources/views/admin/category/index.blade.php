@extends('admin.layouts.app')

@section('title')
    Category
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category</h1>
            <a href="{{ route('admin.category.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                Add Category </a>
        </div>

        <!-- Content Row -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td class="{{ $category->status == 1 ? 'text-success' : 'text-danger' }}">
                            {{ $category->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="row" style="gap:1em">
                                <a href="{{ route('admin.category.edit', $category->id) }}" type="button"
                                    class="btn btn-success">Edit</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#categoryDeleteModal{{ $category->id }}">Delete</button>
                                <!-- category delete Modal -->
                                <div class="modal fade" id="categoryDeleteModal{{ $category->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                    Category
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this category?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.category.destroy', $category->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-primary">Delete</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($categories) > 10)
            {{ $categories->links('vendor.pagination.bootstrap-4') }}
        @endif
    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')
@endsection
