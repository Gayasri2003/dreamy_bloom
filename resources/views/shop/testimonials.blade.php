@extends('layouts.app')

@section('title', 'Testimonials - Foody')

@section('content')
<div class="container-fluid page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="display-3 mb-3 animated slideInDown">Testimonials</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
                <div class="col-lg-6">
                    <div class="testimonial-item bg-light p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p class="mb-4">{{ $testimonial->message }}</p>
                        <div class="d-flex align-items-center">
                            <img class="flex-shrink-0 rounded-circle" src="{{ asset($testimonial->image ?? 'img/testimonial-1.jpg') }}" style="width: 60px; height: 60px;" alt="{{ $testimonial->name }}">
                            <div class="ms-3">
                                <h5 class="mb-1">{{ $testimonial->name }}</h5>
                                <span>{{ $testimonial->profession }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
