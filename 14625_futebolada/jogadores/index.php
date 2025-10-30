<?php
include '../inc/config.php';
include '../inc/functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our 'tabela' table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM jogador ORDER BY nome LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$lista_jogadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_registos = $pdo->query('SELECT COUNT(*) FROM jogador')->fetchColumn();
$page_begin = ($page - 1) * $records_per_page + 1;
$page_end = $page * $records_per_page;
if ($page_end > $num_registos) $page_end = $num_registos;
?>

<?=template_header('Lista : Jogadores', $project_path)?>

<div class="content read">
	<h2>Lista : Jogadores</h2>
	<a href="create.php" class="create-contact">Contratar Jogador</a>
    <p> 
        A mostrar <?php echo ($page_begin) . " a " . $page_end; ?>
        num total de <?php echo $num_registos; ?> registos
    </p>

	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nome do jogador</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_jogadores as $item): ?>
            <tr>
                <td><?=$item['numero']?></td>
                <td><?=$item['nome']?></td>
                <td class="actions">
                    <a href="tabela_update.php?id=<?=$item['numero']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="tabela_delete.php?id=<?=$item['numero']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_registos): ?>
		<a href="?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>