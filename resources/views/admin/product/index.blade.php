@extends('admin.layouts.app')

@section('title')
    product
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">product</h1>
            <a href="{{ route('admin.product.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                Add product </a>
        </div>

        <!-- Content Row -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->slug }}</td>
                        <td class="{{ $product->status == 1 ? 'text-success' : 'text-danger' }}">
                            {{ $product->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="row" style="gap:1em">
                                <a href="{{ route('admin.product.edit', $product->id) }}" type="button"
                                    class="btn btn-success">Edit</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#productDeleteModal{{ $product->id }}">Delete</button>
                                <!-- product delete Modal -->
                                <div class="modal fade" id="productDeleteModal{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete
                                                    product
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this product?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.product.destroy', $product->id) }}"
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
        @if (count($products) > 10)
            {{ $products->links('vendor.pagination.bootstrap-4') }}
        @endif
    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')
@endsection
