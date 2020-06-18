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
          <a href="{{ route('wards.index') }}">My Wards</a>
        </div>
      </div>