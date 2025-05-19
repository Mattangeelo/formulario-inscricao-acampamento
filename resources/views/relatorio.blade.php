<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
            font-size: 11px;
        }

        td {
            font-size: 10px;
        }

        /* Colunas com largura menor */
        .col-pequena {
            width: 50px;
        }

        .col-media {
            width: 100px;
        }

        .col-grande {
            width: 150px;
        }
    </style>
</head>
<body>
    <h2>Relatório de Inscritos</h2>
    <table>
        <thead>
            <tr>
                <th class="col-grande">Nome</th>
                <th class="col-grande">Nome Do Resp.</th>
                <th class="col-media">CPF</th>
                <th class="col-grande">Email</th>
                <th class="col-media">Telefone</th>
                <th class="col-media">Telefone Emergência</th>
                <th class="col-grande">Restrições Alimentares</th>
                <th class="col-grande">Alergias</th>
                <th class="col-grande">Remédio Controlado</th>
                <th class="col-media">Igreja</th>
                <th class="col-media">Ministério</th>
                <th class="col-pequena">Camisa</th>
                <th class="col-grande">Endereço</th>
                <th class="col-pequena">Número</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscritos as $inscrito)
                <tr>
                    <td>{{ $inscrito->nome }}</td>
                    <td>{{ $inscrito->nome_responsavel }}</td>
                    <td>{{ $inscrito->cpf }}</td>
                    <td>{{ $inscrito->email }}</td>
                    <td>{{ $inscrito->telefone }}</td>
                    <td>{{ $inscrito->telefone_emergencia }}</td>
                    <td>{{ $inscrito->restricoes_alimentar }}</td>
                    <td>{{ $inscrito->alergia }}</td>
                    <td>{{ $inscrito->remedio_controlado }}</td>
                    <td>{{ $inscrito->igreja }}</td>
                    <td>{{ $inscrito->ministerio }}</td>
                    <td>
                        {{ $inscrito->camisa === 'sim' ? 'Sim' : 'Não' }}
                        @if($inscrito->tamanho_camisa)
                            ({{ strtoupper($inscrito->tamanho_camisa) }})
                        @endif
                    </td>
                    <td>{{ $inscrito->logradouro }}</td>
                    <td>{{ $inscrito->numero }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
