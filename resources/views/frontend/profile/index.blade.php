@extends('layouts.frontend.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <livewire:user.education />
            <livewire:user.employment />

        </div>
    </div>
@endsection
