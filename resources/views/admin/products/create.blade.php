@extends('layouts.app')

@section('content')

    <h1>Criar Produto</h1>
    <form action="{{ route('admin.products.store') }}" method="post">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="">Nome Produto</label>
            <input class="form-control" type="text" name="name">
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <input class="form-control" type="text" name="description">
        </div>

        <div class="form-group">
            <label for="">Conteúdo</label>
            <textarea class="form-control" cols="30" rows="10" name="body"></textarea>
        </div>

        <div class="form-group">
            <label for="">Preço</label>
            <input class="form-control" type="text" name="price">
        </div>

        <div class="form-group">
            <label for="">Slug</label>
            <input class="form-control" type="text" name="slug">
        </div>

        <div class="form-group">
            <label for="">Lojas</label>
            <select class="form-control" name="store" id="">
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button class="btn btn-lg btn-success" type="submit">Criar Produto</button>
        </div>
    </form>

@endsection
