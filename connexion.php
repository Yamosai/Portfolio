<?php
	//fonction connection
	function connect()
	{
		require('config.php');
	
		try
		{
			$co = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName,$dbUser,$dbUserPasseword);
			$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		return $co;
	}	
		

			//fonction de deconnection 
			function disconnect()
		{
			$co = null;
		}
?>