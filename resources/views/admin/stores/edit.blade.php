@extends('layouts.app')

@section('content')
    <h1>Criar Loja</h1>
    <form action="{{ route('admin.stores.update', ['store' => $store->id]) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="">Nome Loja</label>
            <input class="form-control" type="text" name="name" value="{{ $store->name }}">
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <input class="form-control" type="text" name="description" value="{{ $store->description }}">
        </div>

        <div class="form-group">
            <label for="">Telefone</label>
            <input class="form-control" type="text" name="phone" value="{{ $store->phone }}">
        </div>

        <div class="form-group">
            <label for="">Celular/Whatsapp</label>
            <input class="form-control" type="text" name="mobile_phone" value="{{ $store->mobile_phone }}">
        </div>

        <div class="form-group">
            <label for="">Slug</label>
            <input class="form-control" type="text" name="slug" value="{{ $store->slug }}">
        </div>

        <div>
            <button class="btn btn-lg btn-success" type="submit">Atualizar Loja</button>
        </div>
    </form>

@endsection
