<?php 

	class userQuery
	{
		var $host,$user,$pass,$con,$dbName,$code;

		function __construct($host,$user,$pass,$code)
		{
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbName = "ex_".$user;
			$this->code = $code;
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
		}

		function disConnect()
		{
			mysqli_close($this->con);
		}

		function selectDB()
		{
			mysqli_query($this->con,"SET NAMES UTF8");			// if remove inline you can't insert utf8
			mysqli_select_db($this->con,$this->dbName);
		}

		function mysqlQuery()
		{
			if ($result = mysqli_query($this->con,$this->code)) 
			{
				if(!($this->checkWordlist($this->code)))			//if worldlist then don't print tables
				{
					echo "<br>";
					echo "<div class='table-responsive'>";
					echo "<table class='table table-hover'>";
					echo "<thead>";
					echo "<tr class='active'>";
					while($finfo = mysqli_fetch_field($result))			//fetch field_info
					{
						echo "<th>";
						echo $finfo->name;						//get filed name from field_info
						echo "</th>";
					}
					echo "</tr>";
					echo "</thead>";
					while($row = mysqli_fetch_array($result,MYSQLI_NUM)) 
					{
						echo "<tr>";
						foreach ($row as $r => $value) {
							echo "<td>".$value."</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
					echo "<div>";
				}
			}
			else
			{
				printf("Error: %s", mysqli_error($this->con));
			}	
		}

		function organizeCode($code)
		{
			$strlower = strtolower($code); 											//string to lower case
			$strtrim = trim(preg_replace('/\s\s+[\r\n]+/', ' ', $strlower));		//replace line breaks to space and trim front/rear space of string
			$strexplode = explode(" ", $strtrim);
			return $strexplode;														//return array of $this->code on organized
		}

		function checkWordlist($code)
		{
			$WORDLIST = array("use","insert","update","delete","create","drop","alter");
			
			$word = $this->organizeCode($code);

			//print_r($word);
			if($word[0] == $WORDLIST[0])
			{
				$word[1] = str_replace(';', '', $word[1]);
				echo "Success: Use ".$word[1]." successful.";						//if $word[0] == use then 1 is index of database name
				return ture;
			}
			else if($word[0] == $WORDLIST[1])
			{
				$tablename=$word[2];														//if $word[0] == insert then 2 is index of table name
				echo "Success: Insert into ".$tablename." successful.";
				return ture;
			}
			else if($word[0] == $WORDLIST[2])
			{
				$tablename=$word[1];
				echo "Success: Update ".$tablename." successful.";
				return ture;
			}
			else if($word[0] == $WORDLIST[3])
			{
				$tablename=$word[2];
				echo "Success: Delete row from ".$tablename." successful.";
				return ture;
			}
			else if($word[0] == $WORDLIST[4])
			{
				$mode = $word[1];
				$name=$word[2];
				if($mode == "database")
				{
					echo "Success: Create database ".$name." successful."."<br>"."You can query <kbd>SHOW DATABASES;</kbd> for checking database.";
				}
				else if($mode == "table")
				{
					echo "Success: Create table ".$name." successful."."<br>"."You can query <kbd>SHOW TABLES;</kbd> for checking table.";
				}
				else if($mode == "index")
				{
					echo "Success: Create index ".$name." successful."."<br>"."You can query <kbd>SHOW INDEX FROM [table-name];</kbd> for checking index.";
				}
				else if($mode == "view")
				{
					echo "Success: Create view ".$name." successful."."<br>"."You can query <kbd>SHOW TABLES;</kbd> for checking view.";
				}
				return ture;
			}
			else if($word[0] == $WORDLIST[5])
			{
				$mode = $word[1];
				$name=$word[2];
				echo "Success: Drop ".$mode." ".$name." successful.";
				return ture;
			}
			else if($word[0] == $WORDLIST[6])
			{
				$tablename=$word[2];
				echo "Success: Alter table to ".$tablename." successful.";
				return ture;
			}
			else
			{
				return false;
			}
		}
	}
 ?>