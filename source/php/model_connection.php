<?php 

	class connectDB
	{
		var $host,$user,$pass,$dbName,$con;

		function __construct($host,$user,$pass,$dbName)
		{
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbName = $dbName;
		}

		function connect()
		{
			$this->con = mysqli_connect($this->host,$this->user,$this->pass);

			// Check connection
			if (mysqli_connect_errno())
			{
				printf("Connect failed: %s", mysqli_connect_error());
    			exit();
			}

			$this->selectDB();
		}

		private function selectDB()
		{
			mysqli_query($this->con,"SET NAMES UTF8");			// if remove inline you can't insert utf8
			mysqli_select_db($this->con,$this->dbName);
		}

		function disConnect()
		{
			mysqli_close($this->con);
		}

	}

?>