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
          <h3>{{ $arm->schoolclass->name.' '.$arm->name }}</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.index') }}">Class arms</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $arm->schoolclass->name.' '.$arm->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if ($sessionterm_manager == 'Yes')
                    <li class="breadcrumb-item"><a href="{{ route('arms.index') }}">Class arms</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $arm->schoolclass->name.' '.$arm->name }}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
                <div class="col-md-6">
                    <div class="resource-details">
                        <div class="title">
                            Class Teacher
                        </div>
                        <div class="body">
                            @if ($arm->user_id < 1)
                                {{ 'No assigned teacher.' }}
                            @else
                            <div class="table-responsive">    
                                <table class="table table-striped table-hover table-sm">
                                    <tbody>
                                        <tr><td>{{ $arm->user->name }}</td>
                                            @if ($classarm_manager == 'Yes')
                                                <td class="text-right">
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newTeacherModal">
                                                        Edit
                                                    </button>
                                                    </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="resource-details">
                        <div class="title">
                            Students
                        </div>
                        <div class="body">
                            @if (count($arm->enrolments) < 1)
                                {{ 'None.' }}
                            @else
                            <h5>Total: {{ count($arm->enrolments) }}</h5>
                            <div class="table-responsive">    
                                <table class="table table-striped table-hover table-sm">
                                    <thead>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Reg. no.</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        @foreach ($arm->enrolments as $enrolment)
                                            <tr>
                                                <td>{{ $sn }}</td>
                                                <td>{{ $enrolment->user->name }}</td>
                                                <td>{{ $enrolment->student->registration_number}}</td>
                                                <td class="text-right">
                                                    @if ($arm->user->id == $user->id)
                                                        <a class="btn btn-sm btn-primary" href="{{ route('enrolments.show', $enrolment->id) }}">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $sn++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="resource-details">
                        <div class="title">
                            Class subjects and assigned teachers
                        </div>
                        <div class="body">
                            @if (count($arm->classsubjects) < 1)
                                None
                            @else
                                <div class="table-responsive">    
                                    <table class="table table-striped table-hover table-sm">
                                        <tbody>
                                            @foreach ($arm->classsubjects as $classsubject)
                                                <tr><td>{{ $classsubject->subject->name }} (<i>@if ($classsubject->user_id == 0)
                                                    No assigned teacher
                                                @else
                                                    {{ $classsubject->user->name }}
                                                @endif</i>)</td>
                                                @if ($classarm_manager == 'Yes')
                                                <td class="text-right"><a href="{{ route('classsubjects.edit', $classsubject->id) }}" class="btn btn-sm btn-primary">Edit</a> </td>
                                                    <td class="text-right">
                                                        <form action="{{ route('classsubjects.destroy', $classsubject->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" class="btn btn-sm btn-danger" value="X" />
                                                        </form>
                                                    </td>
                                                @endif</tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="more-options">
            <div class="head">More options</div>
            <div class="body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="option feature">
                            <h5>Class assignments</h5>
                            <div class="paragraph">
                                You can add and manage class assignments for this class.
                            </div>
                            <div class="buttons">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newAssignmentModal">
                                    New assignment
                                </button>
                                <a href="#" class="btn btn-sm btn-primary">View all</a>
                            </div>
                        </div>
                    </div>

                    @if ($classarm_manager == 'Yes')
                    @if ($arm->user_id < 1)
                    <div class="col-md-4">
                        <div class="option feature">
                            <h5>Class teacher</h5>
                            <div class="paragraph">
                                You can assign a staff to administer this class arm.
                            </div>
                            <div class="buttons">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newTeacherModal">
                                    Assign class teacher
                                </button><!--
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newAssistantModal">
                                    Add assistant class teacher
                                </button> -->
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="option feature">
                            <h5>Class subjects</h5>
                            <div class="paragraph">
                                You can add class subjects for this class arm.
                            </div>
                            <div class="buttons">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newSubjectModal">
                                    Add new
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
  </div>


   <!-- newAssignmentModal -->
   <div class="modal fade" id="newAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="newAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newAssignmentModalLabel">New Class Assignment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="#">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New assignment') }}</label>
        
                        <div class="col-md-6">
                            <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End newAssignmentModal -->

<!-- newTeacherModal -->
<div class="modal fade" id="newTeacherModal" tabindex="-1" role="dialog" aria-labelledby="newTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newTeacherModalLabel">Assign class teacher</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('arms.addclassteacher') }}">
                    @csrf
                    
                    <input type="hidden" name="id" value="{{ $arm->id }}" />

                    <div class="form-group row"> 
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Class') }}</label>
    
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $arm->schoolclass->name.' '.$arm->name}}" disabled autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Class teacher') }}</label>
    
                        <div class="col-md-6">
                            <select id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required autocomplete="user_id" autofocus>
                                @php
                                    if($arm->user_id < 1)
                                    {
                                        echo '<option value="0">Select a staff</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$arm->user_id.'">'.$arm->user->name.'</option>';
                                    }
                                    foreach($school->staff as $employee)
                                    {
                                        echo '<option value="'.$employee->user->id.'">'.$employee->user->name.' ( <i>'.$employee->designation.'</i> )</option>';
                                    }
                                @endphp
                            </select>
    
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End newTeacherModal -->

<!-- newAssistantModal -->
<div class="modal fade" id="newAssistantModal" tabindex="-1" role="dialog" aria-labelledby="newAssistantModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newAssistantModalLabel">New Assistant Class Teacher</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="#">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New teacher') }}</label>
        
                        <div class="col-md-6">
                            <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End newAssistantModal -->

<!-- newSubjectModal -->
<div class="modal fade" id="newSubjectModal" tabindex="-1" role="dialog" aria-labelledby="newSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newSubjectLabel">Add Subjects for {{ $arm->schoolclass->name.' '.$arm->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('classsubjects.store') }}">
                    @csrf

                    <input type="hidden" name="from_form" value="true">

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label">{{ __('Tick the subjects to add and click on save') }}</label>
        
                        @foreach ($school->subjects as $subject)
                            @php
                                $isassigned = 0;
                            @endphp

                            @foreach ($arm->classsubjects as $classsubject)
                                @php
                                    if($classsubject->subject_id == $subject->id)
                                    {
                                        $isassigned++;
                                    }
                                @endphp
                            @endforeach

                            @if ($isassigned == 0)
                            <div class="col-md-12">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subject['{{ $subject->id }}']" id="subject{{ $subject->id }}" {{ old('remember') ? 'checked' : '' }} value="{{ $subject->id }}">

                                    <label class="form-check-label" for="subject{{ $subject->id }}">
                                        {{ $subject->name }}
                                    </label>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End newSubjectModal -->

@endsection