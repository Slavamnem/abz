<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="<?=$language?>">
	<head>
		<title>TestTask</title>
		<meta charset="<?=$charset?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	<body>
	
		
		<nav class="navbar navbar-expand-lg navbar-light bg-primary">
			<a class="navbar-brand" href="#"><?=$app_name?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			</button>

		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    	<div class="row">
		    		<div class="col-md-12">
				    	<ul class="navbar-nav mr-auto">
					        <li class="nav-item active">
					            <a class="nav-link" href="/index">Главная <span class="sr-only"></span></a>
					        </li>
				      
							<? if(!isset($_SESSION['user'])){ ?>
						        <li class="nav-item active">
						        	<a class="nav-link" href="#" data-toggle="modal" data-target="#enterModal">Вход <span class="sr-only">(current)</span></a>
						        </li>
						        <li class="nav-item active">
						        	<a class="nav-link" href="#" data-toggle="modal" data-target="#registrationModal">Регистрация <span class="sr-only">(current)</span></a>
						        </li>
					  		<? } ?>
					  		<? if(isset($_SESSION['user'])){ ?>
					  			<li class="nav-item active">
							        <a class="nav-link" href="/workers">Сотрудники <span class="sr-only"></span></a>
							    </li>
					  			<li class="nav-item active">
						        	<a class="nav-link" href="/app/RequestHandler.php?action=logout">Выход <span class="sr-only"></span></a>
						        </li>
					 	 	<? } ?>
				    	</ul>
			    	</div>
			    </div>
			</div>
		</nav>
		<br><br>
		

		<div class="page_content">
			<?=$page_content;?>
		</div>

	</body>
	<script src="/js/jquery-3.0.0.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/main.js"></script>
</html>


<div class="modal fade" id="enterModal" tabindex="-1" role="dialog" aria-labelledby="enterModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="loadingModalLabel" align="center">Вход</h3>
      </div>
      <div class="modal-body">
        <form method="POST" action="/app/RequestHandler.php?action=login">
          <div class="form-group">
            <label for="login" class="col-form-label">Логин:</label>
            <input type="text" class="form-control" name="login" required="">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Пароль:</label>
            <input type="text" class="form-control" name="password">
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Войти</button>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="loadingModalLabel" align="center">Регистрация</h3>
      </div>
      <div class="modal-body">
        <form method="POST" action="/app/RequestHandler.php?action=registration" id="sign-up" >
          <div class="form-group">
            <label for="login" class="col-form-label">Логин:</label><span class="dot">*</span>
            <input type="text" class="form-control login" id="login" name="login" required="">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Пароль:</label>
            <input type="text" class="form-control password" id="password" name="password" required="">
          </div>

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Завершить регистрацию</button>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<script>
	
	$('#sign-up').on('submit', function(event) {

	    $(".text-error").remove();	 

	    // Проверка пароля    
	    var el_p = $("#password");
	    if ( el_p.val().length < 6 ) {
	      var v_password = true;
	      el_p.after('<span class="text-error for-password">Пароль должен быть больше 6 символов</span>');
	      $(".for-password").css({top: el_p.position().top + el_p.outerHeight() + 2});
	    } 
	    $("#password").toggleClass('error', v_password );

	    // Проверка логина
	    var el_l = $("#login");
	    if ( el_l.val().length < 6 ) {
	      var v_login = true;
	      el_l.after('<span class="text-error for-login">Логин должен быть больше 6 символов</span>');
	      $(".for-login").css({top: el_l.position().top + el_l.outerHeight() + 2});
	    } 
	    else{
	    	$.ajax({
			    url: '../app/RequestHandler.php?action=checkLogin',
			    data: {login: el_l.val()},
			    type: 'POST',
			    async: false,
			    success: function(res){
			    	if(res == 0){ 
			    		el_l.after('<span class="text-error for-login">Логин уже занят</span>');
		    			$(".for-login").css({top: el_l.position().top + el_l.outerHeight() + 2});
			        	$("#login").toggleClass('error', v_login ); 
			        	event.preventDefault();
			        }  
			    },
			    error: function(){
			        event.preventDefault();
			    }
	    	});
	    }
	    if(v_login || v_password){ event.preventDefault(); }
	});

</script>