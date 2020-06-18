@extends('layouts.school')

@section('title', 'School Portal')

@section('content')

<div class="continer text-center">
    <pre>






    </pre>
    <h3>Session Expired</h3>
    <p>Please <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">re-login</a> to dashboard.</p>
</div>

@endsection