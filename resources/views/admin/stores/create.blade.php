@extends('layouts.app')

@section('content')

    <h1>Criar Loja</h1>
    <form action="{{ route('admin.stores.store') }}" method="post">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="">Nome Loja</label>
            <input class="form-control" type="text" name="name">
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <input class="form-control" type="text" name="description">
        </div>

        <div class="form-group">
            <label for="">Telefone</label>
            <input class="form-control" type="text" name="phone">
        </div>

        <div class="form-group">
            <label for="">Celular/Whatsapp</label>
            <input class="form-control" type="text" name="mobile_phone">
        </div>

        <div class="form-group">
            <label for="">Slug</label>
            <input class="form-control" type="text" name="slug">
        </div>

        <div>
            <button class="btn btn-lg btn-success" type="submit">Criar Loja</button>
        </div>
    </form>

@endsection
