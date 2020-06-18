@extends('layouts.dashboard')

@section('title', 'Products | ')

@section('content')

<div class="container-fluid">
    <div class="row">
        @if ($user->role == 'Owner')
              @include('partials._owner_sidebar')
        @else
              @include('partials._system_sidebar')
        @endif

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>Products</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('products.create') }}" class="btn btn-primary">New product</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($products) < 1)
            <div class="alert alert-info" sr-only="alert">
                No product.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Products ( Total: {{ count($products) }} )</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                            <td>{{ $product->name }} ( <i>{{ $product->payment }}</i> ) with {{ count($product->packages) }} packages</td>
                                <td class="text-right"><a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $products->links() }}
        @endif
    </div>
  </div>

@endsection