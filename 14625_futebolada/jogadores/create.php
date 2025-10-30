<?php
include '../inc/config.php';
include '../inc/functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record

    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $golos = isset($_POST['golos']) ? $_POST['golos'] : '';
    $assistencias = isset($_POST['assistencias']) ? $_POST['assistencias'] : '';
    $cartoes_amarelos = isset($_POST['cartoes_amarelos']) ? $_POST['cartoes_amarelos'] : '';
    $cartoes_vermelhos = isset($_POST['cartoes_vermelhos']) ? $_POST['cartoes_vermelhos'] : '';

    if ($nome != '') {
        // Insert new record into the 'tabela' table
        $stmt = $pdo->prepare('INSERT INTO jogador (nome, golos, assistencias, cartoes_amarelos, cartoes_vermelhos) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nome, $golos, $assistencias, $cartoes_amarelos, $cartoes_vermelhos]);

        header("Location: create_ok.php");
        exit;

        // Output message
        $msg = 'Criado com sucesso!';
    } else {
        $msg = 'Tem de ter dados para inserir!..';
    }
}
?>

<?=template_header('Inserir : Jogador', $project_path)?>

<div class="content update">
	<h2>Inserir : Jogador</h2>
    <form action="?op=save" method="post">

    <label for="nome">Nome do jogador</label>
    <input maxlength="100" type="text" required name="nome" placeholder="Escreva o nome do jogador" id="nome">

    <label for="golos">Golos marcados</label>
    <input type="number" required name="golos" placeholder="Escreva o número de golos marcados pelo jogador" id="golos">

    <label for="assistencias">Assistências</label>
    <input type="number" required name="assistencias" placeholder="Escreva o número de assistências do jogador" id="assistencias">

    <label for="cartoes_amarelos">Cartões amarelos</label>
    <input type="number" required name="cartoes_amarelos" placeholder="Escreva o número de cartões amarelos dados ao jogador" id="cartoes_amarelos">

    <label for="cartoes_vermelhos">Cartões vermelhos</label>
    <input type="number" required name="cartoes_vermelhos" placeholder="Escreva o número de cartões vermelhos dados ao jogador" id="cartoes_vermelhos">
    
    <input type="submit" value="Inserir">

</form>

    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>