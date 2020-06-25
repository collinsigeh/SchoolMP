@extends('layouts.dashboard')

@section('title', 'Product package details | ')

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
          <h3>{{ $package->product->name }} ( <i>{{ $package->product->payment.' '.$package->name }}</i> )</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
              <li class="breadcrumb-item"><a href="{{ route('products.show', $package->product->id) }}">{{ $package->product->name }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $package->product->payment.' '.$package->name }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Product Package Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-2">
                                Name:
                            </div>
                            <div class="col-md-10">
                                <h4>{{ $package->product->name }} ( <i>{{ $package->product->payment.' '.$package->name }}</i> )</h4>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Price:
                            </div>
                            <div class="col-md-10">
                                {{ $setting->base_currency_symbol.' '.$package->price }} ( <i>{{ $package->price_type }}</i> )
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Student limit:
                            </div>
                            <div class="col-md-10">
                                {{ $package->product->student_limit }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Features:
                            </div>
                            <div class="col-md-10">
                                {!! $package->product->features !!}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Term limit:
                            </div>
                            <div class="col-md-10">
                                {{ $package->term_limit }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Day limit:
                            </div>
                            <div class="col-md-10">
                                {{ $package->day_limit }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Status:
                            </div>
                            <div class="col-md-10">
                                {{ $package->status }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <small>Created since:</small>
                            </div>
                            <div class="col-md-10">
                                <small>{{ $package->created_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        Package options
                    </div>
                    <div class="body">
                      <div class="table-responsive">    
                        <table class="table">
                            <tr>
                                <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-block btn-outline-primary">Edit package</a>
                            </tr>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="more-options">
            <div class="head">More options</div>
            <div class="body">
                <div class="option">
                <form method="POST" action="{{ route('packages.destroy', $package->id) }}">
                    @csrf
                    @method('DELETE')

                    <h5>Delete product package</h5>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Yes') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-danger">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
  </div>

@endsection
