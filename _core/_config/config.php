<?php 

$config['appname'] 		            =  'Your Gear APP';
$config['template'] 		        =  'main';

$config['cryptokey']  		        =  '21889CEAC0EA6F09F849D05ABD525B047199E06C9CA02AD9F57010AB22A2BA23';
$config['visual_debug']  	        =  false;

//benchmark config
$config['benchmark']  				=  true;
$config['benchmarkMethod']  		=  'silent';  //echo, alert, silent

//authorization & authentication config
$config['authorization']  			=  true;
$config['authorizationHandle']  	=  'exception'; //redirect, exception


//exceptions config
$config['exceptionNotify'] 			=  true;
$config['exceptionNotifyMethod']  	=  'alert';  //echo, alert, silent, trace


//database config
$databaseConfig['broker'] 	        =  'MYSQL';
$databaseConfig['host'] 	        =  'localhost';
$databaseConfig['port']		        =  '3306';
$databaseConfig['username']	        =  'root';
$databaseConfig['password']	        =  'root';
$databaseConfig['database']	        =  'anglo';
