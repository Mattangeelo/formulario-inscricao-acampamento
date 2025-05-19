<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Submersos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/inscritoConcluir.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>
    <div class="container">
        <h1>Confirme seus dados</h1>

        <form action="{{ route('concluirLogInscricao') }}" method="POST" validate>
            @csrf

            <fieldset>
                <legend>Dados Pessoais</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email', session('user.email')) }}" required readonly>
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome', session('user.nome')) }}" required maxlength="200">
                        @error('nome')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="nome_responsavel">Nome do Responsável</label>
                        <input type="text" id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel', session('user.nome_responsavel')) }}" required maxlength="200">
                        @error('nome_responsavel')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Telefones</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" value="{{ old('telefone', session('user.telefone')) }}" required maxlength="20">
                        @error('telefone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="telefone_emergencia">Telefone de Emergência</label>
                        <input type="tel" id="telefone_emergencia" name="telefone_emergencia" value="{{ old('telefone_emergencia', session('user.telefone_emergencia')) }}" required maxlength="20">
                        @error('telefone_emergencia')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    </div>
            </fieldset>

            <fieldset>
                <legend>Endereço</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep" value="{{ old('cep', session('user.cep')) }}" required placeholder="00000-000" maxlength="9" onblur="buscarCep(this.value)">
                        @error('cep')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro" value="{{ old('logradouro', session('user.logradouro')) }}" required maxlength="100">
                        @error('logradouro')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="numero" value="{{ old('numero', session('user.numero')) }}" maxlength="10">
                        @error('numero')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento" value="{{ old('complemento', session('user.complemento')) }}" maxlength="100">
                        @error('complemento')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" value="{{ old('bairro', session('user.bairro')) }}" required maxlength="60">
                        @error('bairro')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" value="{{ old('cidade', session('user.cidade')) }}" required maxlength="60">
                        @error('cidade')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="uf">UF</label>
                        <input type="text" id="uf" name="uf" value="{{ old('uf', session('user.uf')) }}" required maxlength="2">
                        @error('uf')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Informações Médicas</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label for="restricoes_alimentar">Restrições Alimentares</label>
                        <textarea id="restricoes_alimentar" name="restricoes_alimentar" rows="3">{{ old('restricoes_alimentar', session('user.restricoes_alimentar')) }}</textarea>
                        @error('restricoes_alimentar')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="alergia">Alergias</label>
                        <textarea id="alergia" name="alergia" rows="3">{{ old('alergia', session('user.alergia')) }}</textarea>
                        @error('alergia')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="remedio_controlado">Remédio Controlado</label>
                        <textarea id="remedio_controlado" name="remedio_controlado" rows="3">{{ old('remedio_controlado', session('user.remedio_controlado')) }}</textarea>
                        @error('remedio_controlado')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Igreja e Ministério</legend>
                <div class="form-group">
                    <label for="igreja">Igreja</label>
                    <input type="text" id="igreja" name="igreja" value="{{ old('igreja', session('user.igreja')) }}" required maxlength="50">
                    @error('igreja')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="ministerio">Ministério</label>
                    <select id="ministerio" name="ministerio" required>
                        <option value="" {{ old('ministerio', session('user.ministerio'))=='' ? 'selected':'' }}>Selecione</option>
                        <option value="nao" {{ old('ministerio', session('user.ministerio'))=='nao' ? 'selected':'' }}>Não</option>
                        <option value="louvor" {{ old('ministerio', session('user.ministerio'))=='louvor' ? 'selected':'' }}>Louvor</option>
                        <option value="teatro" {{ old('ministerio', session('user.ministerio'))=='teatro' ? 'selected':'' }}>Teatro</option>
                        <option value="danca" {{ old('ministerio', session('user.ministerio'))=='danca' ? 'selected':'' }}>Dança</option>
                        <option value="outro" {{ old('ministerio', session('user.ministerio'))=='outro' ? 'selected':'' }}>Outro</option>
                    </select>
                    @error('ministerio')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </fieldset>

            <fieldset>
                <legend>Pagamento</legend>
                <div class="form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <select id="forma_pagamento" name="forma_pagamento" required>
                        <option value="pix" {{ old('forma_pagamento', session('user.forma_pagamento'))=='pix'? 'selected':'' }}>PIX</option>
                        <option value="cartao" {{ old('forma_pagamento', session('user.forma_pagamento'))=='cartao'? 'selected':'' }}>Cartão</option>
                    </select>
                    @error('forma_pagamento')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </fieldset>

            <div class="actions-row">
                <a href="{{ route('logout') }}" class="back-button">Voltar</a>
                <button type="submit" class="confirm-button">Confirmar e Concluir Inscrição</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const masks = ['telefone', 'telefone_emergencia'];

            masks.forEach(id => {
                const input = document.getElementById(id);
                if (!input) return;

                input.addEventListener('input', function () {
                    let v = input.value.replace(/\D/g, ''); // só números
                    if (v.length > 11) v = v.slice(0, 11);

                    // Se tiver 11 dígitos, assume celular: (XX) 9XXXX-XXXX
                    if (v.length > 10) {
                        v = v.replace(/(\d{2})(\d{5})(\d{1,4})/, '($1) $2-$3');
                    }
                    // 10 dígitos ou menos: (XX) XXXX-XXXX
                    else if (v.length > 6) {
                        v = v.replace(/(\d{2})(\d{4})(\d{1,4})/, '($1) $2-$3');
                    }
                    // entre 3 e 6 dígitos: vai montando (XX) XXXX
                    else if (v.length > 2) {
                        v = v.replace(/(\d{2})(\d{1,4})/, '($1) $2');
                    }
                    // até 2 dígitos: abre o parêntese
                    else {
                        v = v.replace(/(\d{0,2})/, '($1');
                    }

                    input.value = v;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const cepInput = document.getElementById('cep');
            if (!cepInput) return;

            cepInput.addEventListener('input', function () {
                let v = cepInput.value.replace(/\D/g, '');  // remove tudo que não for número
                if (v.length > 8) v = v.slice(0, 8);         // limita a 8 dígitos

                // insere hífen após os cinco primeiros dígitos
                if (v.length > 5) {
                    v = v.replace(/(\d{5})(\d+)/, '$1-$2');
                }

                cepInput.value = v;
            });
        });

        // Exemplo rápido de busca ViaCEP
        function buscarCep(cep) {
            cep = cep.replace(/\D/g, '');
            if (cep.length !== 8) return;
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(res => res.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value    = data.bairro;
                        document.getElementById('cidade').value    = data.localidade;
                        document.getElementById('uf').value        = data.uf;
                    }
                });
        }
    </script>
</body>
</html>