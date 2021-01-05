@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>School Dashboard</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
            <div class="col-md-12">
              @if (count($student->enrolments) > 0)
                  <div class="alert alert-info">
                    Select a term to continue.
                  </div>

                  <div class="table-responsive">
                    <table class="table table-striped table-sm">
                      @foreach ($student->enrolments as $enrolment)
                        <tr>
                          <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="collins-table-item-icon"></td>
                          <td style="vertical-align: middle"><a class="collins-link-within-table" href="{{ route('students.term', $enrolment->term->id) }}">{!! '<b>'.$enrolment->term->name.'</b> - <small><i>'.$enrolment->term->session.'</i></small>' !!}</a></td>
                        </tr>
                      @endforeach
                    </table>
                  </div>
              @else
                <div class="alert alert-info">
                  You are not yet registered as a student.
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection