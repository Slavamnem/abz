<? include "/library/WorkerWidget.php"; ?>
<div class="container workers_container">
		
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Sort/Search</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			</button>

		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    	<div class="row">
		    		<div class="col-md-3">
		    			<select class="form-control sort_workers_select" id="exampleFormControlSelect1">
						    <option value="id-ASC">Id (по возрастанию)</option>
						    <option value="id-DESC">Id (по убыванию)</option>
						    <option value="first_name-ASC">Имя (по возрастанию)</option>
						    <option value="first_name-DESC">Имя (по убыванию)</option>
						    <option value="last_name-ASC">Фамилия (по возрастанию)</option>
						    <option value="last_name-DESC">Фамилия (по убыванию)</option>
						    <option value="father_name-ASC">Отчество (по возрастанию)</option>
						    <option value="father_name-DESC">Отчество (по убыванию)</option>
						    <option value="post-DESC">Должность (по возрастанию)</option>
						    <option value="post-ASC">Должность (по убыванию)</option>
						    <option value="employment_start-ASC">Дата приема (по возрастанию)</option>
						    <option value="employment_start-DESC">Дата приема (по убыванию)</option>
						    <option value="salary-ASC">Зарплата (по возрастанию)</option>
						    <option value="salary-DESC">Зарплата (по убыванию)</option>
						    <option value="chief_id-ASC">Id начальника (по возрастанию)</option>
						    <option value="chief_id-DESC">Id начальника (по убыванию)</option>
						</select>
					</div>
				    <div class="col-md-3">
						<button class="btn btn-success sort_workers_list">Сортировать</button>
					</div>

					<div class="col-md-2 ">
						<select class="form-control search_workers_select" id="exampleFormControlSelect1">
							<option value="id">Id</option>
					        <option value="first_name">Имя</option>
					        <option value="last_name">Фамилия</option>
					        <option value="father_name">Отчество</option>
					        <option value="post">Должность</option>
					        <option value="employment_start">Дата приема</option>
					        <option value="salary">Зарплата</option>
					        <option value="chief_id">Id начальника</option>
						</select>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control search_input" placeholder="Поиск">
					</div>
					<div class="col-md-1">
						<button class="btn btn-success search_workers">Поиск</button>
					</div>
			    </div>
			</div>
		</nav>

    <hr>

	<div class="search-field"></div>
	<a class="btn btn-success" href="/workers/create" target="blank" role="button">Добавить сотрудника</a><br><br>
	<div class="list-group all_workers">
		<? foreach ($workers as $id => $worker): ?>
			<?=WorkerWidget::get(['type' => 'worker', 'worker' => $worker, 'chief' => $this->getChiefById($worker['chief_id'])]);?>
		<? endforeach; ?>	
	</div>

	<? session_start();
	$total_count = $this->getWorkersCount(); ?>
	<? if($_SESSION['workers_page']['displayed_workers'] < $total_count): ?>
		<button type="button" class="btn btn-success show_more">Показать еще</button><br><br>
	<? endif; ?>	
	
</div>