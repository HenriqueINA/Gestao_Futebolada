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
$stmt = $pdo->prepare('SELECT * FROM clube ORDER BY nome LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$lista_registos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_registos = $pdo->query('SELECT COUNT(*) FROM clube')->fetchColumn();
$page_begin = ($page - 1) * $records_per_page + 1;
$page_end = $page * $records_per_page;
if ($page_end > $num_registos) $page_end = $num_registos;
?>

<?=template_header('Lista : Clubes', $project_path)?>

<div class="content read">
	<h2>Lista : Clubes</h2>
	<a href="create.php" class="create-contact">Criar Clube</a>
    <p> 
        A mostrar <?php echo ($page_begin) . " a " . $page_end; ?>
        num total de <?php echo $num_registos; ?> registos
    </p>

	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nome do clube</td>
                <td>Cor</td>
                <td>Hino</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_registos as $item): ?>
            <tr>
                <td><?=$item['idclube']?></td>
                <td><?=$item['nome']?></td>
                <td style="background: <?=$item['cor']?>;"></td>
                <td style="background: <?=$item['hino']?>;"></td>
                
                <td class="actions">
                    <a href="update.php?id=<?=$item['idclube']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$item['idclube']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
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