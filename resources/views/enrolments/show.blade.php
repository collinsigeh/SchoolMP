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
          <h3>{!! $enrolment->user->name.' ( <i>'.$enrolment->student->registration_number.' </i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! $enrolment->user->name.' ( <i>'.$enrolment->student->registration_number.' </i>)' !!}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! $enrolment->user->name.' ( <i>'.$enrolment->student->registration_number.' </i>)' !!}</li>
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
                            Student personal details
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-8 offset-md-4">
                                    <img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="Photo" class="user-pic" >
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-4">
                                    Name:
                                </div>
                                <div class="col-md-8">
                                    <h4>{{ $enrolment->user->name }}</h4>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-4">
                                    Reg. no.:
                                </div>
                                <div class="col-md-8">
                                    {{ $enrolment->student->registration_number }}
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-4">
                                    Gender:
                                </div>
                                <div class="col-md-8">
                                    {{ $enrolment->user->gender }}
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-4">
                                    Date of birth:
                                </div>
                                <div class="col-md-8">
                                    {{ $enrolment->student->date_of_birth }}
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-4">
                                    Nationality:
                                </div>
                                <div class="col-md-8">
                                    {{ $enrolment->student->nationality }}
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-4">
                                    Religion:
                                </div>
                                <div class="col-md-8">
                                    {{ $enrolment->student->religion }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="resource-details">
                        <div class="title">
                            Report
                        </div>
                        <div class="body">
                            @if (count($arm->classsubjects) < 1)
                                None
                            @else
                                <div class="table-responsive">    
                                    <table class="table table-striped table-hover table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Termly report</td>
                                                <td class="text-right"><a href="#" class="btn btn-sm btn-primary">View</a> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="resource-details">
                        <div class="title">
                            Subjects enrolled
                        </div>
                        <div class="body">
                            @if (count($enrolment->results) < 1)
                                None
                            @else
                                <div class="table-responsive">    
                                    <table class="table table-striped table-hover table-sm">
                                        <tbody>
                                            @foreach ($enrolment->results as $classsubject)
                                                <tr>
                                                    <td>{{ $classsubject->classsubject->subject->name }}</td>
                                                    @if ($arm->user->id == $user->id)
                                                    <td class="text-right">
                                                        <form action="#" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" class="btn btn-sm btn-danger" value="X" />
                                                        </form>
                                                    </td>
                                                    @endif
                                                </tr>
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
                    @if ($classarm_manager == 'Yes' && count($arm->classsubjects) > count($enrolment->results))
                    <div class="col-md-4">
                        <div class="option feature">
                            <h5>Student subjects</h5>
                            <div class="paragraph">
                                Enrol {{ $enrolment->user->name }} for more subjects.
                            </div>
                            <div class="buttons">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newSubjectModal">
                                    Add subject
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


<!-- newSubjectModal -->
<div class="modal fade" id="newSubjectModal" tabindex="-1" role="dialog" aria-labelledby="newSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newSubjectLabel">Add Subjects for {{ $enrolment->user->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('results.store') }}">
                    @csrf

                    <input type="hidden" name="from_form" value="true">
                    <input type="hidden" name="enrolment_id" value="{{ $enrolment->id }}">

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label">{{ __('Tick the subjects to add and click on save') }}</label>
        
                        @foreach ($arm->classsubjects as $classsubject)
                            @php
                                $isassigned = 0;
                            @endphp

                            @foreach ($enrolment->results as $studentsubject)
                                @php
                                    if($studentsubject->classsubject_id == $classsubject->id)
                                    {
                                        $isassigned++;
                                    }
                                @endphp
                            @endforeach

                            @if ($isassigned == 0)
                            <div class="col-md-12">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subject['{{ $classsubject->id }}']" id="subject{{ $classsubject->id }}" {{ old('remember') ? 'checked' : '' }} value="{{ $classsubject->id }}">

                                    <label class="form-check-label" for="subject{{ $classsubject->id }}">
                                        {{ $classsubject->subject->name }}
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