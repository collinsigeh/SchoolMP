<!DOCTYPE html> 
<html> 

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title> 
		New staff data
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('stylesheets')
</head>
<body>
    <div class="container">
        <div style="padding: 40px 0 10px 0;">
            <h3>Staff data form:</h3>
        </div>
        @include('partials._messages')
        <div class="create-form">
            <form method="POST" action="{{ route('newdata.store_staff') }}" enctype="multipart/form-data">
                @csrf

                <div style="padding-top: 20px;"><h5>School info:</h5></div>
                <div class="resource-details" style="padding: 30px 20px 0 20px;">
                    <div class="form-group row"> 
                        <label for="subject" class="col-md-12 col-form-label">{{ __('School:') }}</label>
        
                        <div class="col-md-7">
                            <input type="text" class="form-control" value="{{ $school->school }}" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                </div>

                <div style="padding-top: 20px;"><h5>Employment info:</h5></div>
                <div class="resource-details" style="padding: 30px 20px 0 20px;">
                    <div class="form-group row"> 
                        <label for="designation" class="col-md-12 col-form-label">{{ __('Select your designation:') }}</label>
                        
                        <div class="col-md-7">
                            <select id="designation" class="form-control @error('designation') is-invalid @enderror" name="designation" required autocomplete="designation" autofocus>
                                <option value="Admin">Admin</option>
                                <option value="Bursar">Bursar</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Class Teacher">Class Teacher</option>
                                <option value="Head teacher">Head Teacher</option>
                                <option value="Subject Teacher">Subject Teacher</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice Principal">Vice Principal</option>
                                <option value="School Staff">School Staff</option>
                            </select>

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <small>
                                <div class="alert alert-info">
                                    <b><u>Hint:</u></b><br/>
                                    Select the designation that best describes your role in the school.
                                </div>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="my_classes" class="col-md-12 col-form-label">{{ __('What clases are you responsible for?') }}</label>
        
                        <div class="col-md-7">
                            <textarea id="my_classes" class="form-control @error('my_classes') is-invalid @enderror" name="my_classes" value="{{ old('my_classes') }}" placeholder="Primary 1 A, Nursery 2 Gold class, JSS 1 Eagle class" required autocomplete="my_classes" autofocus></textarea>
                            @error('my_classes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <small>
                                <div class="alert alert-info">
                                    <b><u>Hint:</u></b><br/>
                                    These are classes where you mark the class attendance and do other class teacher duties.<br><b>Note: </b>Separate each class with a comma. Example; Primary 1 A, Nursery 2 Gold class, JSS 1 Eagle class etc.<br>Enter <b>None</b> if you are NOT responsible for any class.
                                </div>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="my_subjects" class="col-md-12 col-form-label">{{ __('What subjects are you responsible for?') }}</label>
        
                        <div class="col-md-7">
                            <textarea id="my_subjects" class="form-control @error('my_subjects') is-invalid @enderror" name="my_subjects" value="{{ old('my_subjects') }}" placeholder="Mathematics Primary 1 A, Mathematics JSS 1 Eagle class, French Nursery 3 Gold class, French Primary 1 A" required autocomplete="my_subjects" autofocus></textarea>
                            
                            @error('my_subjects')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <small>
                                <div class="alert alert-info">
                                    <b><u>Hint:</u></b><br/>
                                    Please specify each class arm along with the subjects.<br><b>Note: </b>Separate each subject-class arm pair with a comma. Example: Mathematics Primary 1 A, Mathematics Primary 1 B, Mathematics Primary 2 A, Mathematics JSS 1 Eagle class, French Nursery 3 Gold class, French Primary 1 A, French Primary 2 A etc.<br>Enter <b>None</b> if you are NOT responsible for any subject.
                                </div>
                            </small>
                        </div>
                    </div>
                </div>

                <div style="padding-top: 20px;"><h5>Personal info:</h5></div>
                <div class="resource-details" style="padding: 30px 20px 0 20px;">
                    <div class="form-group row"> 
                        <label for="name" class="col-md-12 col-form-label">{{ __('What\'s your name?') }}</label>
        
                        <div class="col-md-7">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="John Doe" required autocomplete="name" autofocus>
        
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                        
                    <div class="form-group row"> 
                        <label for="gender" class="col-md-12 col-form-label">{{ __('Select your gender:') }}</label>

                        <div class="col-md-7">
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
                        <label for="phone" class="col-md-12 col-form-label">{{ __('What\'s your phone number?') }}</label>
        
                        <div class="col-md-7">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="+234 (0) 123 456 7890" required autocomplete="phone" autofocus>
        
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="qualification" class="col-md-12 col-form-label">{{ __('What\'s your qualification?') }}</label>
        
                        <div class="col-md-7">
                            <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" required autocomplete="qualification" autofocus>
                            
                            @error('qualification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <small>
                                <div class="alert alert-info">
                                    <b><u>Hint:</u></b><br/>
                                    State you highest qualification. E.g. M.Ed (School Management)
                                </div>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="pic" class="col-md-12 col-form-label">{{ __('Add your picture:') }}</label>

                        <div class="col-md-7">
                            <input id="pic" type="file" class="form-control @error('pic') is-invalid @enderror" name="pic" value="{{ old('pic') }}" autocomplete="pic" autofocus required>
                            
                            @error('pic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <small>
                                <div class="alert alert-info">
                                    <b><u>Hint:</u></b><br/>
                                    Preferred picture size: 300 x 300 px
                                </div>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="email" class="col-md-12 col-form-label">{{ __('What\'s your email? (Optional)') }}</label>
        
                        <div class="col-md-7">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="email@example.com" autocomplete="email" autofocus>
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <small>
                                <div class="alert alert-info">
                                    <b><u>Hint:</u></b><br/>
                                    Fill this field with a valid email you can access. Otherwise leave it blank.
                                </div>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="address" class="col-md-12 col-form-label">{{ __('What\'s your address? (Optional)') }}</label>
        
                        <div class="col-md-7">
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address" autofocus>
                            
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="alert alert-secondary">
                    <label for="confirmation"><input type="checkbox" name="confirmation" id="confirmation" required style="margin-right: 20px;"> I confirm that the details above are correct and true to the best of my knowledge.</label>
                </div>

                <div class="form-group" style="padding-bottom: 45px;">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body> 
</html>