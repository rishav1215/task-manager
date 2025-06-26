@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Your Tasks</h2>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            <i class="fas fa-plus me-2"></i>Add Task
        </button>
    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning">Create New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label text-success">Task Title</label>
                            <input type="text" class="form-control" id="taskTitle" name="title" placeholder="Enter task title" required>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @foreach(['To Do', 'In Progress', 'Done'] as $status)
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-body-tertiary py-3">
                    <h5 class="mb-0 fw-semibold d-flex align-items-center">
                        @switch($status)
                            @case('To Do')
                                <i class="fas fa-list-check me-2 text-primary"></i>
                                @break
                            @case('In Progress')
                                <i class="fas fa-spinner me-2 text-warning"></i>
                                @break
                            @case('Done')
                                <i class="fas fa-check-circle me-2 text-success"></i>
                                @break
                        @endswitch
                        {{ $status }}
                        <span class="badge bg-primary ms-2">{{ count($tasks[$status] ?? []) }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($tasks[$status] ?? [] as $task)
                        <div class="list-group-item p-3 mb-2 rounded-3 shadow-sm-hover">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="me-2">{{ $task->title }}</strong>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('tasks.edit', $task->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if($task->description)
                            <p class="small text-muted mb-2">{{ $task->description }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                                <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="ms-2">
                                    @csrf @method('PUT')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                        <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @empty($tasks[$status])
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-tasks fa-2x mb-2"></i>
                        <p>No tasks in this column</p>
                    </div>
                    @endempty
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .list-group-item {
        transition: all 0.2s ease;
        border-left: 3px solid;
    }
    
    .list-group-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .list-group-item[style*="To Do"] {
        border-left-color: #6366f1;
    }
    
    .list-group-item[style*="In Progress"] {
        border-left-color: #f59e0b;
    }
    
    .list-group-item[style*="Done"] {
        border-left-color: #10b981;
    }
    
    .shadow-sm-hover {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    
    .dark .card {
        background-color: #1e293b;
        border-color: #334155;
    }
    
    .dark .card-header {
        background-color: #0f172a;
        border-color: #334155;
    }
    
    .dark .list-group-item {
        background-color: #1e293b;
        border-color: #334155;
    }
</style>

<script>
    // Make tasks draggable between columns (would need additional JS for full implementation)
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.draggable = true;
        
        item.addEventListener('dragstart', () => {
            item.classList.add('dragging');
        });
        
        item.addEventListener('dragend', () => {
            item.classList.remove('dragging');
        });
    });
</script>
@endsection