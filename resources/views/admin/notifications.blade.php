@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.notifications.read.all') }}" class="btn btn-lg btn-success">Marcar todos como lido</a>
            <hr>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Notificação</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($unreadNotifications as $notification)
                <tr>
                    <td>{{ $notification->data['message'] }}</td>
                    <td>{{ $notification->created_at->locale('pt-br')->diffForHumans() }}</td>

                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.notifications.read', ['notification' => $notification->id]) }}" class="btn btn-sm btn-primary">
                                Marcar como lido
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="alert alert-warning">
                            Nenhuma notificação encontrada
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
