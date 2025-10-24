<?php
include '../inc/config.php';
include '../inc/functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'ok') {
            $msg = 'Registo atualizado com sucesso.';
        }
    }

    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $nome = isset($_POST['cor']) ? $_POST['cor'] : '';
        $nome = isset($_POST['hino']) ? $_POST['hino'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE clube SET nome = ?, cor = ?, hino = ? WHERE idclube = ?, ?, ?');
        $stmt->execute([$nome, $_GET['id']]);
        $msg = 'Registo atualizado com sucesso!';

        // redirect para que não haja 'reenvio' de atualização dos dados submetidos pelo formulário
        header("Location: update.php?id=" . $_GET['id'] . "&status=ok");
        exit;
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM clube WHERE idclube = ?');
    $stmt->execute([$_GET['id']]);
    $item_clube = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$item_clube) {
        exit('Não encontro nenhum registo com esse ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Clube : Editar/Ver', $project_path)?>

<div class="content update">
	<h2>Atualizar Clube #<?=$item_clube['idclube']?></h2>
    <form action="update.php?id=<?=$item_clube['idclube']?>" method="post">
        <label for="id">ID</label>
        <label for="nome">Nome do clube</label>
        <input type="text" name="id" placeholder="1" value="<?=$item_clube['idclube']?>" id="id">
        <input maxlength=100 type="text" name="nome" placeholder="Nome do Clube" value="<?=$item_clube['nome']?>" id="nome">
        <input maxlength=50 type="color" name="color" placeholder="Cor do Clube" value="<?=$item_clube['cor']?>" id="cor">

        <input type="submit" value="Atualizar">
        <button type="button" class="danger" onclick ="javascript:location.href='read.php'">Cancelar</button>
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>