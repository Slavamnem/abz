<?php
session_start();
if($_SESSION['login-status'] == "fail"){ ?>
	<div class="container">
		<div class="alert alert-danger" role="alert">
		    <h4 class="alert-heading">Ошибка!</h4>
		    <p>Неверно введенный логин или пароль</p>
		</div>
	</div>
<? } ?>