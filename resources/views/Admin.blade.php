<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submersos</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>
    <header class="admin-header">
        <h1>Submersos</h1>
        <div class="logout-form">
            <a href="/logout" class="btn-logout">Sair</a>
        </div>
    </header>
    <main>
        <section class="inscritos">
            <h2>Inscritos Confirmados</h2>
            <ul>
                @foreach($inscritosPagos as $inscrito)
                    <li>
                        <span>{{ $inscrito->nome }}</span>
                        <div class="acoes">
                            <form action="{{ route('editar', Crypt::encryptString($inscrito->id))}}" method="GET" style="display: inline;">
                                <button type="submit" class="editar">Editar</button>
                            </form>
        
                            <form action="{{ route('deletar',Crypt::encryptString($inscrito->id)) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="button" class="excluir" onclick="abrirModal('{{ route('deletar', Crypt::encryptString($inscrito->id)) }}')">Excluir</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        
            <div>
                {{ $inscritosPendentes->links() }}
            </div>
            <a href="{{ route('relatorio') }}" class="btn btn-primary" target="_blank">Gerar Relatório em PDF</a>
        </section>

        <section class="pendentes">
            <h2>Inscritos Pendentes</h2>
            <ul>
                @foreach($inscritosPendentes as $inscrito)
                    <li>
                        <span>{{ $inscrito->nome }}</span>
                        <div class="acoes">
                            <form action="{{ route('aprovar', Crypt::encryptString($inscrito->id)) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="aprovar">Aprovar</button>
                            </form>
                            <form action="{{ route('editar', Crypt::encryptString($inscrito->id))}}" method="GET" style="display: inline;">
                                <button type="submit" class="editar">Editar</button>
                            </form>
        
                            <form action="{{ route('deletar',Crypt::encryptString($inscrito->id)) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="button" class="excluir" onclick="abrirModal('{{ route('deletar', Crypt::encryptString($inscrito->id)) }}')">Excluir</button>
                            </form>
                        </div>
                    </li>
                @endforeach
                @if(session('errorAprovar'))
                    <div class="alert alert-danger text-center">
                        {{ session('errorAprovar') }}
                    </div>
                @endif
                @if(session('errorExcluir'))
                    <div class="alert alert-danger text-center">
                        {{ session('errorExcluir') }}
                    </div>
                @endif
            </ul>
        
            <div>
                {{ $inscritosPendentes->links() }}
            </div>
        </section>
    </main>
    <!-- Modal de Confirmação -->
    <div id="modal-excluir" class="modal" style="display: none;">
        <div class="modal-conteudo">
            <p>Você quer excluir essa inscrição?</p>
            <form id="formExcluir" method="POST">
                @csrf
                <button type="submit" class="btn-sim">Sim</button>
                <button type="button" class="btn-nao" onclick="fecharModal()">Não</button>
            </form>
        </div>
    </div>

    <script>
        function abrirModal(url) {
            const form = document.getElementById('formExcluir');
            form.action = url;
            document.getElementById('modal-excluir').style.display = 'flex';
        }
        
        function fecharModal() {
            document.getElementById('modal-excluir').style.display = 'none';
        }
    </script>
</body>
</html>
