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
          <h3>{{ $this_staff->user->name }} ( {{ $this_staff->designation }} )</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $this_staff->user->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $this_staff->user->name }}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="alert alert-info">
            Here's the registered information for <strong>{{ $this_staff->user->name }} ({{ $this_staff->designation }})</strong>.
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Staff Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="{{ config('app.url') }}/images/profile/{{ $this_staff->user->pic }}" alt="Photo" class="user-pic" >
                            </div>
                        </div>
                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th class="bg-light">Name:</th>
                                    <td>
                                        {{ $this_staff->user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Gender:</th>
                                    <td>
                                        {{ $this_staff->user->gender }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Designation:</th>
                                    <td>
                                        {{ $this_staff->designation }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Employee number:</th>
                                    <td>
                                        {{ $this_staff->employee_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Employee since:</th>
                                    <td>
                                        {{ $this_staff->employee_since }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Qualification:</th>
                                    <td>
                                        {{ $this_staff->qualification }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Phone:</th>
                                    <td>
                                        {{ $this_staff->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email:</th>
                                    <td>
                                        {{ $this_staff->user->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Address:</th>
                                    <td>
                                        {{ $this_staff->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status:</th>
                                    <td>
                                        {{ $this_staff->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Account created at:</th>
                                    <td>
                                        <small>{{ $this_staff->created_at }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
        
                <div class="resource-details">
                    <div class="title">
                        Staff Privileges
                    </div>
                    <div class="body">
                        <div class="table-responsive">    
                            <table class="table table-striped table-hover table-sm">
                                <tbody>
                                    <tr>
                                        <td width="280px;">Can manage staff account & privileges:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_staff_account == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage all results (e.g. Principal):</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_all_results == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage student account:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_students_account == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage student promotion:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_students_promotion == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage student privileges:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_students_privileges == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage fees & products:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_fees_products == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage received payments:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_received_payments == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage expenses & payout requests:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_requests == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage finance report:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_finance_report == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage other reports:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_other_reports == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage subscriptions:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_subscriptions == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage calendars & Information:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_calendars == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage session terms:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_session_terms == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage class arms:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_class_arms == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage subjects:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_subjects == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Can manage parent / guardians:</td>
                                        <td>
                                            <p>
                                                @if ($this_staff->manage_guardians == 'Yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        More options
                    </div>
                    <div class="body">
                      <div class="table-responsive">    
                        <table class="table">
                            <tr>
                              <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('staff.edit', $this_staff->id) }}">Edit details</a></td>
                            </tr>
                            @if ($user->id !== $this_staff->user_id)
                                <tr>
                                    <td>
                                        <form method="POST" action="{{ route('staff.destroy', $this_staff->id) }}">
                                            @csrf
                                            @method('DELETE')
                        
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} required>
                        
                                                        <label class="form-check-label" for="remember">
                                                            {{ __('Check to delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        {{ __('Yes, delete staff') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </div>

@endsection