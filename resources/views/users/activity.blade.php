@extends('layouts.app')

@section('title', 'Journal d\'activité - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Journal d'activité</h2>
    <p class="text-muted mb-0">Historique des actions</p>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Objet</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-semibold">{{ $log->user->name }}</td>
                    <td>
                        <span class="badge-custom bg-{{ match($log->action) {
                            'created' => 'success',
                            'updated' => 'warning',
                            'deleted' => 'danger',
                            'login' => 'primary',
                            default => 'secondary'
                        } }} bg-opacity-10 text-{{ match($log->action) {
                            'created' => 'success',
                            'updated' => 'warning',
                            'deleted' => 'danger',
                            'login' => 'primary',
                            default => 'secondary'
                        } }}">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td>{{ $log->model_type }} #{{ $log->model_id }}</td>
                    <td class="text-muted">{{ $log->description }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune activité enregistrée</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection