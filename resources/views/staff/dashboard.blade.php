@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._staff_sidebar')

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
              <div class="alert alert-info">
                <div>
                  <img src="{{ config('app.url') }}/images/icons/current_term_icon.png" alt="current_term_icon" class="collins-current-term-icon">
                </div>
                
                
                @if (!$currentterm)
                    <span style="font-size: 2em;">Not Available!</span><br />
                    @if (count($previousterms) >= 1)
                            <a href="{{ route('terms.index') }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">View session terms</a>
                    @else
                            @if ($staff->manage_session_terms == 'Yes')
                                <a href="{{ route('terms.create') }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">New term</a>
                            @else
                                There's <b>no active session term</b> at present. Please contact the school admin.
                            @endif
                    @endif
                @else

                <span style="font-size: 2em;">{!! $currentterm->name.' (<small>'.$currentterm->session.'</small>)' !!}</span><br />
                <a href="{{ route('terms.show', $currentterm->id) }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">Enter</a>
                
                @endif
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('terms.index') }}">
                <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="session_term" class="collins-feature-icon">
                <div class="collins-feature-title">Session Terms</div>
                </a>
              </div>
            </div>
            @if ($staff->manage_class_arms == 'Yes')
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('classes.index') }}">
                <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Classes</div>
                </a>
              </div>
            </div>
            @endif
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('subjects.index') }}">
                <img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subjects_info" class="collins-feature-icon">
                <div class="collins-feature-title">Subjects</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('resulttemplates.index') }}">
                <img src="{{ config('app.url') }}/images/icons/result_template_icon.png" alt="result_template" class="collins-feature-icon">
                <div class="collins-feature-title">Result Templates</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('directors.index') }}">
                <img src="{{ config('app.url') }}/images/icons/director_icon.png" alt="director_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Directors</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('staff.index') }}">
                <img src="{{ config('app.url') }}/images/icons/staff_icon.png" alt="staff_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Staff</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('schools.edit', $school->id) }}">
                <img src="{{ config('app.url') }}/images/icons/school_icon.png" alt="schools_info" class="collins-feature-icon">
                <div class="collins-feature-title">School Info</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('subscriptions.index') }}">
                <img src="{{ config('app.url') }}/images/icons/subscription_icon.png" alt="subscription_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Subscriptions</div>
                </a>
              </div>
            </div>
          </div>



          <div class="row">
            <div class="col-md-12">
                <div class="resource-details">
                    <div class="title">
                        Current Term
                    </div>
                    <div class="body">
                      @if (!$currentterm)
                          <span style="font-size: 3em;">Not Available!</span><br />
                          @if (count($previousterms) >= 1)
                            <a href="{{ route('terms.index') }}" class="btn btn-lg btn-primary" style="margin-top:- 15px;">View session terms</a>
                          @else
                            @if ($staff->manage_session_terms == 'Yes')
                                <a href="{{ route('terms.create') }}" class="btn btn-lg btn-primary" style="margin-top:- 15px;">New term</a>
                            @else
                                <div class="alert alert-info">
                                  There's <b>no active term</b> at present. Please contact the school admin.
                                </div>
                            @endif
                          @endif
                      @else

                      <span style="font-size: 3em;">{!! $currentterm->name.' (<small>'.$currentterm->session.'</small>)' !!}</span><br />
                      <a href="{{ route('terms.show', $currentterm->id) }}" class="btn btn-lg btn-primary" style="margin-top:- 15px;">Enter</a>
                      
                      @endif
                    </div>
                </div>
            </div>
          </div>

          
          <div class="row">

            <div class="col-md-6">
              <div class="resource-details">
                  <div class="title">
                      School terms
                  </div>
                  <div class="body">
                    @if (count($previousterms) < 1)
                        None
                    @else
                    <div class="table-responsive">    
                      <table class="table table-striped table-hover table-sm">
                        <thead>
                          <tr><th>#</th><th>School terms</th><th></th></tr>
                        </thead>
                        <tbody>
                          @php
                              $no_term_to_display = 5;
                              $sn = 1;
                              foreach ($previousterms as $sessionterm) {
                                if($sn <= $no_term_to_display)
                                {
                                  echo '<tr><td>'.$sn.'</td><td>'.$sessionterm->name.' - <small>'.$sessionterm->session.'</small></td><td class="text-right"><a href="'.route('terms.show', $sessionterm->id).'" class="btn btn-sm btn-outline-primary">Enter</a></td></tr>';
                                }
                                $sn++;
                              }
                          @endphp
                        </tbody>
                      </table>
                    </div>
                    @if ($sn > $no_term_to_display)
                        <a href="{{ route('terms.index') }}">View more...</a>
                    @else
                      <div class="text-right"><a class="btn btn-sm btn-primary" href="{{ route('terms.index') }}">View all</a></div>
                    @endif
                    @endif
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="resource-details">
                  <div class="title">
                      More options
                  </div>
                  <div class="body">
                    <div class="table-responsive">    
                      <table class="table">
                        @if ($staff->manage_calendars == 'Yes')
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('schools.edit', $school->id) }}">School information</a></td>
                          </tr>
                        @endif
                        @if ($staff->manage_staff_account == 'Yes')
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('staff.index') }}">School staff</a></td>
                          </tr>
                        @endif
                        @if ($staff->manage_subjects == 'Yes')
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subjects.index') }}">School subjects</a></td>
                          </tr>
                        @endif
                        @if ($staff->manage_class_arms == 'Yes')
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('classes.index') }}">School classes</a></td>
                          </tr>
                        @endif
                        @if ($staff->manage_all_results == 'Yes')
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('resulttemplates.index') }}">Result templates</a></td>
                          </tr>
                        @endif
                        @if ($staff->manage_subscriptions == 'Yes')
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subscriptions.index') }}">Subscriptions and orders</a></td>
                          </tr>
                        @endif
                        <tr>
                          <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('users.profile') }}">My profile</a></td>
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