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
          <h3>Edit template details</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('resulttemplates.index') }}">Result templates</a></li>
              <li class="breadcrumb-item"><a href="{{ route('resulttemplates.show', $resulttemplate->id) }}">{{ $resulttemplate->name }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('resulttemplates.update', $resulttemplate->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Template name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $resulttemplate->name }}" placeholder="E.g. Standard Result Template" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Brief description (Optional):') }}</label>
                    
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Maybe a little about this template...">{{ $resulttemplate->description }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="ca_display" class="col-md-4 col-form-label text-md-right">{{ __('Continuous accessment display') }}</label>
    
                    <div class="col-md-6">
                        <select id="ca_display" class="form-control @error('ca_display') is-invalid @enderror" name="ca_display" required>
                            <option value="Summary" @if ($resulttemplate->ca_display == 'Summary')
                                {{ 'selected' }}
                            @endif>Summary</option>
                            <option value="Breakdown" @if ($resulttemplate->ca_display == 'Breakdown')
                                {{ 'Breakdown' }}
                            @endif>Breakdown</option>
                        </select>
    
                        @error('ca_display')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="subject_1st_test_max_score" class="col-md-4 col-form-label text-md-right">{{ __('1st test max. score') }}</label>

                    <div class="col-md-6">
                        <input id="subject_1st_test_max_score" type="number" class="form-control @error('subject_1st_test_max_score') is-invalid @enderror" name="subject_1st_test_max_score" value="{{ $resulttemplate->subject_1st_test_max_score }}" placeholder="E.g. 10" required autocomplete="subject_1st_test_max_score" autofocus>
                        <small class="text-muted">The 1st test score out of the entire 100% for the entire term.</small>

                        @error('subject_1st_test_max_score')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="subject_2nd_test_max_score" class="col-md-4 col-form-label text-md-right">{{ __('2nd test max. score') }}</label>

                    <div class="col-md-6">
                        <input id="subject_2nd_test_max_score" type="number" class="form-control @error('subject_2nd_test_max_score') is-invalid @enderror" name="subject_2nd_test_max_score" value="{{ $resulttemplate->subject_2nd_test_max_score }}" placeholder="E.g. 10" required autocomplete="subject_2nd_test_max_score" autofocus>
                        <small class="text-muted">The 2nd test score out of the entire 100% for the entire term.</small>

                        @error('subject_2nd_test_max_score')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="subject_3rd_test_max_score" class="col-md-4 col-form-label text-md-right">{{ __('3rd test max. score') }}</label>

                    <div class="col-md-6">
                        <input id="subject_3rd_test_max_score" type="number" class="form-control @error('subject_3rd_test_max_score') is-invalid @enderror" name="subject_3rd_test_max_score" value="{{ $resulttemplate->subject_3rd_test_max_score }}" placeholder="E.g. 20" required autocomplete="subject_3rd_test_max_score" autofocus>
                        <small class="text-muted">The 3rd test score out of the entire 100% for the entire term.</small>

                        @error('subject_3rd_test_max_score')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="subject_assignment_score" class="col-md-4 col-form-label text-md-right">{{ __('Assignment score') }}</label>

                    <div class="col-md-6">
                        <input id="subject_assignment_score" type="number" class="form-control @error('subject_assignment_score') is-invalid @enderror" name="subject_assignment_score" value="{{ $resulttemplate->subject_assignment_score }}" placeholder="E.g. 0" required autocomplete="subject_assignment_score" autofocus>
                        <small class="text-muted">The assignment score out of the entire 100% for the entire term.</small>

                        @error('subject_assignment_score')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="subject_exam_score" class="col-md-4 col-form-label text-md-right">{{ __('Exam score') }}</label>

                    <div class="col-md-6">
                        <input id="subject_exam_score" type="number" class="form-control @error('subject_exam_score') is-invalid @enderror" name="subject_exam_score" value="{{ $resulttemplate->subject_exam_score }}" placeholder="E.g. 60" required autocomplete="subject_exam_score" autofocus>
                        <small class="text-muted">The exam score out of the entire 100% for the entire term.</small>

                        @error('subject_exam_score')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_95_to_100" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 95-100') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_95_to_100" type="text" class="form-control @error('grade_95_to_100') is-invalid @enderror" name="grade_95_to_100" value="{{ $resulttemplate->grade_95_to_100 }}" placeholder="E.g. Excellent" required autocomplete="grade_95_to_100" autofocus>
        
                                @error('grade_95_to_100')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_95_to_100" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (95-100)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_95_to_100" type="text" class="form-control @error('symbol_95_to_100') is-invalid @enderror" name="symbol_95_to_100" value="{{ $resulttemplate->symbol_95_to_100 }}" placeholder="E.g. A1" required autocomplete="symbol_95_to_100" autofocus>
        
                                @error('symbol_95_to_100')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_90_to_94" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 90-94') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_90_to_94" type="text" class="form-control @error('grade_90_to_94') is-invalid @enderror" name="grade_90_to_94" value="{{ $resulttemplate->grade_90_to_94 }}" placeholder="E.g. Excellent" required autocomplete="grade_90_to_94" autofocus>
        
                                @error('grade_90_to_94')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_90_to_94" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (90-94)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_90_to_94" type="text" class="form-control @error('symbol_90_to_94') is-invalid @enderror" name="symbol_90_to_94" value="{{ $resulttemplate->symbol_90_to_94 }}" placeholder="E.g. A1" required autocomplete="symbol_90_to_94" autofocus>
        
                                @error('symbol_90_to_94')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_85_to_89" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 84-89') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_85_to_89" type="text" class="form-control @error('grade_85_to_89') is-invalid @enderror" name="grade_85_to_89" value="{{ $resulttemplate->grade_85_to_89 }}" placeholder="E.g. Excellent" required autocomplete="grade_85_to_89" autofocus>
        
                                @error('grade_85_to_89')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_85_to_89" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (85-89)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_85_to_89" type="text" class="form-control @error('symbol_85_to_89') is-invalid @enderror" name="symbol_85_to_89" value="{{ $resulttemplate->symbol_85_to_89 }}" placeholder="E.g. A1" required autocomplete="symbol_85_to_89" autofocus>
        
                                @error('symbol_85_to_89')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_80_to_84" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 80-84') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_80_to_84" type="text" class="form-control @error('grade_80_to_84') is-invalid @enderror" name="grade_80_to_84" value="{{ $resulttemplate->grade_80_to_84 }}" placeholder="E.g. Excellent" required autocomplete="grade_80_to_84" autofocus>
        
                                @error('grade_80_to_84')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_80_to_84" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (80-84)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_80_to_84" type="text" class="form-control @error('symbol_80_to_84') is-invalid @enderror" name="symbol_80_to_84" value="{{ $resulttemplate->symbol_80_to_84 }}" placeholder="E.g. A1" required autocomplete="symbol_80_to_84" autofocus>
        
                                @error('symbol_80_to_84')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_75_to_79" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 75-79') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_75_to_79" type="text" class="form-control @error('grade_75_to_79') is-invalid @enderror" name="grade_75_to_79" value="{{ $resulttemplate->grade_75_to_79 }}" placeholder="E.g. Excellent" required autocomplete="grade_75_to_79" autofocus>
        
                                @error('grade_75_to_79')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_75_to_79" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (75-79)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_75_to_79" type="text" class="form-control @error('symbol_75_to_79') is-invalid @enderror" name="symbol_75_to_79" value="{{ $resulttemplate->symbol_75_to_79 }}" placeholder="E.g. A1" required autocomplete="symbol_75_to_79" autofocus>
        
                                @error('symbol_75_to_79')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_70_to_74" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 70-74') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_70_to_74" type="text" class="form-control @error('grade_70_to_74') is-invalid @enderror" name="grade_70_to_74" value="{{ $resulttemplate->grade_70_to_74 }}" placeholder="E.g. Very Good" required autocomplete="grade_70_to_74" autofocus>
        
                                @error('grade_70_to_74')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_70_to_74" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (70-74)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_70_to_74" type="text" class="form-control @error('symbol_70_to_74') is-invalid @enderror" name="symbol_70_to_74" value="{{ $resulttemplate->symbol_70_to_74 }}" placeholder="E.g. B2" required autocomplete="symbol_70_to_74" autofocus>
        
                                @error('symbol_70_to_74')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_65_to_69" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 65-69') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_65_to_69" type="text" class="form-control @error('grade_65_to_69') is-invalid @enderror" name="grade_65_to_69" value="{{ $resulttemplate->grade_65_to_69 }}" placeholder="E.g. Good" required autocomplete="grade_65_to_69" autofocus>
        
                                @error('grade_65_to_69')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_65_to_69" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (65-69)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_65_to_69" type="text" class="form-control @error('symbol_65_to_69') is-invalid @enderror" name="symbol_65_to_69" value="{{ $resulttemplate->symbol_65_to_69 }}" placeholder="E.g. B3" required autocomplete="symbol_65_to_69" autofocus>
        
                                @error('symbol_65_to_69')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_60_to_64" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 60-64') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_60_to_64" type="text" class="form-control @error('grade_60_to_64') is-invalid @enderror" name="grade_60_to_64" value="{{ $resulttemplate->grade_60_to_64 }}" placeholder="E.g. Credit" required autocomplete="grade_60_to_64" autofocus>
        
                                @error('grade_60_to_64')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_60_to_64" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (60-64)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_60_to_64" type="text" class="form-control @error('symbol_60_to_64') is-invalid @enderror" name="symbol_60_to_64" value="{{ $resulttemplate->symbol_60_to_64 }}" placeholder="E.g. C4" required autocomplete="symbol_60_to_64" autofocus>
        
                                @error('symbol_60_to_64')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_55_to_59" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 55-59') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_55_to_59" type="text" class="form-control @error('grade_55_to_59') is-invalid @enderror" name="grade_55_to_59" value="{{ $resulttemplate->grade_55_to_59 }}" placeholder="E.g. Credit" required autocomplete="grade_55_to_59" autofocus>
        
                                @error('grade_55_to_59')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_55_to_59" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (55-59)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_55_to_59" type="text" class="form-control @error('symbol_55_to_59') is-invalid @enderror" name="symbol_55_to_59" value="{{ $resulttemplate->symbol_55_to_59 }}" placeholder="E.g. C5" required autocomplete="symbol_55_to_59" autofocus>
        
                                @error('symbol_55_to_59')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_50_to_54" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 50-54') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_50_to_54" type="text" class="form-control @error('grade_50_to_54') is-invalid @enderror" name="grade_50_to_54" value="{{ $resulttemplate->grade_50_to_54 }}" placeholder="E.g. Credit" required autocomplete="grade_50_to_54" autofocus>
        
                                @error('grade_50_to_54')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_50_to_54" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (50-54)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_50_to_54" type="text" class="form-control @error('symbol_50_to_54') is-invalid @enderror" name="symbol_50_to_54" value="{{ $resulttemplate->symbol_50_to_54 }}" placeholder="E.g. C6" required autocomplete="symbol_50_to_54" autofocus>
        
                                @error('symbol_50_to_54')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_45_to_49" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 45-49') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_45_to_49" type="text" class="form-control @error('grade_45_to_49') is-invalid @enderror" name="grade_45_to_49" value="{{ $resulttemplate->grade_45_to_49 }}" placeholder="E.g. Pass" required autocomplete="grade_45_to_49" autofocus>
        
                                @error('grade_45_to_49')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_45_to_49" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (45-49)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_45_to_49" type="text" class="form-control @error('symbol_45_to_49') is-invalid @enderror" name="symbol_45_to_49" value="{{ $resulttemplate->symbol_45_to_49 }}" placeholder="E.g. D7" required autocomplete="symbol_45_to_49" autofocus>
        
                                @error('symbol_45_to_49')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_40_to_44" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 40-44') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_40_to_44" type="text" class="form-control @error('grade_40_to_44') is-invalid @enderror" name="grade_40_to_44" value="{{ $resulttemplate->grade_40_to_44 }}" placeholder="E.g. Pass" required autocomplete="grade_40_to_44" autofocus>
        
                                @error('grade_40_to_44')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_40_to_44" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (40-44)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_40_to_44" type="text" class="form-control @error('symbol_40_to_44') is-invalid @enderror" name="symbol_40_to_44" value="{{ $resulttemplate->symbol_40_to_44 }}" placeholder="E.g. E8" required autocomplete="symbol_40_to_44" autofocus>
        
                                @error('symbol_40_to_44')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_35_to_39" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 35-39') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_35_to_39" type="text" class="form-control @error('grade_35_to_39') is-invalid @enderror" name="grade_35_to_39" value="{{ $resulttemplate->grade_35_to_39 }}" placeholder="E.g. Fail" required autocomplete="grade_35_to_39" autofocus>
        
                                @error('grade_35_to_39')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_35_to_39" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (35-39)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_35_to_39" type="text" class="form-control @error('symbol_35_to_39') is-invalid @enderror" name="symbol_35_to_39" value="{{ $resulttemplate->symbol_35_to_39 }}" placeholder="E.g. F9" required autocomplete="symbol_35_to_39" autofocus>
        
                                @error('symbol_35_to_39')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_30_to_34" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 30-34') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_30_to_34" type="text" class="form-control @error('grade_30_to_34') is-invalid @enderror" name="grade_30_to_34" value="{{ $resulttemplate->grade_30_to_34 }}" placeholder="E.g. Fail" required autocomplete="grade_30_to_34" autofocus>
        
                                @error('grade_30_to_34')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_30_to_34" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (30-34)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_30_to_34" type="text" class="form-control @error('symbol_30_to_34') is-invalid @enderror" name="symbol_30_to_34" value="{{ $resulttemplate->symbol_30_to_34 }}" placeholder="E.g. F9" required autocomplete="symbol_30_to_34" autofocus>
        
                                @error('symbol_30_to_34')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_25_to_29" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 25-29') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_25_to_29" type="text" class="form-control @error('grade_25_to_29') is-invalid @enderror" name="grade_25_to_29" value="{{ $resulttemplate->grade_25_to_29 }}" placeholder="E.g. Fail" required autocomplete="grade_25_to_29" autofocus>
        
                                @error('grade_25_to_29')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_25_to_29" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (25-29)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_25_to_29" type="text" class="form-control @error('symbol_25_to_29') is-invalid @enderror" name="symbol_25_to_29" value="{{ $resulttemplate->symbol_25_to_29 }}" placeholder="E.g. F9" required autocomplete="symbol_25_to_29" autofocus>
        
                                @error('symbol_25_to_29')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_20_to_24" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 20-24') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_20_to_24" type="text" class="form-control @error('grade_20_to_24') is-invalid @enderror" name="grade_20_to_24" value="{{ $resulttemplate->grade_20_to_24 }}" placeholder="E.g. Fail" required autocomplete="grade_20_to_24" autofocus>
        
                                @error('grade_20_to_24')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_20_to_24" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (20-24)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_20_to_24" type="text" class="form-control @error('symbol_20_to_24') is-invalid @enderror" name="symbol_20_to_24" value="{{ $resulttemplate->symbol_20_to_24 }}" placeholder="E.g. F9" required autocomplete="symbol_20_to_24" autofocus>
        
                                @error('symbol_20_to_24')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_15_to_19" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 15-19') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_15_to_19" type="text" class="form-control @error('grade_15_to_19') is-invalid @enderror" name="grade_15_to_19" value="{{ $resulttemplate->grade_15_to_19 }}" placeholder="E.g. Fail" required autocomplete="grade_15_to_19" autofocus>
        
                                @error('grade_15_to_19')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_15_to_19" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (15-19)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_15_to_19" type="text" class="form-control @error('symbol_15_to_19') is-invalid @enderror" name="symbol_15_to_19" value="{{ $resulttemplate->symbol_15_to_19 }}" placeholder="E.g. F9" required autocomplete="symbol_15_to_19" autofocus>
        
                                @error('symbol_15_to_19')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_10_to_14" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 10-14') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_10_to_14" type="text" class="form-control @error('grade_10_to_14') is-invalid @enderror" name="grade_10_to_14" value="{{ $resulttemplate->grade_10_to_14 }}" placeholder="E.g. Fail" required autocomplete="grade_10_to_14" autofocus>
        
                                @error('grade_10_to_14')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_10_to_14" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (10-14)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_10_to_14" type="text" class="form-control @error('symbol_10_to_14') is-invalid @enderror" name="symbol_10_to_14" value="{{ $resulttemplate->symbol_10_to_14 }}" placeholder="E.g. F9" required autocomplete="symbol_10_to_14" autofocus>
        
                                @error('symbol_10_to_14')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_5_to_9" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 5-9') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_5_to_9" type="text" class="form-control @error('grade_5_to_9') is-invalid @enderror" name="grade_5_to_9" value="{{ $resulttemplate->grade_5_to_9 }}" placeholder="E.g. Fail" required autocomplete="grade_5_to_9" autofocus>
        
                                @error('grade_5_to_9')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_5_to_9" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (5-9)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_5_to_9" type="text" class="form-control @error('symbol_5_to_9') is-invalid @enderror" name="symbol_5_to_9" value="{{ $resulttemplate->symbol_5_to_9 }}" placeholder="E.g. F9" required autocomplete="symbol_5_to_9" autofocus>
        
                                @error('symbol_5_to_9')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-4 col-6 offset-md-2">
                        <div class="row">
                            <label for="grade_0_to_4" class="col-md-6 col-form-label text-md-right">{{ __('Grade for score of 0-4') }}</label>
        
                            <div class="col-md-6">
                                <input id="grade_0_to_4" type="text" class="form-control @error('grade_0_to_4') is-invalid @enderror" name="grade_0_to_4" value="{{ $resulttemplate->grade_0_to_4 }}" placeholder="E.g. Fail" required autocomplete="grade_0_to_4" autofocus>
        
                                @error('grade_0_to_4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="row">
                            <label for="symbol_0_to_4" class="col-md-6 col-form-label text-md-right">{{ __('Grade symbol (0-4)') }}</label>
        
                            <div class="col-md-6">
                                <input id="symbol_0_to_4" type="text" class="form-control @error('symbol_0_to_4') is-invalid @enderror" name="symbol_0_to_4" value="{{ $resulttemplate->symbol_0_to_4 }}" placeholder="E.g. F9" required autocomplete="symbol_0_to_4" autofocus>
        
                                @error('symbol_0_to_4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection