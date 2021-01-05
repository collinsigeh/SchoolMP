@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>{!! $term->name.' - <small><i>'.$term->session.'</i></small>' !!}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
            <div class="col-md-8">
                <div class="alert alert-info" style="padding-top: 25px;">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover table-sm">
                              <tr>
                                <td><b>Resumption date:</b> {{ date('D, d-M-Y', strtotime($term->resumption_date)) }}</td>
                              </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover table-sm">
                              <tr>
                                <td><b>Closing date:</b> {{ date('D, d-M-Y', strtotime($term->closing_date)) }}</td>
                              </tr>
                          </table>
                        </div>
                      </div> 
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        Term options
                    </div>
                    <div class="body">
                      <div class="table-responsive">    
                        <table class="table">
                            <tr>
                              <td>
                                <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('arms.index') }}">
                                  <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="options-icon"> Class arms
                                </a>
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
  </div>

@endsection