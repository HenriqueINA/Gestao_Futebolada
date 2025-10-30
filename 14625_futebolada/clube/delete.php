<?php
include '../inc/config.php';
include '../inc/functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM clube WHERE idclube = ?');
    $stmt->execute([$_GET['id']]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$item) {
        exit('Não existe nenhum registo com esse ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM clube WHERE idclube = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Registo eliminado com sucesso!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Eliminar : Clube', $project_path)?>

<div class="content delete">
	<h2>Apagar Jogador #<?=$item['idclube']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
        <div class="yesno">
        <a href="read.php?">Voltar à Lista</a>
    <?php else: ?>
	<p>Tem a certeza que quer apagar o Clube #<?=$item['idclube']?>?</p>
    <div class="yesno">
        <a href="tabela_delete.php?id=<?=$item['idclube']?>&confirm=yes">Sim</a>
        <a href="tabela_delete.php?id=<?=$item['idclube']?>&confirm=no">Não</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>