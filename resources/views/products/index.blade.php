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
            <div class="collins-bg-white">
                <div class="table-responsive">    
                <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th colspan="2">Products ( Total: {{ count($products) }} )</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td style="width: 50px;"><a class="collins-link-within-table" href="{{ route('products.show', $product->id) }}"><img src="{{ config('app.url') }}/images/icons/product_icon.png" alt="product_icon" class="collins-table-item-icon"></a></td>
                                    <td style="vertical-align: middle; padding: 10px 0"><a class="collins-link-within-table" href="{{ route('products.show', $product->id) }}">{{ $product->name }}<br /><span class="badge badge-secondary">{{ $product->payment }}</span></a></td>
                                    <td style="vertical-align: middle"><a class="collins-link-within-table" href="{{ route('products.show', $product->id) }}">{{ count($product->packages) }} packages</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        @endif
    </div>
  </div>

@endsection