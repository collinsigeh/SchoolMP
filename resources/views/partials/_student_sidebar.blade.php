<div class="col-md-2 d-none d-md-block sidebar">
    <div class="text-center">
    <img src="{{ config('app.url') }}/images/profile/{{ $user->pic }}" alt="profile pic" class="profilepic">
    </div>
    <div class="profilename">
      {{ $user->name }}
    </div>
    <div class="profile-email">
      {{ $student->registration_number }}
    </div>
    <div class="link top">
      <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>
    <div class="link">
      <a href="{{ route('users.profile') }}">My profile</a>
    </div>
    @if (count($student->enrolments) > 0)
    <div class="link">
      <a href="{{ route('dashboard') }}">Session terms</a>
    </div>
    @endif
  </div>