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
    <div class="link">
      <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>
    <div class="link">
      <a href="{{ route('enrolments.index') }}">Student enrolments</a>
    </div>
    <div class="link top">
      <a href="{{ route('arms.index') }}">Class arms</a>
    </div>
    <div class="link">
      <a href="{{ route('items.index') }}">Fees & other items</a>
    </div>
    <div class="link">
      <a href="{{ route('calendars.index') }}">Term calandar</a>
    </div>
    <div class="link">
      <a href="#">Report</a>
    </div>
  </div>