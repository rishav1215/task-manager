@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-body-tertiary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Task
                        </h3>
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ old('title', $task->title) }}" 
                                class="form-control" required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
    }
    
    .dark .card {
        background-color: #1e293b;
    }
    
    .dark .card-header {
        background-color: #0f172a !important;
        border-bottom: 1px solid #334155;
    }
    
    .dark .form-control, .dark .form-select {
        background-color: #1e293b;
        border-color: #334155;
        color: #e2e8f0;
    }
</style>
@endsection