<?php
	define("LOAD_TYPE", "basic");
	session_start();
	// Include all files
	include 'autoload.php';
	
	$filler = new FillWorkers();

	$filler->run([
		'Директор отдела' => ['count' => 8, 'salary' => 10000], 
		'Тимлид' => ['count' => 300, 'salary' => 7000], 
		'Senior' => ['count' => 2500, 'salary' => 5000], 
		'Middle' => ['count' => 26000, 'salary' => 2000], 
		'Junior' => ['count' => 43000, 'salary' => 1000]
	]);

	// Uncomment when you need to rebuild hierarchy
	// $filler->truncateWorkersTable(); 

	$app = new Application($config, 'basic'); // Start application using configuration
?>