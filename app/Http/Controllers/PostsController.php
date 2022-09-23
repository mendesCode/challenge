<?php

namespace App\Http\Controllers;

use App\Postagem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Postagem $post)
    {
        return view('posts.show', compact('post'));
    }

    public function novo()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|unique:postagem|max:120',
            'descricao' => 'required',
            'imagem' => 'required|mimes:jpg,jpeg,png,svg,bmp'
        ]);

        $post = new Postagem($data);

        $imagePath = $request->file('imagem')->store('public/posts');
        $imagePath = substr($imagePath, (strrpos($imagePath, '/') + 1));

        $post->imagem = $imagePath;

        if ($post->save()) {
            $request->session()->flash('success', 'A postagem foi cadastrada com sucesso.');

            return response([
                'result' => true,
                'message' => 'A postagem foi cadastrada com sucesso.',
                'post' => $post
            ], 200);
        } else {
            return response([
                'result' => false,
                'message' => 'Não foi possível cadastrar a postagem. Por favor, tente novamente.'
            ], 400);
        }
    }

    public function edit(Postagem $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $post = Postagem::find($id);

        $data = $request->validate([
            'titulo' => ['filled', 'max:120', Rule::unique('postagem')->ignore($post)],
            'descricao' => 'filled',
            'imagem' => 'mimes:jpg,jpeg,png,svg,bmp'
        ]);

        $post->fill($data);

        if ($request->has('imagem')) {
            $imagePath = $request->file('imagem')->store('public/posts');
            $imagePath = substr($imagePath, (strrpos($imagePath, '/') + 1));

            $post->imagem = $imagePath;
        }

        if ($post->save()) {
            $request->session()->flash('success', 'A postagem foi atualizada com sucesso.');

            return response([
                'result' => true,
                'post' => $post
            ], 200);
        }

        return response([
            'result' => false,
            'message' => 'Não foi possível atualizar a postagem. Por favor, tente novamente.'
        ], 422);
    }

    public function publish($id)
    {
        $post = Postagem::where('id', $id)->where('ativa', 'N')->firstOrFail();

        $post->ativa = 'S';
        $result = (bool) $post->save();

        if ($result) {
            $message = 'A postagem foi publicada com sucesso.';
            $statusCode = 200;
        } else {
            $message = 'Não foi possível publicar a postagem. Por favor, tente novamente.';
            $statusCode = 422;
        }

        return response(compact('result', 'message'), $statusCode);
    }

    public function destroy($id)
    {
        $result = (bool) Postagem::destroy($id);

        if ($result) {
            $message = 'A postagem foi deletada com sucesso.';
            $statusCode = 200;
        } else {
            $message = 'Não foi possível deletar a postagem. Por favor, tente novamente.';
            $statusCode = 422;
        }

        return response(compact('result', 'message'), $statusCode);
    }
}
