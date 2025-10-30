<?php
include '../inc/config.php';
include '../inc/functions.php';
$pdo = pdo_connect_mysql();
$msg = 'Criado com sucesso!';

?>

<?=template_header('Tabelas : Inserir', $project_path)?>

<div class="content update">
	<h2>Tabelas : Inserir</h2>
    
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    
    <button type="button" class="back" onclick ="javascript:location.href='tabela_read.php'">Voltar à tabela</button>
</div>

<?=template_footer()?>