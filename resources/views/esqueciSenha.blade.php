<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submersos</title>
    <link rel="stylesheet" href="{{ asset('css/esqueciSenha.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>
    <div class="container">
        <h2>Recuperação de Senha</h2>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('esqueciConfirma') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="token">Código de Confirmação:</label>
                <input type="text" id="token" name="token" class="form-control" required maxlength="6" placeholder="Insira o código de 6 dígitos">
            </div>

            <div class="form-group">
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" class="form-control" required placeholder="Digite sua nova senha">
            </div>

            <div class="form-group">
                <label for="confirmar_senha">Confirmar Nova Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" required placeholder="Confirme sua nova senha">
            </div>

            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
        
        <div class="footer">
            <p><a href="{{ route('login') }}">Voltar ao login</a></p>
        </div>
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