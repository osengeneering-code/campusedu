@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <h4 class="mb-1"><b>Journal des Activités</b></h4> -->

        <div class="row">
            <!-- User List Card -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Utilisateurs</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('activitylogs.index') }}" class="list-group-item list-group-item-action {{ !request()->has('user_id') ? 'active' : '' }}">
                            Tous les utilisateurs
                        </a>
                        @foreach ($users as $user)
                            <a href="{{ route('activitylogs.index', ['user_id' => $user->id]) }}" class="list-group-item list-group-item-action {{ request('user_id') == $user->id ? 'active' : '' }}">
                                {{ $user->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Activity Log Table Card -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Historique des Actions
                            @if(request()->has('user_id'))
                                pour {{ \App\Models\User::find(request('user_id'))->name ?? 'Utilisateur inconnu' }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse ($activityLogs as $log)
                                        <tr>
                                            <td>{{ $log->action }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Aucun journal d'activité trouvé.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $activityLogs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
