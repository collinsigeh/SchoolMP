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
          
                    <div class="alert alert-info">
                      <div style="margin-bottom: 30px;">
                        <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="collins-this-term-icon"> <span class="collins-this-term">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                      </div>

                      <div class="table-responsive">
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
                    </div>
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            Students in {{ $arm->schoolclass->name.' '.$arm->name }}
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                  @if (count($arm->enrolments) < 1)
                                      <tr>
                                          <td>None<td>
                                      </tr>
                                  @else
                                  <thead>
                                      <tr>
                                          <th colspan="2" style="vertical-align: top">Student</th>
                                          <th style="vertical-align: top">Subjects enrolled for</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($arm->enrolments as $enrolment)
                                        <tr>
                                            <td style="width: 50px;"><img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="class_icon" class="collins-table-item-icon"></td>
                                            <td>{!!  '<b>'.$enrolment->user->name.'</b><br /><small>('.$enrolment->student->registration_number.') ' !!}</td>
                                            <td style="padding-top: 5px;"><span class="badge badge-secondary">{{ count($enrolment->results) }} subjects</span></td>
                                            @if ($student_manager == 'Yes')
                                                  <td class="text-right">
                                                    <button class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;" data-toggle="modal" data-target="#studentResultModal{{ $enrolment->id }}">View result</button>
                                                      <a class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;" href="{{ route('enrolments.show', $enrolment->id) }}">Manage</a>
                                                  </td>
                                            @elseif ($arm->user_id > 0)
                                                @if ($arm->user->id == $user->id)
                                                  <td class="text-right">
                                                    <button class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;" data-toggle="modal" data-target="#studentResultModal{{ $enrolment->id }}">View result</button>
                                                      <a class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;" href="{{ route('enrolments.show', $enrolment->id) }}">Manage</a>
                                                  </td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                  </tbody>
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
                        </div>
                    </div>
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            Subjects and assigned teachers
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive bg-light">
                                <table class="table table-striped table-hover table-sm">
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
                                            <td>{{ $sn.'.' }}</td>
                                            <td><b>{{ $classsubject->subject->name }}</b></td>
                                            <td>
                                                @if ($classsubject->user_id == 0)
                                                    <span class="badge badge-danger">No assigned teacher</span>
                                                @else
                                                    <span class="badge badge-secondary">{!! $classsubject->user->name.' - <small>'.$classsubject->user->staff->phone.'</small>' !!}</span>
                                                @endif
                                            </td>
                                            @if ($classsubject->user_id == $user->id)
                                            <td class="text-right">
                                                <a href="{{ route('classsubjects.show', $classsubject->id) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                                            </td>
                                            <td></td>
                                            @elseif ($classarm_manager == 'Yes')
                                            <td class="text-right">
                                                <a href="{{ route('classsubjects.show', $classsubject->id) }}" class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;">View</a>
                                                <button type="button" class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;" data-toggle="modal" data-target="#assignSubjectTeacherModal{{ $classsubject->id }}">
                                                    Edit
                                                </button>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                    if(count($classsubject->results) < 1)
                                                    {
                                                        ?>
                                                        <form action="{{ route('classsubjects.destroy', $classsubject->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="arm_id" value="{{ $arm->id }}">
                                                            <input type="submit" class="btn btn-sm btn-danger" value="X" />
                                                        </form>
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                          @else
                                          <td></td>
                                          <td></td>
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
                                  <td>
                                    <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">
                                      <img src="{{ config('app.url') }}/images/icons/fees_icon.png" alt="fees_icon" class="options-icon">  Fees breakdown
                                    </button>
                                  </td>
                                </tr>
                                @if ($classarm_manager == 'Yes')
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('arms.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="options-icon"> Class arms
                                    </a>
                                  </td>
                                </tr>
                                @endif
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('terms.show', $term->id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="options-icon"> {!! $term->name.' - <small>'.$term->session.'</small>' !!}</button>
                                    </td>
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

<!-- assignSubjectTeacherModal Series -->
@foreach ($arm->classsubjects as $classsubject)
    @php
        $return_page = 'arms.show';
        $returnpage_id = $arm->id;
    @endphp
    @include('partials._subject_teacher')
@endforeach
<!-- End assignSubjectTeacherModal Series -->

<!-- feesBreakdownModal -->
<div class="modal fade" id="feesBreakdownModal" tabindex="-1" role="dialog" aria-labelledby="feesBreakdownModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="feesBreakdownModalLabel">Fees Breakdown</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>{{ $arm->schoolclass->name.' '.$arm->name }} Fees & Other items</b><br />
                <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <?php $sn = 1; ?>
                    @foreach ($arm->items as $item)
                        <tr>
                            <td>{{ $sn.'.' }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">{{ $item->currency_symbol.' '.$item->amount }}</td>
                        </tr>
                        <?php $sn++; ?>
                    @endforeach
                </table>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End feesBreakdownModal -->

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

<!-- assignScoreModal Series -->
@foreach ($arm->enrolments as $enrolment)
    @php
        $return_page = 'arms.show';
    @endphp
    @include('partials._student_result')
@endforeach
<!-- End assignScoreModal Series -->

@endsection