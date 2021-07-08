@extends('layouts.error')
{{-- show error using sidebar layout if looged in AND on an admin page; otherwise use a blank page --}}

@php
    $title = 'Error '.$error_number;
@endphp

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning">
                {{ $error_number }}</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> @yield('title')</h3>

                <p>
                    @yield('description')
                </p>

            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>

@endsection
