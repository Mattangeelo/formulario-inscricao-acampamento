<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Submersos</title>
  <link rel="stylesheet" href="{{ asset('css/conclusao.css') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>

  <div class="titulo">Ache o Macio!</div>

  
  <img id="macio" src="{{asset('imagens/macio.png')}}" alt="Macio" title="Clique em mim!">

  
  <div id="mensagem">
    <p id="mensagem-texto">🎉 Parabéns, bem-vindo ao acampamento Submersos! 🎉</p>
    <button id="fechar">Fechar</button>
  </div>

  <script>
    const macio = document.getElementById('macio');
    const mensagem = document.getElementById('mensagem');
    const fechar = document.getElementById('fechar');
    const mensagemTexto = document.getElementById('mensagem-texto');

  
    const nomePessoa = @json($nome); 

  function posicionarMacio() {
    const largura = window.innerWidth;
    const altura = window.innerHeight;

    const maxX = largura - macio.width;
    const maxY = altura - macio.height;

    const posX = Math.floor(Math.random() * maxX);
    const posY = Math.floor(Math.random() * maxY);

    macio.style.left = `${posX}px`;
    macio.style.top = `${posY}px`;
  }

  window.addEventListener('load', posicionarMacio);

  macio.addEventListener('click', () => {
    mensagemTexto.textContent = `🎉 Parabéns, ${nomePessoa}, bem-vindo ao acampamento Submersos! 🎉`;
    mensagem.style.display = 'block';
  });

  fechar.addEventListener('click', () => {
    mensagem.style.display = 'none';
    posicionarMacio();
  });
    
  </script>

</body>
</html>
