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
            <h3>New student</h3>
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
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="resource-details">
                    <div class="title">
                        Student personal details
                    </div>
                    <div class="body">
                        <div class="form-group row"> 
                            <label for="pic" class="col-md-4 col-form-label text-md-right">{{ __('Picture (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="pic" type="file" class="form-control @error('pic') is-invalid @enderror" name="pic" value="{{ old('pic') }}" autocomplete="pic" autofocus>

                                @error('pic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="gender" autofocus>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Date of birth') }}</label>

                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="religion" class="col-md-4 col-form-label text-md-right">{{ __('Religion') }}</label>

                            <div class="col-md-6">
                                <select id="religion" class="form-control @error('religion') is-invalid @enderror" name="religion" required autocomplete="religion" autofocus>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Judaism">Judaism</option>
                                    <option value="Other religion">Other religion</option>
                                </select>

                                @error('religion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="nationality" class="col-md-4 col-form-label text-md-right">{{ __('Nationality') }}</label>

                            <div class="col-md-6">
                                <input id="nationality" type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}" required autocomplete="nationality" autofocus>

                                @error('nationality')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="state_of_origin" class="col-md-4 col-form-label text-md-right">{{ __('State of Origin (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="state_of_origin" type="text" class="form-control @error('state_of_origin') is-invalid @enderror" name="state_of_origin" value="{{ old('state_of_origin') }}" autocomplete="state_of_origin" autofocus>

                                @error('state_of_origin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="lga_of_origin" class="col-md-4 col-form-label text-md-right">{{ __('LGA of Origin (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="lga_of_origin" type="text" class="form-control @error('lga_of_origin') is-invalid @enderror" name="lga_of_origin" value="{{ old('lga_of_origin') }}" autocomplete="lga_of_origin" autofocus>

                                @error('lga_of_origin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Student health & hobby details
                    </div>
                    <div class="body">
                        <div class="form-group row"> 
                            <label for="ailment" class="col-md-4 col-form-label text-md-right">{{ __('Does the student suffer from allergies or diseases?') }}</label>

                            <div class="col-md-6">
                                <select id="ailment" class="form-control @error('ailment') is-invalid @enderror" name="ailment" required autocomplete="ailment" autofocus>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>

                                @error('ailment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="disability" class="col-md-4 col-form-label text-md-right">{{ __('Does the student suffer from any disability?') }}</label>

                            <div class="col-md-6">
                                <select id="disability" class="form-control @error('disability') is-invalid @enderror" name="disability" required autocomplete="disability" autofocus>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>

                                @error('disability')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="medication" class="col-md-4 col-form-label text-md-right">{{ __('Is the student on special medication?') }}</label>

                            <div class="col-md-6">
                                <select id="medication" class="form-control @error('medication') is-invalid @enderror" name="medication" required autocomplete="medication" autofocus>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>

                                @error('medication')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="health_details" class="col-md-4 col-form-label text-md-right">{{ __('Describe health details briefly (Optional):') }}</label>
                            
                            <div class="col-md-6">
                                <textarea id="health_details" class="form-control @error('health_details') is-invalid @enderror" name="health_details" placeholder="Health condition is so and so...">{{ old('health_details') }}</textarea>
        
                                @error('health_details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <label for="hobbies" class="col-md-4 col-form-label text-md-right">{{ __('Student hobbies (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="hobbies" type="text" class="form-control @error('hobbies') is-invalid @enderror" name="hobbies" value="{{ old('hobbies') }}" autocomplete="hobbies" autofocus>
                                <small class="text-muted">E.g. Swimming, Reading, Singing, etc.</small>

                                @error('hobbies')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Enrolment details
                    </div>
                    <div class="body">
                        <div class="form-group row"> 
                            <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('Class to enrol student in') }}</label>
        
                            <div class="col-md-6">
                                <select id="schoolclass_id" type="text" class="form-control @error('schoolclass_id') is-invalid @enderror" name="schoolclass_id" required autocomplete="schoolclass_id" autofocus>
                                    @php
                                        foreach($schoolclasses as $schoolclass)
                                        {
                                            foreach($schoolclass->arms as $classarm)
                                            {
                                                echo '<option value="'.$classarm->id.'">'.$schoolclass->name.' '.$classarm->name.'</option>';
                                            }
                                        }
                                    @endphp
                                </select>
        
                                @error('schoolclass_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="registration_number" class="col-md-4 col-form-label text-md-right">{{ __('Registration number (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="registration_number" type="text" class="form-control @error('registration_number') is-invalid @enderror" name="registration_number" value="{{ old('registration_number') }}" autocomplete="registration_number" autofocus>

                                @error('registration_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="last_school_attended" class="col-md-4 col-form-label text-md-right">{{ __('Last school attended (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="last_school_attended" type="text" class="form-control @error('last_school_attended') is-invalid @enderror" name="last_school_attended" value="{{ old('last_school_attended') }}" autocomplete="last_school_attended" autofocus>

                                @error('last_school_attended')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="last_class_passed" class="col-md-4 col-form-label text-md-right">{{ __('Last class passed (Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="last_class_passed" type="text" class="form-control @error('last_class_passed') is-invalid @enderror" name="last_class_passed" value="{{ old('last_class_passed') }}" autocomplete="last_class_passed" autofocus>
                                
                                @error('last_class_passed')
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
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
  </div>

@endsection