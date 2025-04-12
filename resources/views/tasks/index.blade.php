<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f9fc;
        }

        .card-task {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .card-task:hover {
            transform: scale(1.02);
        }

        .badge-priority {
            font-size: 0.8rem;
        }

        .custom-checkbox {
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #0d6efd;
            /* biru Bootstrap */
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        }

        .custom-checkbox:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">🧾 Daily Tasks</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">+ Tambah Tugas</button>
    </div>

    <form method="GET" class="d-flex gap-2 mb-4">
        <input type="date" name="date" class="form-control" value="{{ request('date') }}">

        <select name="priority" class="form-select">
            <option value="">-- Prioritas --</option>
            <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>🔥 High</option>
            <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>🌤️ Medium</option>
            <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>🍃 Low</option>
        </select>

        <button class="btn btn-outline-primary">Filter</button>
        <a href="{{ route('task.index') }}" class="btn btn-secondary">🔄 Reset Filter</a>
        <a href="{{ route('task.finished') }}" class="btn btn-success">✅ Lihat Tugas Selesai</a>
    </form>


    {{-- Daftar Tugas --}}
    <div class="row">
        @forelse($tasks as $task)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-task p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $task->name }}</h5>
                        <span class="badge bg-{{ $task->priority == 'High' ? 'danger' : ($task->priority == 'Medium' ? 'warning text-dark' : 'success') }} badge-priority">
                            {{ $task->priority }}
                        </span>
                        <p class="text-muted small mt-2">📅 {{ \Carbon\Carbon::parse($task->date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <form action="{{ route('task.update', $task) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <input type="checkbox" name="status" class="form-check-input mt-2 custom-checkbox" {{ $task->status ? 'checked' : '' }} onchange="this.form.submit()">
                        </form>
                        <button class="btn btn-sm text-primary mt-2" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">✏️</button>
                    </div>
                </div>
                <form action="{{ route('task.destroy', $task) }}" method="POST" class="mt-3">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger w-100">🗑️ Hapus</button>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('task.updateFull', $task) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Tugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Tugas</label>
                            <input type="text" name="name" class="form-control" value="{{ $task->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="date" class="form-control" value="{{ $task->date }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Prioritas</label>
                            <select name="priority" class="form-select">
                                <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>🔥 High</option>
                                <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>🌤️ Medium</option>
                                <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>🍃 Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center">Belum ada tugas, santai dulu boss 😴</p>
        @endforelse
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('task.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Tugas</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Prioritas</label>
                        <select name="priority" class="form-select">
                            <option value="High">🔥 High</option>
                            <option value="Medium">🌤️ Medium</option>
                            <option value="Low">🍃 Low</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>