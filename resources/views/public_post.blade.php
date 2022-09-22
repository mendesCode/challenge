@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="text-right mb-2 text-secondary">{{ (new DateTime($post->created_at))->format('d M Y') }}</div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title text-center m-0">{{ $post->titulo }}</h2>
                </div>

                <div class="card-body">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-8 mx-auto">
                            <img src="{{ asset('storage/posts/' . $post->imagem) }}" alt="{{ $post->titulo }}" class="w-100">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">{{ $post->descricao }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
