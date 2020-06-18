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
      <a href="{{ route('directors.index') }}">Directors</a>
    </div>
    <div class="link">
      <a href="{{ route('staff.index') }}">Staff</a>
    </div>
    <div class="link">
      <a href="{{ route('students.index') }}">Students / Pupils</a>
    </div>
    <div class="link">
      <a href="{{ route('guardians.index') }}">Parents / Guardians</a>
    </div>
    <div class="link">
      <a href="{{ route('terms.index') }}">Terms</a>
    </div>
    <div class="link">
      <a href="{{ route('classes.index') }}">Classes</a>
    </div>
    <div class="link">
      <a href="{{ route('subjects.index') }}">Subjects</a>
    </div>
    <div class="link">
      <a href="#">Report</a>
    </div>
    <div class="link">
      <a href="{{ route('subscriptions.index') }}">Subscriptions</a>
    </div>
  </div>