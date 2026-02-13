<?php
// 1. Captura de dados (usando operador ?? para evitar erros se estiver vazio)
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$interesses = $_POST['areas_interesse'] ?? []; // Array!
$nivel = $_POST['nivel'] ?? 'Não informado';
$observacoes = $_POST['observacoes'] ?? '';

// Variáveis de controle
$mensagem_erro = '';
$caminho_arquivo = '';

// 2. Validação Básica
if (empty($nome) || empty($email)) {
    $mensagem_erro = "Preencha o Nome e o E-mail!";
}

// 3. O DESAFIO: Upload e separação de pastas
if (empty($mensagem_erro) && isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] == 0) {
    
    $arquivo = $_FILES['curriculo'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $novo_nome = uniqid() . "." . $extensao;

    // Define as pastas
    $pasta_pdf = "uploads/pdf/";
    $pasta_doc = "uploads/doc/";

    // Cria as pastas se não existirem (pra não dar erro)
    if (!is_dir($pasta_pdf)) mkdir($pasta_pdf, 0777, true);
    if (!is_dir($pasta_doc)) mkdir($pasta_doc, 0777, true);

    $destino = "";

    // A Lógica que criamos juntos:
    if ($extensao == 'pdf') {
        $destino = $pasta_pdf . $novo_nome;
    } elseif ($extensao == 'doc' || $extensao == 'docx') {
        $destino = $pasta_doc . $novo_nome;
    } else {
        $mensagem_erro = "Formato inválido! Envie apenas PDF ou DOC.";
    }

    // Tenta mover o arquivo se o destino foi definido
    if ($destino != "" && move_uploaded_file($arquivo['tmp_name'], $destino)) {
        $caminho_arquivo = $destino;
    } elseif ($destino != "" && empty($mensagem_erro)) {
        $mensagem_erro = "Erro ao salvar o arquivo no servidor.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5 bg-light">
    
    <div class="card p-4 shadow-sm">
        <?php if ($mensagem_erro): ?>
            <div class="alert alert-danger">
                <?= $mensagem_erro ?>
                <br>
                <a href="form_cadastro.html" class="btn btn-warning mt-2">Voltar</a>
            </div>
        <?php else: ?>
            
            <h2 class="text-success">Cadastro Recebido!</h2>
            <hr>
            <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?> <?= htmlspecialchars($_POST['sobrenome'] ?? '') ?></p>
            <p><strong>E-mail:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Nível:</strong> <?= htmlspecialchars($nivel) ?></p>

            <p><strong>Interesses:</strong></p>
            <ul>
                <?php foreach ($interesses as $item): ?>
                    <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>

            <?php if ($caminho_arquivo): ?>
                <div class="alert alert-info">
                    <strong>Arquivo enviado com sucesso!</strong><br>
                    Salvo em: <code><?= $caminho_arquivo ?></code>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

</body>
</html>