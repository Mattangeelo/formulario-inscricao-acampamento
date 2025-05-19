<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição - Submersos</title>
    <link rel="stylesheet" href="{{ asset('css/inscricao.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <section class="form-container">
        <h2>Faça sua Inscrição</h2>
        <form action="{{ route('inscricaoSubmit') }}" method="POST" novalidate>
            @csrf

            {{-- DADOS PESSOAIS --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required maxlength="200">
                    @error('nome') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="nome_responsavel">Nome do Responsável:</label>
                    <input type="text" id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel') }}" required maxlength="200">
                    @error('nome_responsavel') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required placeholder="000.000.000-00" maxlength="14">
                    @error('cpf') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="50">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    @if(session('emailError'))
                        <div class="text-danger">{{ session('emailError') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="form-group password-input">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required minlength="6" maxlength="16">
                    <button type="button" class="toggle-password">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                    @error('senha') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                    @error('data_nascimento') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" required maxlength="20">
                    @error('telefone') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="telefone_emergencia">Telefone de Emergência:</label>
                    <input type="tel" id="telefone_emergencia" name="telefone_emergencia" value="{{ old('telefone_emergencia') }}" required maxlength="20">
                    @error('telefone_emergencia') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- ENDEREÇO (ViaCEP) --}}
            <h3>Endereço</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" value="{{ old('cep') }}" required placeholder="00000-000" maxlength="9" onblur="buscarCep(this.value)">
                    @error('cep') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="logradouro">Logradouro:</label>
                    <input type="text" id="logradouro" name="logradouro" value="{{ old('logradouro') }}" required maxlength="100">
                    @error('logradouro') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" id="numero" name="numero" value="{{ old('numero') }}" maxlength="10">
                    @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" value="{{ old('complemento') }}" maxlength="100">
                    @error('complemento') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" value="{{ old('bairro') }}" required maxlength="60">
                    @error('bairro') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}" required maxlength="60">
                    @error('cidade') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="uf">UF:</label>
                    <input type="text" id="uf" name="uf" value="{{ old('uf') }}" required maxlength="2">
                    @error('uf') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- DADOS MÉDICOS --}}
            <h3>Informações Médicas</h3>
            <div class="form-group">
                <label for="restricoes_alimentar">Restrições Alimentares:</label>
                <textarea id="restricoes_alimentar" name="restricoes_alimentar" rows="3">{{ old('restricoes_alimentar') }}</textarea>
                @error('restricoes_alimentar') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="alergia">Alergias:</label>
                <textarea id="alergia" name="alergia" rows="3">{{ old('alergia') }}</textarea>
                @error('alergia') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="remedio_controlado">Remédio Controlado:</label>
                <textarea id="remedio_controlado" name="remedio_controlado" rows="3">{{ old('remedio_controlado') }}</textarea>
                @error('remedio_controlado') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- IGREJA E MINISTÉRIO --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="igreja">Igreja:</label>
                    <input type="text" id="igreja" name="igreja" value="{{ old('igreja') }}" required maxlength="50">
                    @error('igreja') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="ministerio">Ministério:</label>
                    <select id="ministerio" name="ministerio" required>
                        <option value="">Selecione</option>
                        <option value="nao"   {{ old('ministerio')=='nao'   ? 'selected' : '' }}>Não</option>
                        <option value="louvor"{{ old('ministerio')=='louvor'? 'selected' : '' }}>Louvor</option>
                        <option value="teatro"{{ old('ministerio')=='teatro'? 'selected' : '' }}>Teatro</option>
                        <option value="danca" {{ old('ministerio')=='danca' ? 'selected' : '' }}>Dança</option>
                        <option value="outro" {{ old('ministerio')=='outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                    @error('ministerio') <div class="text-danger">{{ $message }}</div> @enderror
                    @if(session('ministerioError'))<div class="text-danger">{{ session('ministerioError') }}</div>@endif
                </div>
            </div>

            {{-- CAMISETA --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="camisa">Já possui camiseta?</label>
                    <select id="camisa" name="camisa" required onchange="mostrarTamanho()">
                        <option value="">Selecione</option>
                        <option value="sim" {{ old('camisa')=='sim'? 'selected':'' }}>Sim</option>
                        <option value="nao" {{ old('camisa')=='nao'? 'selected':'' }}>Não</option>
                    </select>
                    @error('camisa') <div class="text-danger">{{ $message }}</div> @enderror
                    @if(session('tamanhoError'))<div class="text-danger">{{ session('tamanhoError') }}</div>@endif
                </div>
                <div class="form-group" id="tamanho-container" style="display: none;">
                    <label for="tamanho">Tamanho da Camiseta:</label>
                    <select id="tamanho" name="tamanho">
                        <option value="">Selecione</option>
                        <option value="pp" {{ old('tamanho')=='pp'? 'selected':'' }}>PP</option>
                        <option value="p"  {{ old('tamanho')=='p'?  'selected':'' }}>P</option>
                        <option value="m"  {{ old('tamanho')=='m'?  'selected':'' }}>M</option>
                        <option value="g"  {{ old('tamanho')=='g'?  'selected':'' }}>G</option>
                        <option value="gg" {{ old('tamanho')=='gg'? 'selected':'' }}>GG</option>
                    </select>
                </div>
            </div>

            {{-- PAGAMENTO --}}
            <div class="form-group">
                <label for="forma_pagamento">Forma de Pagamento:</label>
                <select id="forma_pagamento" name="forma_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="pix"   {{ old('forma_pagamento')=='pix'   ? 'selected' : '' }}>PIX</option>
                    <option value="cartao"{{ old('forma_pagamento')=='cartao'? 'selected' : '' }}>Cartão</option>
                </select>
                @error('forma_pagamento') <div class="text-danger">{{ $message }}</div> @enderror
                @if(session('pagamentoError'))<div class="text-danger">{{ session('pagamentoError') }}</div>@endif
            </div>

            <div class="form-group termos-condicoes"required>
                <input type="checkbox" id="termos" name="termos" required {{ old('termos') ? 'checked' : '' }}>
                <label for="termos">
                    Declaro que li e aceito os <a href="{{ route('termos') }}" target="_blank">Termos e Condições</a>.
                </label>
                @error('termos') <div class="text-danger">{{ $message }}</div> @enderror
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

            <button type="submit">Enviar Inscrição</button>

        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.querySelector('.password-input input[type="password"]');
            const togglePasswordButton = document.querySelector('.password-input .toggle-password i'); // Seleciona o ícone dentro do botão

            if (togglePasswordButton && passwordInput) {
                togglePasswordButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye'); // Alterna a classe do ícone para 'olho'
                    this.classList.toggle('fa-eye-slash'); // e 'olho cortado' (se você tiver esse ícone)

                    // Ajuste para outras bibliotecas de ícones conforme necessário
                    if (this.classList.contains('fa-eye')) {
                        this.setAttribute('title', 'Mostrar senha');
                    } else {
                        this.setAttribute('title', 'Ocultar senha');
                    }
                });
            }
        });
        // mostra/oculta e seta required no tamanho
        function mostrarTamanho() {
            const camisa = document.getElementById('camisa');
            const cont = document.getElementById('tamanho-container');
            const tamanho = document.getElementById('tamanho');
            if (camisa.value === 'nao') {
                cont.style.display = 'block';
                tamanho.setAttribute('required','required');
            } else {
                cont.style.display = 'none';
                tamanho.removeAttribute('required');
                tamanho.value = '';
            }
        }
        document.addEventListener('DOMContentLoaded', mostrarTamanho);

        document.addEventListener('DOMContentLoaded', function () {
            const cpfInput = document.getElementById('cpf');

            cpfInput.addEventListener('input', function () {
                let value = cpfInput.value.replace(/\D/g, ''); // remove tudo que não for número

                if (value.length > 11) value = value.slice(0, 11);

                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

                cpfInput.value = value;
            });
        });

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
