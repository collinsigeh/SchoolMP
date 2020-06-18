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
      <a href="{{ route('users.index') }}">Users</a>
    </div>
    <div class="link">
      <a href="{{ route('schools.all') }}">Schools</a>
    </div>
    <div class="link">
      <a href="{{ route('products.index') }}">Products & packages</a>
    </div>
    <div class="link">
      <a href="{{ route('orders.all') }}">Orders</a>
    </div>
    <div class="link">
      <a href="{{ route('payments.index') }}">Payments</a>
    </div>
    <div class="link">
      <a href="#">Report</a>
    </div>
    <div class="link">
      <a href="{{ route('settings.index') }}">Settings</a>
    </div>
  </div>