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
          <a href="{{ route('terms.index') }}">Session terms</a>
        </div>
        <div class="link">
          <a href="#" id="navbarDropdown" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">School options</a>
          
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @if ($staff->manage_class_arms == 'Yes')
            <a class="dropdown-item" href="{{ route('classes.index') }}">Classes</a>
            @endif
            @if ($staff->manage_subjects == 'Yes')
            <a class="dropdown-item" href="{{ route('subjects.index') }}">Subjects</a>
            @endif
            @if ($staff->manage_all_results == 'Yes')
            <a class="dropdown-item" href="{{ route('resulttemplates.index') }}">Result templates</a>
            @endif
            @if ($staff->manage_staff_account == 'Yes')
            <a class="dropdown-item" href="{{ route('staff.index') }}">Staff</a>
            @endif
            <a class="dropdown-item" href="{{ route('terms.index') }}">Session terms</a>
            @if ($staff->manage_calendars == 'Yes')
            <a class="dropdown-item" href="{{ route('schools.edit', $school->id) }}">School information</a>
            @endif
            @if ($staff->manage_subscriptions == 'Yes')
            <a class="dropdown-item" href="{{ route('subscriptions.index') }}">Subscriptions and orders</a>
            @endif
          </div>
        </div>
      </div>