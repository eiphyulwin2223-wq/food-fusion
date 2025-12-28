@extends('layouts.app')

@section('title', 'Contact Us - Food Fusion')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">Contact Us</h1>
            <p class="text-center mb-5">Have questions or feedback? We'd love to hear from you!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Other Ways to Connect</h2>
                    <div class="row mt-4">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <i class="bi bi-envelope-fill fs-1 text-primary"></i>
                            <h5 class="mt-2">Email</h5>
                            <p>info@foodfusion.com</p>
                        </div>
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <i class="bi bi-telephone-fill fs-1 text-primary"></i>
                            <h5 class="mt-2">Phone</h5>
                            <p>+1 (555) 123-4567</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="bi bi-geo-alt-fill fs-1 text-primary"></i>
                            <h5 class="mt-2">Address</h5>
                            <p>123 Culinary St.<br>Foodville, CA 90210</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
