<?php

$connection = mysqli_connect(
    $config['db']['server'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['name']
);

if ($connection == false) {
	echo 'Не удалось<br>';
	echo mysql_connect_error();
	exit();
}










