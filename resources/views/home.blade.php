@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="m-0">Postagens</p>

                    <div>
                        <button
                            type="button"
                            class="btn btn-labeled btn-success"
                            onclick="window.location='{{ URL::to('posts/novo') }}'"
                        >+ Nova</button>
                    </div>
                </div>
            </div>

            @foreach ($postagens as $post)
                <div class="row my-3 post-item">
                    <div class="col-md-12">
                        <div class="card rounded-lg border-0 shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="{{ asset('storage/posts/' . $post->imagem) }}" alt="{{ $post->titulo }}">
                                    </div>

                                    <div class="col-md-9">
                                        <a href="{{ route('posts.show', $post->id) }}" title="{{ $post->titulo }}">
                                            <h3 class="card-title text-dark">{{ $post->titulo }}</h3>
                                            <p class="card-text text-dark">{{ substr($post->descricao, 0, 300) . '...' }}</p>
                                        </a>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        @if ($post->ativa == 'N')
                                            <button
                                                onclick="publish(this)"
                                                data-url="{{ route('posts.publish', $post->id) }}"
                                                class="btn btn-outline-primary"
                                            >Publicar</button>
                                        @endif

                                        @if (!$post->deleted_at)
                                            <button
                                                onclick="destroy(this)"
                                                data-url="{{ route('posts.destroy', $post->id) }}"
                                                class="btn btn-outline-danger ml-2"
                                            >Deletar</button>
                                        @endif
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

@section('scripts')
    <script src="{{ asset('js/posts.js') }}" defer></script>
@endsection
