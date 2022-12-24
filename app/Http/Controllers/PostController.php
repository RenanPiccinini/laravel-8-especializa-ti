<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(1); //ordena pelo campo e ordem que eu informar
        //$posts = Post::latest()->paginate(); // deixa sempre o registor mais novo primeiro

        $posts = Post::all();

        return view('admin.posts.index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request)
    {
        $data = $request->all(); //$data recebe todos os campos

        if($request->image->isValid()){ //se o arquivo é valido ele faz o upload pra dentro da pasta 'posts' que ele

            //definindo o nome da foto, pegou o nome do titulo, personalizou para tirar os espeços e colocar '-' no lugar
            //não esquecer de importar use Illuminate\Support\Str;
            //$request->image->getClientOriginalClient()    pega a extensão da imagem
            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->extension();

            $image = $request->image->storeAs('posts', $nameFile); //cria automaticamente em storage/app, assim cria um nome aleatório p/ foto

            $data['image'] = $image; //$data recebe todos os campos, aqui na posição 'image' ele vai receber a imagem
        }

        Post::create($data); //assim ou igual abaixo informando campo por campo

        /*
        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            ''
        ]);
        */

        return redirect()
                ->route('posts-index')
                ->with('message', 'Post Criado com sucesso');
    }

    public function show($id)
    {
        //$post = Post::where('id', $id)->first();  ou   $post = Post::find($id)
        if(!$post = Post::find($id)){ //se for diferente do id, se o id não existir ele retorna pra index
            return redirect()->route('posts-index');
        }

        return view('admin.posts.show', [
            'post' => $post,
        ]);
    }

    public function destroy($id)
    {
        //$post = Post::where('id', $id)->first();  ou   $post = Post::find($id)
        if(!$post = Post::find($id)){ //se for diferente do id, se o id não existir ele retorna pra index
            return redirect()->route('posts-index');
        }

        if(Storage::exists($post->image)){ //verifica se já existe o arquivo image
            Storage::delete($post->image);  // se existir ele deleta
        }

        $post->delete();

        return redirect()
                ->route('posts-index')
                ->with('message', 'Post deletado com sucesso');
    }

    public function edit($id)
    {
        if(!$post = Post::find($id)){ //se for diferente do id, se o id não existir ele retorna pra index
            return redirect()->back();
        }

        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(StoreUpdatePost $request, $id)
    {
        if(!$post = Post::find($id)){ //se for diferente do id, se o id não existir ele retorna pra index
            return redirect()->back();
        }

        //pega a mesma lógica do  método create, alterando pra quando mandar outro arquivo ele
        //deletar o existente e mandar o novo arquivo da edição
        //inserir também o $request->image &&  no if
        $data = $request->all();

        if($request->image && $request->image->isValid()){ //se for diferente de null e válido

            if(Storage::exists($post->image)){ //verifica se já existe o image
                Storage::delete($post->image);  // se existir ele deleta
            }

            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->extension();

            $image = $request->image->storeAs('posts', $nameFile);

            $data['image'] = $image;
        }


        $post->update($data);

        return redirect()
                ->route('posts-index')
                ->with('message', 'Post Atualizado com sucesso');
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $posts = Post::where('title', 'LIKE', "%{$request->search}%") //busca onde tenha
                      ->orWhere('body', '=', $request->search) //busca somente se for igual
                      ->paginate();

        return view('admin.posts.index', [
            'posts' => $posts,
            'filters' => $filters
        ]);
    }
}
