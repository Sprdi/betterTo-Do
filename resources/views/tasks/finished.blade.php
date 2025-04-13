@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4"> Tugas Terselesaikan</h1>

    <a href="{{ route('task.index') }}" class="btn btn-secondary mb-3">Kembali ke Semua Tugas</a>

    <table class="table table-hover table-bordered">
        <thead class="table-success">
            <tr>
                <th>Nama Tugas</th>
                <th>Tanggal</th>
                <th>Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->date }}</td>
                <td>
                    @if ($task->priority == 'High')
                    <span class="badge bg-danger">🔥 High</span>
                    @elseif ($task->priority == 'Medium')
                    <span class="badge bg-warning text-dark">🌤️ Medium</span>
                    @else
                    <span class="badge bg-success">🍃 Low</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada tugas yang selesai 💤</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection