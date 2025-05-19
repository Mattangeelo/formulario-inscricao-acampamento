<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--Problema de volta com o botão do navegador--}}
    @if(session('user'))
        <script>
        window.location.href = "{{ session('user')['is_admin'] ? route('admin') : route('conclusao') }}";
        </script>
    @endif
    
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}">   
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="{{ route('loginSubmit') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="{{old('email')}}"required>
                {{--Show error--}}
                @error('email')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" value="{{old('password')}}"required>
                {{--Show error--}}
                @error('password')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="esqueci">
                <a href="{{route('esqueciMinhaSenha')}}">Esqueceu sua senha ?</a>
            </div>

            <button type="submit">Entrar</button>

            {{--Email ja existe no BD--}}
            @if(session('loginError'))
                <div class="alert alert-danger text-center">
                    {{ session('loginError') }}
                </div>
            @endif
        </form>
    </div>
</body>
</html>
