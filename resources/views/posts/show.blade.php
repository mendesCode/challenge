@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title m-0">Postagem</h6>

                    <div>
                        <a href="{{ route('posts.edit', $post->id) }}" title="Editar" class="btn btn-labeled btn-primary">Editar</a>
                    </div>
                </div>

                <div class="card-body">
                    <p class="m-0"><strong class="mr-1">ID</strong> {{ $post->id }}</p>
                    <p class="m-0"><strong class="mr-1">Título</strong> {{ $post->titulo }}</p>
                    <p class="m-0">
                        <strong class="mr-1">Ativa</strong>

                        @if ($post->ativa == 'S')
                            <span class="badge badge-primary">Sim</span>
                        @elseif ($post->ativa == 'N')
                            <span class="badge badge-danger">Não</span>
                        @endif
                    </p>
                    <p class="m-0"><strong class="mr-1">Criado em</strong> {{ (new DateTime($post->created_at))->format('d/m/Y') }}</p>
                    <p class="m-0"><strong class="mr-1">Modificado em</strong> {{ (new DateTime($post->updated_at))->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title m-0">Descrição</h6>
                        </div>

                        <div class="card-body">
                            <p class="card-text">{{ $post->descricao }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title m-0">Imagem</h6>
                        </div>

                        <div class="card-body">
                            <div><img src="{{ asset('storage/posts/' . $post->imagem) }}" alt="{{ $post->titulo }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
