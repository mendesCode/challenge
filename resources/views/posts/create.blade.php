@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" id="post-form" data-role="create">
                <div class="progress d-none mb-4">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 1%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="card">
                    <div class="card-header">Nova postagem</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input name="titulo" id="titulo" type="text" class="d-block w-100 form-control">
                                    <div class="error-message text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea name="descricao" id="descricao" class="d-block w-100 form-control" rows="8"></textarea>
                                    <div class="error-message text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="imagem">Selecione uma imagem</label>
                                    <input name="imagem" id="imagem" type="file" accept="image/*" class="custom-file-input">
                                    <div class="error-message text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-lg btn-block">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/posts.js') }}" defer></script>
@endsection
