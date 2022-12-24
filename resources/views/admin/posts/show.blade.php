@extends('admin.layouts.app')

@section('title', 'Criar')

@section('content')

<h1>Detalhes do Post {{ $post->title }}</h1>

<ul>
    <li><strong>Titulo:</strong> {{ $post->title }}</li>
    <li><strong>Conteudo:</strong> {{ $post->body }}</li>
</ul>

<form action="{{ route('posts-destroy', $post->id) }}" method="post">
    @csrf
    @method('DELETE')

    <button>Deletar o post: {{ $post->title }}</button>

</form>

@endsection
