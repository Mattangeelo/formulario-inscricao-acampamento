<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Inscrição</title>
</head>
<body>
    <p>Olá, {{ $nome }}!</p>
    <p>Obrigado por se inscrever em nosso sistema.</p>
    <p>Seu código de confirmação é: <strong>{{ $token }}</strong></p>
    <p>Por favor, insira este código na página de confirmação para ativar sua conta.</p>
    <p>Se você não solicitou esta inscrição, pode ignorar este e-mail.</p>
</body>
</html>