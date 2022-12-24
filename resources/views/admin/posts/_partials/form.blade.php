@if($errors->any()) {{-- método any retorna true se tiver errors, é false por default --}}
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@csrf
        <input type="file" name="image" id="image"><br><br>

        <input type="text" name="title" id="title" placeholder="Titulo..." value="{{ $post->title ?? old('title') }}"> <br><br>

        <textarea name="body" id="body" cols="30" rows="4" placeholder="Conteudo" value="{{ $post->body ?? old('body') }}"></textarea>
        <br><br>

<button type="submit">Enviar</button>
