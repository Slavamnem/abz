<?php
// Widget displaing a block of one worker in two variations, for the main page and for internal
class WorkerWidget{
	public static function get(array $params){
		extract($params);
		if($type and $worker){
			if($type == "worker"): ?>
				<a href="/workers/view/<?=$worker['id']?>" class="list-group-item list-group-item-action flex-column align-items-start ">
					<div class="row">
						<div class="col-md-2">
							<img src="/img/<?=$worker['avatar']?>" alt="" style="width:120px; height:120px;">
						</div>
						<div class="col-md-10">
							<div class="d-flex w-100 justify-content-between">
							    <h4 class="mb-1"><?=$worker['last_name']." ".$worker['first_name']." ".$worker['father_name'];?></h4>
							</div>
							<p class="mb-1"><?="Должность: ".$worker['post']."<br>"."Дата приема на работу: ".$worker['employment_start']."<br>"."Зарплата: ".$worker['salary']."<br>"."Начальник: ".$chief;?></p>
						</div>
					</div>
				</a>
			<? endif;
			if($type == "index"): ?>
				<li class="list-group-item">
					<div class="card">
						<div class="card-header">
							<a href="/workers/view/<?=$worker['id']?>">
								<h5><?=$worker['last_name']." ".$worker['first_name']." ".$worker['father_name'];?></h5>
							</a>
						</div>
						<div class="card-body">
							<p class="card-text">
							    Должность: <?=$worker['post']?>
								<button type="button" class="btn btn-light dropdown-toggle show_subordinates" data-id="<?=$worker['id']?>"></button>
							</p>	
						</div>
					</div>
					<div class="subordinates-<?=$worker['id']?>"></div>
				</li>
			<? endif;
		}
	}
}
?>