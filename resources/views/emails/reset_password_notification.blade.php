<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redefinir Senha - RH-INFOSI</title>
</head>
<body>
    <p>Olá,</p>
    <p>Você solicitou a redefinição de sua senha. Clique no link abaixo para redefinir sua senha:</p>
    <p>
        <a href="{{ route('resetPassword', ['token' => $token, 'email' => $email]) }}">
            Redefinir Senha
        </a>
    </p>
    <p>Se você não solicitou essa alteração, por favor, ignore este e-mail.</p>
    <p>Atenciosamente,</p>
    <p>Equipe RH-INFOSI</p>
</body>
</html>
