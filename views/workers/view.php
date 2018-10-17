<? include "/library/WorkerWidget.php"; ?>
<div class="container">

	<h2 align="center">Просмотр сотрудника: <?=$worker['last_name']." ".$worker['first_name']?></h2><br><br>

	<a class="btn btn-success" href="/workers" role="button">Назад</a>
	<a class="btn btn-primary" href="/workers/update/<?=$worker['id']?>" role="button">Редактировать</a>
	<a class="btn btn-danger" href="/app/RequestHandler.php?action=delete_worker&id=<?=$worker['id']?>" role="button">Удалить</a><br><br>	
	<?=WorkerWidget::get(['type' => 'worker', 'worker' => $worker, 'chief' => $this->getChiefById($worker['chief_id'])]);?>

</div>