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
          <h3>{{ $resulttemplate->name }}</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('resulttemplates.index') }}">Result templates</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $resulttemplate->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('resulttemplates.index') }}">Result templates</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $resulttemplate->name }}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Template Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{ $resulttemplate->name }}</h4>
                            </div>
                        </div>

                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th class="bg-light">Brief description:</th>
                                    <td>
                                        {{ $resulttemplate->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">CA display type:</th>
                                    <td>
                                        {{ $resulttemplate->ca_display }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created by:</th>
                                    <td>
                                        {!! $resulttemplate->user->name.' ( <i>'.$resulttemplate->user->email.'</i> )' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created at:</th>
                                    <td>
                                        <small>{{ $resulttemplate->created_at }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <tr class="bg-secondary" style="color: #ffffff; font-size: 1.1em;">
                                    <th colspan="3">Result score breakdown</th>
                                </tr>
                                <tr class="bg-light">
                                    <th>Item type</th>
                                    <th>Item description</th>
                                    <th>Maximum score possible</th>
                                </tr>
                                <tr>
                                    <th class="bg-light">C.A.</th>
                                    <td>
                                        1st test max. score:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->subject_1st_test_max_score }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">C.A.</th>
                                    <td>
                                        2nd test max. score:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->subject_2nd_test_max_score }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">C.A.</th>
                                    <td>
                                        3rd test max. score:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->subject_3rd_test_max_score }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">C.A.</th>
                                    <td>
                                        Assignment total score:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->subject_assignment_score }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Main exam</th>
                                    <td>
                                        Exam score:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->subject_exam_score }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <tr class="bg-secondary" style="color: #ffffff; font-size: 1.1em;">
                                    <th colspan="2">Result score-band and grading</th>
                                </tr>
                                <tr class="bg-light">
                                    <th>Score-band</th>
                                    <th>Corressponding grade</th>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 95-100:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_95_to_100.' ( i.e. '.$resulttemplate->grade_95_to_100.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 90-94:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_90_to_94.' ( i.e. '.$resulttemplate->grade_90_to_94.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 85-89:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_85_to_89.' ( i.e. '.$resulttemplate->grade_85_to_89.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 80-84:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_80_to_84.' ( i.e. '.$resulttemplate->grade_80_to_84.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 75-79:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_75_to_79.' ( i.e. '.$resulttemplate->grade_75_to_79.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 70-74:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_70_to_74.' ( i.e. '.$resulttemplate->grade_70_to_74.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 65-69:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_65_to_69.' ( i.e. '.$resulttemplate->grade_65_to_69.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 60-64:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_60_to_64.' ( i.e. '.$resulttemplate->grade_60_to_64.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 55-59:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_55_to_59.' ( i.e. '.$resulttemplate->grade_55_to_59.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 50-54:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_50_to_54.' ( i.e. '.$resulttemplate->grade_50_to_54.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 45-49:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_45_to_49.' ( i.e. '.$resulttemplate->grade_45_to_49.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 40-44:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_40_to_44.' ( i.e. '.$resulttemplate->grade_40_to_44.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 35-39:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_35_to_39.' ( i.e. '.$resulttemplate->grade_35_to_39.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 34-34:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_30_to_34.' ( i.e. '.$resulttemplate->grade_30_to_34.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 25-29:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_25_to_29.' ( i.e. '.$resulttemplate->grade_25_to_29.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 20-24:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_20_to_24.' ( i.e. '.$resulttemplate->grade_20_to_24.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 15-19:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_15_to_19.' ( i.e. '.$resulttemplate->grade_15_to_19.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 10-14:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_10_to_14.' ( i.e. '.$resulttemplate->grade_10_to_14.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 5-9:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_5_to_9.' ( i.e. '.$resulttemplate->grade_5_to_9.' )' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grade for score of 0-4:
                                    </td>
                                    <td>
                                        {{ $resulttemplate->symbol_0_to_4.' ( i.e. '.$resulttemplate->grade_0_to_4.' )' }}
                                    </td>
                                </tr>
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
                              <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('resulttemplates.edit', $resulttemplate->id) }}">Edit details</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <form method="POST" action="{{ route('resulttemplates.destroy', $resulttemplate->id) }}">
                                        @csrf
                                        @method('DELETE')
                    
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} required>
                    
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Click to delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    {{ __('Yes, delete template') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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

@endsection