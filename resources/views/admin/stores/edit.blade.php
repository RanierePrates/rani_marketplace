@extends('layouts.app')

@section('content')
    <h1>Criar Loja</h1>
    <form action="{{ route('admin.stores.update', ['store' => $store->id]) }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('PUT')

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
            <p>
                <img src="{{ asset('storage/'. $store->logo) }}" alt="" class="img-fluid">
            </p>

            <label>Logo</label>
            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" multiple>
            @error('logo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
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
