<div class="col-md-2 d-none d-md-block sidebar">
        <div class="text-center">
        <img src="{{ config('app.url') }}/images/profile/{{ $user->pic }}" alt="profile pic" class="profilepic">
        </div>
        <div class="profilename">
          {{ $user->name }}
        </div>
        <div class="profile-email">
          {{ $user->email }}
        </div>
        <div class="link top">
          <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="link">
          <a href="{{ route('users.profile') }}">My profile</a>
        </div>
        <div class="link">
          <a href="{{ route('terms.index') }}">School terms</a>
        </div>
        <div class="link">
          <a href="#">School record</a>
        </div>
        <div class="link">
          <a href="#" id="navbarDropdown" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">School options</a>
          
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('schools.edit', $school->id) }}">School information</a>
            <a class="dropdown-item" href="{{ route('directors.index') }}">Directors</a>
            <a class="dropdown-item" href="{{ route('staff.index') }}">Staff</a>
            <a class="dropdown-item" href="{{ route('subjects.index') }}">Subjects</a>
            <a class="dropdown-item" href="{{ route('classes.index') }}">Classes</a>
            <a class="dropdown-item" href="{{ route('resulttemplates.index') }}">Result templates</a>
            <a class="dropdown-item" href="{{ route('subscriptions.index') }}">Subscriptions and orders</a>
          </div>
        </div>
      </div>