<div class="container">
	<a class="btn btn-success" href="/workers" role="button">Назад</a>
	<a class="btn btn-primary" href="/" role="button">Главная</a>
	<a class="btn btn-danger" href="/app/RequestHandler.php?action=delete_worker&id=<?=$worker['id']?>" role="button">Удалить</a>
	<br><br><br>

	<h2 align="center">Редактирование сотрудника: <?=$worker['last_name']." ".$worker['first_name']?></h2><br><br>
	<br>


	<form action="/app/RequestHandler.php?action=update_worker" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$worker['id']?>">
		<div class="form-row">
		    <div class="form-group col-md-4">
		      	<label for="inputFirstName">Имя</label>
		      	<input type="text" class="form-control" id="inputFirstName" name="first_name" value="<?=$worker['first_name']?>" required>
		    </div>
		    <div class="form-group col-md-4">
		      	<label for="inputLastName">Фамилия</label>
		      	<input type="text" class="form-control" id="inputLastName" name="last_name" value="<?=$worker['last_name']?>" required>
		    </div>
		    <div class="form-group col-md-4">
		      	<label for="inputFatherName">Отчество</label>
		      	<input type="text" class="form-control" id="inputFatherName" name="father_name" value="<?=$worker['father_name']?>" required>
		    </div>
	 	</div>

		<div class="form-row">
			<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Должность</label>
			<select class="form-control" id="exampleFormControlSelect1" name="post">
			    <? foreach($posts as $post): ?>
			    	<option value="<?=$post['post']?>" <? if($worker['post'] == $post['post']) echo "selected"; ?>><?=$post['post']?></option>
			    <? endforeach; ?>
			</select>
		</div><br>

	    <div class="form-row">
	        <label for="employment_start">Дата приема</label>
	        <input type="date" id="employment_start" name="employment_start" class="form-control"
	            value="<?=$worker['employment_start']?>"
	            min="1990-01-01" max="2018-12-31" />
	    </div><br>

		<div class="form-row">
	      	<label for="inputSalary">Зарплата</label>
	      	<input type="text" class="form-control" id="inputSalary" name="salary" value="<?=$worker['salary']?>" placeholder="Зарплата" required>
	    </div><br>

	    <div class="form-row">
	      	<label for="inputChief_id">Id начальника</label>
	      	<input type="text" class="form-control" id="inputChief_id" name="chief_id" value="<?=$worker['chief_id']?>" placeholder="Id начальника">
	    </div><br>

		<div class="form-group">
		    <label for="avatar">Фото сотрудника</label>
		    <?php if($worker['avatar'] != ""): ?>
				<br><img src="/img/<?=$worker['avatar']?>" alt="" style="width:250px; height:250px;"><br><br>
		    <?php endif; ?>
		    <input type="file" class="form-control-file" id="avatar" name="avatar">
		</div>

	  	<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>
	<br>

</div>