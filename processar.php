<?php

    $dados = [
        'nome'       => $_POST['nome']       ?? '',
        'email'      => $_POST['email']      ?? '',
        'genero'     => $_POST['genero']     ?? '',
        'interesses' => $_POST['interesses'] ?? '',
        'cidade'     => $_POST['cidade']     ?? '',
        'mensagem'   => $_POST['mensagem']   ?? '',
    ];

    foreach ($dados as $campos => $valor) {
        if (empty($valor)) {
            echo "O campo $chave é obrigatório.<br>";
        }
    }

    if (!str_contains($dados['email'], '@')){
        echo "O email é Inválido.";
    }

    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo</title>
</head>
<body>

    Bem-vindo, <?= $dados['nome'] ?>
    <hr>

    <p> Seu e-mail é: <b> <?= $dados['email'] ?> </b></p>

    <p> Áreas de Interesse: </p>
    <ul>
        <?php foreach ($dados['interesses'] as $interesse): ?>
            <li> <?= $interesse ?> </li>
        <?php endforeach; ?>
    </ul>

    <p> Cidade: <b><?= $dados['cidade'] ?> </b> </p>
    <p> Mensagem Fofita: </p>
    <p> <?= $dados['mensagem'] ?> </p>

</body>
</html>