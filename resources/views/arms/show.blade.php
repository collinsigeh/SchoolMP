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
                <div class="col-md-8">
                    <div class="resource-details">
                        <div class="title">
                            {{ $arm->schoolclass->name.' '.$arm->name }}
                        </div>
                        <div class="body">
                            <div class="table-responsive" style="padding-bottom: 68px;">
                              <table class="table table-striped table-hover table-sm">
                                  <tr>
                                    <th>Class teacher:</th>                           
                                    @if ($arm->user_id < 1)
                                        <td>
                                            {!! '<span class="badge badge-danger">No assigned teacher</span>' !!}
                                            @if ($classarm_manager == 'Yes')
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newTeacherModal">
                                                    Assign class teacher
                                                </button>
                                            @endif
                                        </td>
                                    @else
                                        <td>{!! $arm->user->name.' - <small>'.$arm->user->staff->phone.'</small>' !!}</td>
                                        @if ($classarm_manager == 'Yes')
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#newTeacherModal">
                                                    Edit
                                                </button>
                                            </td>
                                        @endif
                                    @endif
                                  </tr>
                              </table>
                            </div>
                            
                            <div class="table-responsive bg-light">
                                <table class="table table-striped table-hover table-sm">
                                  <tr class="bg-secondary">
                                      <th style="font-size: 1.2em; color: #ffffff;" colspan="4">Students</th>
                                  </tr>
                                  @if (count($arm->enrolments) < 1)
                                      <tr>
                                          <td>None<td>
                                      </tr>
                                  @else
                                      @php
                                          $sn = 1;
                                      @endphp
                                      @foreach ($arm->enrolments as $enrolment)
                                          <tr>
                                              <td>{{ $sn }}</td>
                                              <td>{!!  $enrolment->user->name.' - <small>('.$enrolment->student->registration_number.') ' !!}</td>
                                              <td>{{ count($enrolment->results) }} subjects</td>
                                              <td class="text-right">
                                                  @if ($arm->user_id > 0)
                                                      @if ($arm->user->id == $user->id)
                                                          <a class="btn btn-sm btn-outline-primary" href="{{ route('enrolments.show', $enrolment->id) }}">View</a>
                                                      @endif
                                                  @endif
                                              </td>
                                          </tr>
                                          @php
                                              $sn++;
                                          @endphp
                                      @endforeach
                                  @endif
                                </table>
                            </div>
                            @if ($student_manager == 'Yes')
                            <div class="text-right">
                                <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                                    New Student
                                </a>
                            </div>
                            @endif
                            <div style="padding: 35px;"></div>
                            
                            <div class="table-responsive bg-light">
                                <table class="table table-striped table-hover table-sm">
                                  <tr class="bg-secondary">
                                      <th style="font-size: 1.2em; color: #ffffff;" colspan="5">Subjects and assigned teachers</th>
                                  </tr>
                                  @if (count($arm->classsubjects) < 1)
                                      <tr>
                                          <td>None<td>
                                      </tr>
                                  @else
                                      @php
                                          $sn = 1;
                                      @endphp
                                      @foreach ($arm->classsubjects as $classsubject)
                                        <tr>
                                            <td>{{ $sn }}</td>
                                            <td>{{ $classsubject->subject->name }}</td>
                                            <td>
                                                @if ($classsubject->user_id == 0)
                                                    No assigned teacher
                                                @else
                                                    {!! $classsubject->user->name.' - <small>'.$classsubject->user->staff->phone.'</small>' !!}
                                                @endif
                                            </td>
                                            @if ($classarm_manager == 'Yes')
                                            <td class="text-right"><a href="{{ route('classsubjects.edit', $classsubject->id) }}" class="btn btn-sm btn-outline-primary">Edit</a> </td>
                                            <td class="text-right">
                                                <form action="{{ route('classsubjects.destroy', $classsubject->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="arm_id" value="{{ $arm->id }}">
                                                    <input type="submit" class="btn btn-sm btn-danger" value="X" />
                                                </form>
                                            </td>
                                          @endif
                                        </tr>
                                        @php
                                            $sn++;
                                        @endphp
                                      @endforeach
                                  @endif
                                </table>
                            </div>
                            @if ($classarm_manager == 'Yes')
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newSubjectModal">
                                    Add subject
                                </button>
                            </div>
                            @endif

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
                                    <td><a class="btn btn-sm btn-block btn-outline-primary" href="#">Class timetable</a></td>
                                  </tr>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
  </div>

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