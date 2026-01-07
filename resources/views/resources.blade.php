@extends('layouts.app')

@section('title', 'Culinary Resources - Food Fusion')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Culinary Resources</h1>
        <p class="lead text-muted">Downloadable recipe cards, cooking tutorials, and kitchen hacks</p>
    </div>

    @auth
    @if(Auth::user()->role === 'admin')
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-upload me-2"></i>Upload New Resource</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="pdf">PDF Document</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-1"></i>Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    @endauth

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @if($pdfs->count() > 0)
        <div class="col-12">
            <h3 class="mb-4 border-bottom pb-2">
                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Recipe Cards & Guides
            </h3>
        </div>
        @endif
        @forelse($pdfs as $pdf)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-file-earmark-pdf fs-1 text-danger me-3"></i>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $pdf->title }}</h5>
                            <small class="text-muted d-block mb-2">{{ $pdf->original_name }}</small>
                            @if($pdf->description)
                                <p class="card-text small text-muted">{{ $pdf->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ asset('storage/' . $pdf->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-download me-1"></i>Download
                    </a>
                    @auth
                    @if(Auth::user()->role === 'admin')
                        <form action="{{ route('resources.destroy', $pdf) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this resource?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        @empty
        @endforelse

        @if($videos->count() > 0)
        <div class="col-12 mt-4">
            <h3 class="mb-4 border-bottom pb-2">
                <i class="bi bi-play-circle text-success me-2"></i>Cooking Tutorials
            </h3>
        </div>
        @endif
        @forelse($videos as $video)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-play-circle fs-1 text-success me-3"></i>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $video->title }}</h5>
                            <small class="text-muted d-block mb-2">{{ $video->original_name }}</small>
                            @if($video->description)
                                <p class="card-text small text-muted">{{ $video->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ asset('storage/' . $video->file_path) }}" target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-play-circle me-1"></i>Watch
                    </a>
                    @auth
                    @if(Auth::user()->role === 'admin')
                        <form action="{{ route('resources.destroy', $video) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this resource?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        @empty
        @endforelse

        @if($pdfs->count() === 0 && $videos->count() === 0)
        <div class="col-12 text-center py-5">
            <i class="bi bi-folder-x fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted mb-3">No resources available yet.</p>
            @auth
            @if(Auth::user()->role === 'admin')
                <p class="text-muted">Use the upload form above to add resources.</p>
            @endif
            @endauth
        </div>
        @endif
    </div>

    @if($pdfs->count() > 0 || $videos->count() > 0)
    <div class="text-center mt-5">
        <h4 class="mb-3">Want More Resources?</h4>
        <p class="text-muted mb-3">Subscribe to our newsletter for weekly recipes and cooking tips</p>
        <a href="{{ route('contact.index') }}" class="btn btn-primary">Contact Us</a>
    </div>
    @endif
</div>
@endsection
