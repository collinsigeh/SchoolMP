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
            <h3>Class arms</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_class_arms == 'Yes')
                    <a href="{{ route('arms.create') }}" class="btn btn-primary">New arm</a>
                  @endif
              @else
                  <a href="{{ route('arms.create') }}" class="btn btn-primary">New arm</a>
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
                <li class="breadcrumb-item active" aria-current="page">Class arms</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Class arms</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($arms) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
          <div class="collins-bg-white">
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Specific classes</th>
                            <th>Class teacher</th>
                            <th>No. of students</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arms as $arm)
                            <tr>
                                <td><a href="{{ route('arms.show', $arm->id) }}" class="collins-link-within-table"><img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="collins-table-item-icon"> {{ $arm->schoolclass->name.' '.$arm->name }}</a></td>
                                <td style="padding-top: 13px;">
                                  @php
                                      if($arm->user_id > 0)
                                      {
                                        echo '<a href="'.route('staff.show', $arm->user->staff->id).'" class="collins-link-within-table"><span class="badge badge-secondary">'.$arm->user->name.'</span></a>';
                                      }
                                      else
                                      {
                                        echo '<span class="badge badge-danger">No class teacher</span>';
                                      }
                                  @endphp
                                </td>
                                <td style="padding-top: 13px;"><span class="badge badge-secondary">{{ count($arm->enrolments) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $arms->links() }}
          </div>
        @endif
    </div>
  </div>

@endsection