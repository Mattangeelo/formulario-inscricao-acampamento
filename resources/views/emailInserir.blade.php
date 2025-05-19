<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submersos</title>
    <link rel="stylesheet" href="{{ asset('css/emailInserir.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>
    <div class="container">
        <h2>Esqueci Minha Senha</h2>
        <p>Por favor, informe o seu endereço de e-mail cadastrado para que possamos enviar as instruções de recuperação de senha.</p>
        <form action="{{ route('esqueciMinhaSenhaSubmit') }}" method="POST"> <div class="form-group">
            @csrf
                <label for="email">Seu E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="seu@email.com">
            </div>
            <button type="submit">Enviar</button>

        </form>
        <div class="back-link">
            <a href="/login">Voltar para o Login</a> </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>