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
          <h3>Edit staff details</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
              <li class="breadcrumb-item"><a href="{{ route('staff.show', $this_staff->id) }}">{{ $this_staff->user->name }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('staff.update', $this_staff->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group row"> 
                    <div class="col-md-6 offset-md-4 text-left">
                        <img src="{{ config('app.url') }}/images/profile/{{ $this_staff->user->pic }}" alt="Photo" class="user-pic">
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Employment Details
                    </div>
                    <div class="body">
                        <div class="form-group row"> 
                            <label for="designation" class="col-md-4 col-form-label text-md-right">{{ __('Designation') }}</label>

                            <div class="col-md-6">
                                <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ $this_staff->designation }}" required autocomplete="designation" autofocus>
                                <small class="text-muted">E.g. Principal, Bursar, Subject Teacher, etc.</small>

                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="employee_number" class="col-md-4 col-form-label text-md-right">{{ __('Employee Number') }}</label>

                            <div class="col-md-6">
                                <input id="employee_number" type="text" class="form-control @error('employee_number') is-invalid @enderror" name="employee_number" value="{{ $this_staff->employee_number }}" required autocomplete="employee_number" autofocus>

                                @error('employee_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="employee_since" class="col-md-4 col-form-label text-md-right">{{ __('Employee Since (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="employee_since" type="text" class="form-control @error('employee_since') is-invalid @enderror" name="employee_since" value="{{ $this_staff->employee_since }}" autocomplete="employee_since" autofocus>
                                <small class="text-muted">E.g. 4th January, 2020</small>

                                @error('employee_since')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('status') }}</label>

                            <div class="col-md-6">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required autocomplete="status" autofocus>
                                    <option value="Active" @if ($this_staff->status == 'Active')
                                        {{ 'selected' }}
                                    @endif>Active</option>
                                    <option value="Inactive" @if ($this_staff->status == 'Inactive')
                                        {{ 'selected' }}
                                    @endif>Inactive</option>
                                </select>

                                @error('manage_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Personal Details
                    </div>
                    <div class="body">
                        <div class="form-group row"> 
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $this_staff->user->name }}" disabled autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <input id="gender" type="text" class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ $this_staff->user->gender }}" disabled autocomplete="gender" autofocus>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $this_staff->phone }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $this_staff->user->email }}" disabled autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $this_staff->address }}" autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="qualification" class="col-md-4 col-form-label text-md-right">{{ __('Qualification (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ $this_staff->qualification }}" autocomplete="qualification" autofocus>

                                @error('qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Employee Privileges
                    </div>
                    <div class="body">
                        <div class="form-group row"> 
                            <label for="manage_staff_account" class="col-md-4 col-form-label text-md-right">{{ __('Manage Staff Account & Privileges') }}</label>

                            <div class="col-md-6">
                                <select id="manage_staff_account" class="form-control @error('manage_staff_account') is-invalid @enderror" name="manage_staff_account" required autocomplete="manage_staff_account" autofocus>
                                    <option value="No" @if ($this_staff->manage_staff_account == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_staff_account == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_staff_account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_all_results" class="col-md-4 col-form-label text-md-right">{{ __('Manage all results (e.g. Principal)') }}</label>

                            <div class="col-md-6">
                                <select id="manage_all_results" class="form-control @error('manage_all_results') is-invalid @enderror" name="manage_all_results" required autocomplete="manage_all_results" autofocus>
                                    <option value="No" @if ($this_staff->manage_all_results == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_all_results == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_all_results')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="manage_students_account" class="col-md-4 col-form-label text-md-right">{{ __('Manage Student\'s Account') }}</label>

                            <div class="col-md-6">
                                <select id="manage_students_account" class="form-control @error('manage_students_account') is-invalid @enderror" name="manage_students_account" required autocomplete="manage_students_account" autofocus>
                                    <option value="No" @if ($this_staff->manage_students_account == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_students_account == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_students_account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_students_promotion" class="col-md-4 col-form-label text-md-right">{{ __('Manage Students Promotion') }}</label>

                            <div class="col-md-6">
                                <select id="manage_students_promotion" class="form-control @error('manage_students_promotion') is-invalid @enderror" name="manage_students_promotion" required autocomplete="manage_students_promotion" autofocus>
                                    <option value="No" @if ($this_staff->manage_students_promotion == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_students_promotion == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_students_promotion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_students_privileges" class="col-md-4 col-form-label text-md-right">{{ __('Manage Students Privileges') }}</label>

                            <div class="col-md-6">
                                <select id="manage_students_privileges" class="form-control @error('manage_students_privileges') is-invalid @enderror" name="manage_students_privileges" required autocomplete="manage_students_privileges" autofocus>
                                    <option value="No" @if ($this_staff->manage_students_privileges == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_students_privileges == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_students_privileges')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_fees_products" class="col-md-4 col-form-label text-md-right">{{ __('Manage Fees & Products') }}</label>

                            <div class="col-md-6">
                                <select id="manage_fees_products" class="form-control @error('manage_fees_products') is-invalid @enderror" name="manage_fees_products" required autocomplete="manage_fees_products" autofocus>
                                    <option value="No" @if ($this_staff->manage_fees_products == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_fees_products == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_fees_products')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_received_payments" class="col-md-4 col-form-label text-md-right">{{ __('Manage Received Payments') }}</label>

                            <div class="col-md-6">
                                <select id="manage_received_payments" class="form-control @error('manage_received_payments') is-invalid @enderror" name="manage_received_payments" required autocomplete="manage_received_payments" autofocus>
                                    <option value="No" @if ($this_staff->manage_received_payments == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_received_payments == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_received_payments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_requests" class="col-md-4 col-form-label text-md-right">{{ __('Manage Expenses & Payout Requests') }}</label>

                            <div class="col-md-6">
                                <select id="manage_requests" class="form-control @error('manage_requests') is-invalid @enderror" name="manage_requests" required autocomplete="manage_requests" autofocus>
                                    <option value="No" @if ($this_staff->manage_requests == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_requests == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_requests')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_finance_report" class="col-md-4 col-form-label text-md-right">{{ __('Manage Finance Report') }}</label>

                            <div class="col-md-6">
                                <select id="manage_finance_report" class="form-control @error('manage_finance_report') is-invalid @enderror" name="manage_finance_report" required autocomplete="manage_finance_report" autofocus>
                                    <option value="No" @if ($this_staff->manage_finance_report == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_finance_report == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_finance_report')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_other_reports" class="col-md-4 col-form-label text-md-right">{{ __('Manage Other Reports') }}</label>

                            <div class="col-md-6">
                                <select id="manage_other_reports" class="form-control @error('manage_other_reports') is-invalid @enderror" name="manage_other_reports" required autocomplete="manage_other_reports" autofocus>
                                    <option value="No" @if ($this_staff->manage_other_reports == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_other_reports == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_other_reports')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_subscriptions" class="col-md-4 col-form-label text-md-right">{{ __('Manage Subscriptions') }}</label>

                            <div class="col-md-6">
                                <select id="manage_subscriptions" class="form-control @error('manage_subscriptions') is-invalid @enderror" name="manage_subscriptions" required autocomplete="manage_subscriptions" autofocus>
                                    <option value="No" @if ($this_staff->manage_subscriptions == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_subscriptions == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_subscriptions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_calendars" class="col-md-4 col-form-label text-md-right">{{ __('Manage School Calendars & Information') }}</label>

                            <div class="col-md-6">
                                <select id="manage_calendars" class="form-control @error('manage_calendars') is-invalid @enderror" name="manage_calendars" required autocomplete="manage_calendars" autofocus>
                                    <option value="No" @if ($this_staff->manage_calendars == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_calendars == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_calendars')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_session_terms" class="col-md-4 col-form-label text-md-right">{{ __('Manage Session Terms') }}</label>

                            <div class="col-md-6">
                                <select id="manage_session_terms" class="form-control @error('manage_session_terms') is-invalid @enderror" name="manage_session_terms" required autocomplete="manage_session_terms" autofocus>
                                    <option value="No" @if ($this_staff->manage_session_terms == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_session_terms == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_session_terms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_class_arms" class="col-md-4 col-form-label text-md-right">{{ __('Manage Class Arms') }}</label>

                            <div class="col-md-6">
                                <select id="manage_class_arms" class="form-control @error('manage_class_arms') is-invalid @enderror" name="manage_class_arms" required autocomplete="manage_class_arms" autofocus>
                                    <option value="No" @if ($this_staff->manage_class_arms == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_class_arms == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_class_arms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_subjects" class="col-md-4 col-form-label text-md-right">{{ __('Manage Subjects') }}</label>

                            <div class="col-md-6">
                                <select id="manage_subjects" class="form-control @error('manage_subjects') is-invalid @enderror" name="manage_subjects" required autocomplete="manage_subjects" autofocus>
                                    <option value="No" @if ($this_staff->manage_subjects == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_subjects == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_subjects')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="manage_guardians" class="col-md-4 col-form-label text-md-right">{{ __('Manage Parents / Guardians') }}</label>

                            <div class="col-md-6">
                                <select id="manage_guardians" class="form-control @error('manage_guardians') is-invalid @enderror" name="manage_guardians" required autocomplete="manage_guardians" autofocus>
                                    <option value="No" @if ($this_staff->manage_guardians == 'No')
                                        {{ 'selected' }}
                                    @endif>No</option>
                                    <option value="Yes" @if ($this_staff->manage_guardians == 'Yes')
                                        {{ 'selected' }}
                                    @endif>Yes</option>
                                </select>

                                @error('manage_guardians')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection