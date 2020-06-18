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
                                Student personal details
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="Photo" class="user-pic" >
                                    </div>
                                </div>
                        
                                <div class="table-responsive" style="padding-bottom: 18px;">
                                    <table class="table table-striped table-bordered table-hover table-sm">
                                        <tr>
                                            <th class="bg-light">Name:</th>
                                            <td>
                                                {{ $enrolment->user->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Reg. no.:</th>
                                            <td>
                                                {{ $enrolment->student->registration_number }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Gender:</th>
                                            <td>
                                                {{ $enrolment->user->gender }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Date of birth:</th>
                                            <td>
                                                {{ $enrolment->student->date_of_birth }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Nationality:</th>
                                            <td>
                                                {{ $enrolment->student->nationality }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Religion:</th>
                                            <td>
                                                {{ $enrolment->student->religion }}
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
                                Fees for {!! $term->name.' - <small>'.$term->session.'</small>' !!}
                            </div>
                            <div class="body">    
                                <table class="table table-striped table-hover table-sm">
                                    <tr>
                                        <th>Fees payment status:</th>
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
                                    <tr>
                                        <th>Class:</th>
                                        <td>{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="resource-details">
                            <div class="title">
                                Student privileges for {!! $term->name.' - <small>'.$term->session.'</small>' !!}
                            </div>
                            <div class="body">    
                                <table class="table table-striped table-hover table-sm">
                                    <tr>
                                        <th>To write exams:</th>
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
                                        <th>To partake in CA:</th>
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
                                        <th>To partake in assignments:</th>
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
                                        <th>To access termly report:</th>
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
                        </div>

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
                                                    <td>Assessment for {!! $term->name.' - <small>'.$term->session.'</small>' !!}</td>
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

@endsection