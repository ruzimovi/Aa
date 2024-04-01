<?php

define("DB_SERVER", "localhost"); 
define("DB_USERNAME", "newtv"); 
define("DB_PASSWORD", "newtv"); 
define("DB_NAME", "newtv"); 

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connect, "utf8mb4");
if($connect){
    echo "Ulandi.";
}else{
	echo "Ulanmadi.";
}

mysqli_query($connect," create table user_id(
`id` int(20) auto_increment primary key,
`user_id` varchar(100),
`step` varchar(200),
`sana` varchar(100)
)");

mysqli_query($connect," create table data(
`id` int(20) auto_increment primary key,
`code` varchar(100),
`file_name` varchar(200),
`file_id` varchar(200)
)");


?>