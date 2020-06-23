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
      <a href="#" id="navbarDropdown" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My schools</a>
      
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        @foreach ($user->schools as $school_item)
          <a class="dropdown-item" href="{{ route('schools.show', $school_item->id) }}">{{ $school_item->school }}</a>
        @endforeach
      </div>
    </div>
  </div>