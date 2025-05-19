<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Inscrição</title>
</head>
<body>
    <p>Olá, {{ $nome }}!</p>
    <p>Seu código de confirmação é: <strong>{{ $token }}</strong></p>
    <p>Por favor, insira este código na página de recuperação de senha para colocar uma nova senha.</p>
    <p>Se você não solicitou esta recuperação, pode ignorar este e-mail.</p>
</body>
</html>