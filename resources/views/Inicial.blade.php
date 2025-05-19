<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submersos</title>
    <link rel="stylesheet" href="{{ asset('css/inicial.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imagens/leao.png') }}"> 
</head>
<body>
    <header>
        <div class="top-bar">
            <h1>Submersos</h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="#inscricao">Inscrições</a></li>
                    <li><a href="#sobreMov">Sobre o Mov</a></li>
                    <li><a href="#location-info">Localização</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="intro" id="inscricao">
        <h2>Acampamento Submersos</h2>
        <div class="botoes">
            <a href="{{ route('inscricao') }}">
                <button>Inscreva-se</button>
            </a>
            <a href="{{ route('login') }}">
                <button class="secundario">Login</button>
            </a>
        </div>
    </section>

    <section id="sobreMov">
        <div class="conteudo-personalizado">
            <div class="carrossel-conteudo">
                <div class="carrossel-imagens">
                    <div><img src="{{asset('imagens/mov1.jpg')}}" alt="Imagem 1 do Movimento Jovem"></div>
                    <div><img src="{{asset('imagens/mov2.jpg')}}" alt="Imagem 2 do Movimento Jovem"></div>
                    <div><img src="{{asset('imagens/mov3.jpg')}}" alt="Imagem 3 do Movimento Jovem"></div>
                    <div><img src="{{asset('imagens/mov4.jpg')}}" alt="Imagem 3 do Movimento Jovem"></div>
                    <!-- Adicione mais imagens conforme necessário -->
                </div>
                <div class="texto">
                    <h2 style="color: #1e6091;" >Sobre o Movimento Jovem</h2>
                    <p> Somos a juventude da Terceira Igreja Presbiteriana de Campo Mourão - PR, pastoreados com amor e zelo pelo Pr. Edimar e pela Pra. Neuza. Liderados com dedicação por Rafael Costa e Thamara, carregamos a alegria e a responsabilidade de levar as boas novas do Evangelho aonde formos. Cremos que não é preciso atravessar oceanos para ser missionário — entendemos que somos enviados todos os dias, nas escolas, nas faculdades, no trabalho e em cada lugar que o Senhor nos conduz.
                        Como jovens em Cristo, temos como marcas a comunhão verdadeira, a amizade sincera e a alegria de vivermos como família da fé. Somos movidos pelo propósito de refletir o amor de Jesus em tudo o que fazemos, certos de que nossa caminhada tem um alvo claro: Cristo.
                        
                        <em>“Prossigo para o alvo, pelo prêmio da soberana vocação de Deus em Cristo Jesus.”</em> (Filipenses 3:14)
                        
                        Vivemos um tempo de aprendizado, fé e transformação, buscando crescer espiritualmente e caminhar em unidade, como ensina a Palavra:
                        
                        <em>“Como é bom e agradável quando os irmãos convivem em união!”</em> (Salmo 133:1)
                        
                        Nosso desejo é que cada jovem que se junte a nós possa experimentar o amor de Deus, ser edificado na fé e encontrar um lugar de pertencimento. Seguimos com os olhos fixos em Jesus, o autor e consumador da nossa fé (Hebreus 12:2), vivendo com intensidade a missão que Ele nos confiou.
                        
                    </p>
                </div>
            </div>
        </div>
    
        <div class="conteudo">
            <img src="{{asset('imagens/2.png')}}" alt="Imagem do Acampamento Submersos">
            <div class="texto">
                <h2>Submersos</h2>
                <p> O Submersos é mais do que um acampamento jovem — é um chamado para mergulhar nas profundezas do Espírito Santo. Inspirado na visão do profeta Ezequiel, onde as águas se tornam mais profundas a cada passo (Ezequiel 47), nosso desejo é conduzir cada participante a sair da superfície e se entregar por completo à presença de Deus.
                    <em>“...e as águas chegaram aos tornozelos... aos joelhos... aos lombos... até que se tornaram um rio, o qual não se podia atravessar...”</em> (Ezequiel 47:3-5)
                    
                    Essa edição do Submersos é pensada para proporcionar uma experiência intensa de comunhão, reflexão, alegria e transformação. Através de ministrações, louvor, amizades e momentos únicos, buscamos criar um ambiente onde cada jovem possa ser tocado profundamente por Deus.
                    
                    Nosso maior objetivo é que você viva algo novo, real e inesquecível — submerso no amor, na graça e no mover do Espírito. O investimento para essa experiência é de R$200, um valor pequeno diante do que Deus pode fazer na sua vida.
                    
                    Prepare seu coração, sua mochila, seu lenço e venha disposto a se entregar por completo. Porque quem mergulha de verdade, nunca mais volta à superfície do mesmo jeito.
                    
                </p>
            </div>
        </div>
    </section>

    <section id="location-info">    
        <div id="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3642.8243685560074!2d-52.48999782487442!3d-24.072488678451954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ed764ba064e0bd%3A0x8502129e2b0b41e8!2sAFRC%20-%20Acampamento%20Fazenda%20Retiro%20Crist%C3%A3o!5e0!3m2!1spt-BR!2sbr!4v1745430050759!5m2!1spt-BR!2sbr" width="100%" height="300" style="border:2px solid #f39c12; border-radius: 10px;"></iframe>
        </div>
        <div id="contact-info">
            <h3>Contato</h3>
            <p>Email: movimentojovemiprcm@outlook.com</p>
            <p>AFRC - Acampamento Fazenda Retiro Cristão - Campo Mourão, PR</p>
            <p>Dia: 07/08 de Junho.</p>
        </div>
    </section>

    <footer style="text-align: center; padding: 20px;">
        <a href="https://www.instagram.com/jovens_3iprcm/" target="_blank" style="margin: 0 10px; color: inherit;">
          <i class="fab fa-instagram fa-2x"></i>
        </a>
    </footer>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.carrossel-imagens').slick({
                dots: true, // Adiciona pontos de navegação
                infinite: true, // Permite navegação infinita
                speed: 500, // Velocidade da transição
                slidesToShow: 1, // Mostra uma imagem por vez
                slidesToScroll: 1, // Scroll de uma imagem por vez
                autoplay: true, // Ativa o autoplay
                autoplaySpeed: 2000, // Intervalo de troca de imagem
            });
        });
    </script>
</body>
</html>
