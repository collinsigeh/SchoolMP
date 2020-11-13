@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @if ($user->usertype == 'Client')
        @include('partials._clients_sidebar')
      @else
        @if ($user->role == 'Director')
            @include('partials._directors_sidebar')
        @endif
        @if ($user->role == 'Staff')
            @include('partials._staff_sidebar')
        @endif
      @endif

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>{{ $term->name }} Fees and Other Items {!! ' - <small>'.$term->session.'</small>' !!}</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_class_arms == 'Yes')
                    <a href="{{ route('items.create') }}" class="btn btn-primary">New item</a>
                  @endif
              @else
                  <a href="{{ route('items.create') }}" class="btn btn-primary">New item</a>
              @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fees and other items</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fees and other items</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($items) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Nature</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                  @php
                                      if($item->schoolclass_id > 0)
                                      {
                                        echo 'All classes';
                                      }
                                      else
                                      {
                                        echo $item->schoolclass->name;
                                      }
                                  @endphp
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->nature }}</td>
                                <td class="text-right"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $items->links() }}
        @endif
    </div>
  </div>

@endsection