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
    if ($nome != '') {
        // Insert new record into the 'tabela' table
        $stmt = $pdo->prepare('INSERT INTO tabela (nome) VALUES (?)');
        $stmt->execute([$nome]);

        header("Location: tabela_create_ok.php");
        exit;

        // Output message
        $msg = 'Criado com sucesso!';
    } else {
        $msg = 'Tem de ter dados para inserir!..';
    }
}
?>

<?=template_header('Tabelas : Inserir', $project_path)?>

<div class="content update">
	<h2>Tabelas : Inserir</h2>
    <form action="tabela_create.php" method="post">

        <label for="nome">Nome da Tabela</label>
        <label for="created">Criado</label>
        <input type="text" required name="nome" placeholder="Escreva o nome da tabela" id="nome">
        <input type="text" disabled value="<?=date('Y-m-d\TH:i')?>">

        <input type="submit" value="Inserir">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>