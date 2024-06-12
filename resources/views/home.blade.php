@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h3 class="text-center mb-4">Welcome <span class="text-primary">{{ auth()->user()->name }}</span></h3>

        @if(auth()->user()->position === 'STAFF')
            <x-staff-dashboard/>
        @elseif(auth()->user()->position === 'MANAGER')
            <x-manager-dashboard/>
        @elseif(auth()->user()->position === 'HEAD OF DEPARTMENT')
            <x-hod-dashboard/>
        @elseif(auth()->user()->position === 'SYSTEM MANAGER')
            <x-system-manager-dashboard/>
        @endif
    </div>
@endsection
