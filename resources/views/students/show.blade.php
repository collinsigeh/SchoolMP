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
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! $enrolment->user->name.' ( <i>'.$enrolment->student->registration_number.' </i>)' !!}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if ($sessionterm_manager == 'Yes')
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{!! $enrolment->user->name.' ( <i>'.$enrolment->student->registration_number.' </i>)' !!}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">

            <div class="welcome">
                <div class="row">
                    <div class="col-md-6">
                        <div class="resource-details">
                            <div class="title">
                                Student details
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="Photo" class="user-pic" >
                                    </div>
                                </div>
                        
                                <div class="table-responsive collins-table-pem" style="padding-bottom: 18px;">
                                    <table class="table table-striped table-bordered table-hover table-sm">
                                        <tr>
                                            <th colspan="2" class="text-center">STUDENT IDENTIFICATION</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Name:</th>
                                            <td>
                                                {{ $enrolment->user->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Gender:</th>
                                            <td>
                                                {{ $enrolment->user->gender }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Class:</th>
                                            <td>
                                                {{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Reg. no.:</th>
                                            <td>
                                                {{ $enrolment->student->registration_number }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            
                                @if ($student_manager == 'Yes' OR $arm->user_id == $user->id)
                                <div class="table-responsive collins-table-pem" style="padding-bottom: 18px;">
                                    <table class="table table-striped table-bordered table-hover table-sm">
                                        <tr>
                                            <th colspan="2" class="text-center">ENROLMENT & FEES</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Termly subscription:</th>
                                            <td><span class="badge <?php
                                                if($enrolment->status == 'Active')
                                                {
                                                  echo 'badge-sucess';
                                                }
                                                else
                                                {
                                                  echo 'badge-danger';
                                                }
                                            ?>">{{ $enrolment->status }}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Fees payment status:</th>
                                            <td><span class="badge <?php
                                                if($enrolment->fee_status == 'Unpaid')
                                                {
                                                  echo 'badge-danger';
                                                }
                                                elseif($enrolment->fee_status == 'Partly-paid')
                                                {
                                                  echo 'badge-warning';
                                                }
                                                elseif($enrolment->fee_status == 'Completely-paid')
                                                {
                                                  echo 'badge-success';
                                                }
                                            ?>">{{ $enrolment->fee_status }}</span></td>
                                        </tr>
                                    </table>
                                </div>
                                @endif
    
                                @if ($student_privilege_manager == 'Yes' OR $arm->user_id == $user->id)
                                <div class="table-responsive collins-table-pem" style="padding-bottom: 18px;">
                                    <table class="table table-striped table-bordered table-hover table-sm">
                                        <tr>
                                            <th colspan="2" class="text-center">TERMLY PRIVILEGES</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">To write exams:</th>
                                            <td> 
                                                @php
                                                if($enrolment->access_exam == 'Yes')
                                                {
                                                    echo '<span class="badge badge-success">Permitted</span>';
                                                }
                                                else
                                                {
                                                    echo '<span class="badge badge-danger">NOT permitted</span>';
                                                }
                                            @endphp
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">To partake in CA:</th>
                                            <td>
                                                @php
                                                if($enrolment->access_ca == 'Yes')
                                                {
                                                    echo '<span class="badge badge-success">Permitted</span>';
                                                }
                                                else
                                                {
                                                    echo '<span class="badge badge-danger">NOT permitted</span>';
                                                }
                                            @endphp
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">To partake in assignments:</th>
                                            <td>
                                                @php
                                                if($enrolment->access_assignment == 'Yes')
                                                {
                                                    echo '<span class="badge badge-success">Permitted</span>';
                                                }
                                                else
                                                {
                                                    echo '<span class="badge badge-danger">NOT permitted</span>';
                                                }
                                            @endphp
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">To access termly report:</th>
                                            <td>
                                                @php
                                                if($enrolment->access_result == 'Yes')
                                                {
                                                    echo '<span class="badge badge-success">Permitted</span>';
                                                }
                                                else
                                                {
                                                    echo '<span class="badge badge-danger">NOT permitted</span>';
                                                }
                                            @endphp
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @endif
                        
                                <div class="table-responsive collins-table-pem" style="padding-bottom: 18px;">
                                    <table class="table table-striped table-bordered table-hover table-sm">
                                        <tr>
                                            <th colspan="2" class="text-center">PERSONAL DETAILS</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Last School Attended:</th>
                                            <td>
                                                @if (strlen($enrolment->student->last_school_attended) < 2)
                                                    N/A
                                                @else
                                                    {{ $enrolment->student->last_school_attended }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Last Class Passed:</th>
                                            <td>
                                                @if (strlen($enrolment->student->last_class_passed) < 2)
                                                    N/A
                                                @else
                                                    {{ $enrolment->student->last_class_passed }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Hobbies:</th>
                                            <td>
                                                @if (strlen($enrolment->student->hobbies) < 2)
                                                    N/A
                                                @else
                                                    {{ $enrolment->student->hobbies }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Date of birth:</th>
                                            <td>
                                                {{ $enrolment->student->date_of_birth }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Ailment & Allergies:</th>
                                            <td>
                                                {{ $enrolment->student->ailment }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Disabilities:</th>
                                            <td>
                                                {{ $enrolment->student->disability }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Medication:</th>
                                            <td>
                                                {{ $enrolment->student->medication }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Health Details:</th>
                                            <td>
                                                @if (strlen($enrolment->student->health_detail) < 2)
                                                    N/A
                                                @else
                                                    {{ $enrolment->student->health_detail }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Religion:</th>
                                            <td>
                                                {{ $enrolment->student->religion }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Nationality:</th>
                                            <td>
                                                {{ $enrolment->student->nationality }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">State of Origin:</th>
                                            <td>
                                                @if (strlen($enrolment->student->state_of_origin) < 2)
                                                    N/A
                                                @else
                                                    {{ $enrolment->student->state_of_origin }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">LGA of Origin:</th>
                                            <td>
                                                @if (strlen($enrolment->student->lga_of_origin) < 2)
                                                    N/A
                                                @else
                                                    {{ $enrolment->student->lga_of_origin }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="resource-details">
                            <div class="title">
                                Performance report
                            </div>
                            <div class="body">
                                @if (count($arm->classsubjects) < 1)
                                    None
                                @else
                                    <div class="table-responsive">    
                                        <table class="table table-striped table-hover table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Report Sheet <small>for</small> {!! $term->name.' - <small>'.$term->session.'</small>' !!}</td>
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
                                    <div class="alert alert-info">None</div>
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
                            
                                @if ($student_manager == 'Yes' OR $arm->user_id == $user->id)
                                    @if (count($arm->classsubjects) > count($enrolment->results))
                                    <div class="text-right">
                                        <div class="buttons">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newSubjectModal">
                                                Add subjects
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            
        </div>
      </div>

      @include('partials._add_subjects_for_student')

@endsection