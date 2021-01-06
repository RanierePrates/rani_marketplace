@extends('layouts.app')

@section('content')

    <h1>Criar Loja</h1>
    <form action="{{ route('admin.stores.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="">Nome Loja</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}">

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <input class="form-control @error('description') is-invalid @enderror" type="text" name="description" value="{{ old('description') }}">
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Telefone</label>
            <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Celular/Whatsapp</label>
            <input class="form-control @error('mobile_phone') is-invalid @enderror" id="mobile_phone" type="text" name="mobile_phone" value="{{ old('mobile_phone') }}">
            @error('mobile_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Logo</label>
            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" multiple>
            @error('logo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div>
            <button class="btn btn-lg btn-success" type="submit">Criar Loja</button>
        </div>
    </form>

@endsection

@section('scripts')
    <script>
        let maskPhone = new Inputmask('(99) 9999-9999');
        maskPhone.mask(document.getElementById('phone'));

        let maskMobilePhone = new Inputmask('(99) 99999-9999');
        maskPhone.mask(document.getElementById('mobile_phone'));
    </script>
@endsection
