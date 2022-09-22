@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="m-0">Postagens</p>
                </div>
            </div>

            @foreach ($posts as $post)
                <div class="row my-3">
                    <div class="col-md-12">
                        <div class="card rounded-lg border-0 shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="{{ asset('storage/posts/' . $post->imagem) }}" alt="{{ $post->titulo }}">
                                    </div>

                                    <div class="col-md-9">
                                        <a href="{{ route('postagem', $post->id) }}" title="{{ $post->titulo }}">
                                            <h3 class="card-title text-dark">{{ $post->titulo }}</h3>
                                            <p class="card-text text-dark">{{ substr($post->descricao, 0, 300) . '...' }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
