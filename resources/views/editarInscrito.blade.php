<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Submersos</title>
    <link rel="stylesheet" href="{{ asset('css/editarInscrito.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>
    <div class="container">
        <h1>Editar Inscrição</h1>
        <form method="POST" action="{{ route('editarSubmit', Crypt::encryptString($inscrito->id)) }}">
            @csrf

            {{-- DADOS PESSOAIS --}}
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $inscrito->nome) }}" required maxlength="200">
                @error('nome')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="nome_responsavel">Nome do Responsável</label>
                <input type="text" id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel', $inscrito->nome_responsavel) }}" required maxlength="200">
                @error('nome_responsavel')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email', $inscrito->email) }}" required maxlength="100">
                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- TELEFONES --}}
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" value="{{ old('telefone', $inscrito->telefone) }}" required maxlength="20">
                @error('telefone')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="telefone_emergencia">Telefone de Emergência</label>
                <input type="tel" id="telefone_emergencia" name="telefone_emergencia" value="{{ old('telefone_emergencia', $inscrito->telefone_emergencia) }}" required maxlength="20">
                @error('telefone_emergencia')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- ENDEREÇO (ViaCEP) --}}
            <h3>Endereço</h3>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" value="{{ old('cep', $inscrito->cep) }}" required placeholder="00000-000" maxlength="9" onblur="buscarCep(this.value)">
                @error('cep')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="logradouro">Logradouro</label>
                <input type="text" id="logradouro" name="logradouro" value="{{ old('logradouro', $inscrito->logradouro) }}" required maxlength="100">
                @error('logradouro')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" id="numero" name="numero" value="{{ old('numero', $inscrito->numero) }}" maxlength="10">
                @error('numero')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="complemento">Complemento</label>
                <input type="text" id="complemento" name="complemento" value="{{ old('complemento', $inscrito->complemento) }}" maxlength="100">
                @error('complemento')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro" value="{{ old('bairro', $inscrito->bairro) }}" required maxlength="60">
                @error('bairro')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $inscrito->cidade) }}" required maxlength="60">
                @error('cidade')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="uf">UF</label>
                <input type="text" id="uf" name="uf" value="{{ old('uf', $inscrito->uf) }}" required maxlength="2">
                @error('uf')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- INFORMAÇÕES MÉDICAS --}}
            <h3>Informações Médicas</h3>
            <div class="form-group">
                <label for="restricoes_alimentar">Restrições Alimentares</label>
                <textarea id="restricoes_alimentar" name="restricoes_alimentar" rows="3">{{ old('restricoes_alimentar', $inscrito->restricoes_alimentar) }}</textarea>
                @error('restricoes_alimentar')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="alergia">Alergias</label>
                <textarea id="alergia" name="alergia" rows="3">{{ old('alergia', $inscrito->alergia) }}</textarea>
                @error('alergia')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="remedio_controlado">Remédio Controlado</label>
                <textarea id="remedio_controlado" name="remedio_controlado" rows="3">{{ old('remedio_controlado', $inscrito->remedio_controlado) }}</textarea>
                @error('remedio_controlado')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- IGREJA E MINISTÉRIO --}}
            <div class="form-group">
                <label for="igreja">Igreja</label>
                <input type="text" id="igreja" name="igreja" value="{{ old('igreja', $inscrito->igreja) }}" required maxlength="50">
                @error('igreja')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="ministerio">Ministério</label>
                <select id="ministerio" name="ministerio" required>
                    <option value="" {{ old('ministerio', $inscrito->ministerio)=='' ? 'selected':'' }}>Selecione</option>
                    <option value="nao" {{ old('ministerio', $inscrito->ministerio)=='nao' ? 'selected':'' }}>Não</option>
                    <option value="louvor" {{ old('ministerio', $inscrito->ministerio)=='louvor' ? 'selected':'' }}>Louvor</option>
                    <option value="teatro" {{ old('ministerio', $inscrito->ministerio)=='teatro' ? 'selected':'' }}>Teatro</option>
                    <option value="danca" {{ old('ministerio', $inscrito->ministerio)=='danca' ? 'selected':'' }}>Dança</option>
                    <option value="outro" {{ old('ministerio', $inscrito->ministerio)=='outro' ? 'selected':'' }}>Outro</option>
                </select>
                @error('ministerio')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- CAMISETA --}}
            <div class="form-group">
                <label for="camisa">Já possui camiseta?</label>
                <select id="camisa" name="camisa" required onchange="mostrarTamanho()">
                    <option value="sim" {{ old('camisa', $inscrito->camisa)=='sim' ? 'selected':'' }}>Sim</option>
                    <option value="nao" {{ old('camisa', $inscrito->camisa)=='nao' ? 'selected':'' }}>Não</option>
                </select>
                @error('camisa')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" id="tamanho-container" style="{{ old('camisa', $inscrito->camisa)=='nao'? 'display:block;':'display:none;' }}">
                <label for="tamanho">Tamanho da Camiseta</label>
                <select id="tamanho" name="tamanho">
                    <option value="">Selecione</option>
                    <option value="pp" {{ old('tamanho', $inscrito->tamanho_camisa)=='pp' ? 'selected':'' }}>PP</option>
                    <option value="p" {{ old('tamanho', $inscrito->tamanho_camisa)=='p' ? 'selected':'' }}>P</option>
                    <option value="m" {{ old('tamanho', $inscrito->tamanho_camisa)=='m' ? 'selected':'' }}>M</option>
                    <option value="g" {{ old('tamanho', $inscrito->tamanho_camisa)=='g' ? 'selected':'' }}>G</option>
                    <option value="gg" {{ old('tamanho', $inscrito->tamanho_camisa)=='gg' ? 'selected':'' }}>GG</option>
                </select>
            </div>

            {{-- PAGAMENTO --}}
            <div class="form-group">
                <label for="forma_pagamento">Forma de Pagamento</label>
                <select id="forma_pagamento" name="forma_pagamento" required>
                    <option value="pix" {{ old('forma_pagamento', $inscrito->forma_pagamento)=='pix'? 'selected':'' }}>PIX</option>
                    <option value="cartao" {{ old('forma_pagamento', $inscrito->forma_pagamento)=='cartao'? 'selected':'' }}>Cartão</option>
                    <option value="boleto" {{ old('forma_pagamento', $inscrito->forma_pagamento)=='boleto'? 'selected':'' }}>Boleto</option>
                </select>
                @error('forma_pagamento')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="actions-row">
                <a href="{{ route('admin') }}" class="back-button">Voltar</a>
                <button type="submit" class="salvar">Salvar Alterações</button>
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

        </form>
    </div>

    <script>
        function mostrarTamanho() {
            const camisa = document.getElementById('camisa').value;
            const cont = document.getElementById('tamanho-container');
            if (camisa === 'nao') {
                cont.style.display = 'block';
                document.getElementById('tamanho').setAttribute('required','required');
            } else {
                cont.style.display = 'none';
                document.getElementById('tamanho').removeAttribute('required');
            }
        }
        document.addEventListener('DOMContentLoaded', mostrarTamanho);

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
    </script>
</body>
</html>