<?php 

	class userDB
	{
		var $con,$dbName,$studentID,$mainDB;

		function __construct($con,$studentID,$mainDB)
		{
			$this->con = $con;
			$this->studentID = $studentID;
			$this->dbName = "ex_".$studentID;
			$this->mainDB = $mainDB;
		}

		function selectDB()
		{
			$this->mysqlQuery("SET NAMES UTF8");			// if remove inline you can't insert utf8
			mysqli_select_db($this->con,$this->dbName);
		}

		function mysqlQuery($query)
		{
			mysqli_query($this->con,$query);
		}

		function dropDB()
		{
			$drop = "DROP DATABASE ".$this->dbName;
			$this->mysqlQuery($drop);
		}

		//Create CreateUserDB Function
		function createUserDB()
		{
			$pwn = "pwn_".$this->studentID;					//create user password
			$db1 = $this->dbName;							//for insert update delete select
			$db2 = $this->dbName."_test";					//for create delete

			$createDB ="CREATE DATABASE ".$db1." CHARACTER SET utf8 COLLATE utf8_unicode_ci";
			$createUser ="CREATE USER '".$this->studentID."'@'localhost' IDENTIFIED BY '".$pwn."';";
			$setPermission1 ="GRANT USAGE ON *.* TO '".$this->studentID."'@'localhost' IDENTIFIED BY '".$pwn."' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
			$setPermission2 = "GRANT ALL PRIVILEGES ON `".$db1."`.* TO '".$this->studentID."'@'localhost';";
			$setPermission3 = "GRANT ALL PRIVILEGES ON `".$db2."`.* TO '".$this->studentID."'@'localhost';";
			//run createUserDB function
			$this->mysqlQuery($createDB);
			$this->mysqlQuery($createUser);
			$this->mysqlQuery($setPermission1);
			$this->mysqlQuery($setPermission2);
			$this->mysqlQuery($setPermission3);
		}
		//Create Table Function
		function createTables()
		{
			$this->selectDB();

			// Create Suppliers Table
			$SuppliersTable = "CREATE TABLE Suppliers
			(
    			SupID char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
    			SupName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
   				SupAddress varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			City varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			Region varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			PostalCode varchar(5),
    			Phone varchar(10)
				);";
			$this->mysqlQuery($SuppliersTable);

			// Create Sales Table
			$SalesTable = "CREATE TABLE Sales 
			(
			 SalesID char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
			 SFirstName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 SLastName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 Position varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 BirthDate date,
			 HireDate date,
			 SAddress varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			 City varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 PostalCode varchar(5),
			 Phone varchar(10),
			 Comm real,
			 TargetSales real,
			 Manager char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			 FOREIGN KEY(Manager) REFERENCES Sales(SalesID)
			 );";
			$this->mysqlQuery($SalesTable);

			// Create Customers Table
			$CusTable = "CREATE TABLE Customers 
			(
			 CustomerID char(5)CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
			 CFirstName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 CLastName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 CAddress varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
			 City varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			 Region varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			 PostalCode varchar(5),
			 Phone varchar(10), 
			 PaymentPeriod integer
			 );";
			$this->mysqlQuery($CusTable);

			//Create Orders Table
			$OrdersTable = "CREATE TABLE Orders
			(
    			OrderID char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
    			CustomerID char(5)CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			SalesID char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			OrderDate date,
    			SentDate date,
    			FOREIGN KEY (CustomerID) REFERENCES Customers (CustomerID),
    			FOREIGN KEY (SalesID) REFERENCES Sales (SalesID)
				);";
			$this->mysqlQuery($OrdersTable);

			// Create Categories Table
			$CategoriesTable = "CREATE TABLE Categories 
			(
			 CategoryID char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
			 CategoryName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci
			 );";
			$this->mysqlQuery($CategoriesTable);

			//Create Products Table
			$ProductsTable = "CREATE TABLE Products
			(
    			ProductID char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
    			ProductName varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			CategoryID char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			Price real,
    			InStock integer,
    			ReOrderPoint integer,
    			DiscountLimit real,
    			SupID char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    			FOREIGN KEY (CategoryID) REFERENCES Categories (CategoryID),
    			FOREIGN KEY (SupID) REFERENCES Suppliers (SupID)
				);";
			$this->mysqlQuery($ProductsTable);

			//Create OrderDetails Table
			$OrderDetailsTable = "CREATE TABLE OrderDetails
			(
    			OrderID char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    			ProductID char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    			Quantity integer,
    			Discount real,
    			PRIMARY KEY (OrderID,ProductID),
    			FOREIGN KEY (OrderID) REFERENCES Orders (OrderID),
    			FOREIGN KEY (ProductID) REFERENCES Products (ProductID)
				);";
			$this->mysqlQuery($OrderDetailsTable);


		}

		//Insert Data to Tables
		function insertTables()
		{
			$this->selectDB();

			//Insert Customers Table
			$InCustomersTable = "INSERT INTO Customers (CustomerID,CFirstName,CLastName,CAddress,City,Region,PostalCode,Phone,PaymentPeriod) 
			VALUES  ('C0001','พิรพร','หมุนสนิท','11 ถ.สุขุมวิท คลองตัน','กรุงเทพฯ','กลาง','10110','029522212','30'),
					('C0002','นวรัตน์','ธนะรุ่งรักษ์','36 ถ.ลาดพร้าว วังทองหลาง','กรุงเทพฯ','กลาง','10310','029550550','30'),
					('C0003','สุธี','พงศาสกุลชัย','25 ถ.สุขสวัสดิ์ พระประแดง','สมุทรปราการ','กลาง','11000','028770000','15'),
					('C0004','สุรเชษฐ์','วงศ์ชัยพรพงศ์','71 ถ.วิทยุ ปทุมวัน','กรุงเทพฯ','กลาง','10330','028771255','15'),
					('C0005','ปิ่นอนงค์','ศรีงาม','12 ถ.สุขุมวิท คลองตัน','กรุงเทพฯ','กลาง','10110','028771255','15'),
					('C0006','ประเวศน์','วงษ์คำชัย','52 ถ.สุขสวัสดิ์ อ.พระประแดง','สมุทรปราการ','กลาง','11000','023700007','30'),
					('C0007','วันวิสาข์','เมฆสาย','63 ถ.เจริญทัศนา อ.เมือง','เชียงใหม่','เหนือ','53000','053119000','0'),
					('C0008','หทัยชนก','งามอินทร์','87 ถ.สนามบิน อ.เมือง','ขอนแก่น','ตะวันออกเฉียงเหนือ','43000','043700028','0'),
					('C0009','วันวิสาข์','วิชา','140 ถ.พายัพ อ.เมือง','นครราชสีมา','ตะวันออกเฉียงเหนือ','30000','044211500','0'),
					('C0010','ดนภัทร','ยงประพัฒน์','63 ถ.รามคำแหง หัวหมาก','กรุงเทพฯ','กลาง','10300','025381111','0')
					;";
			$this->mysqlQuery($InCustomersTable);

			//Insert Sales Table
			$InSalesTable = "INSERT INTO Sales (SalesID,SFirstName,SLastName,Position,BirthDate,HireDate,SAddress,City,PostalCode,Phone,Comm,TargetSales,Manager) 
			VALUES  ('S01','เบญจา','สังค์ทอง','หัวหน้า','25141201','25450215','23 ถ.วิทยุ ปทุมวัน','กรุงเทพฯ','10330','018554545','0.17','200,000.00',NULL),
					('S02','ภัทริน','บุญเจริญ','หัวหน้า','25150720','25450801','22 ถ.เพชรเกษม บางแค','กรุงเทพฯ','10160','098852323','0.15','200,000.00',NULL),
					('S03','จิรภัทร','ไตรสุวรรณ','พนักงานขาย','25191209','25470820','87 ถ.สุขสวัสดิ์ พระประแดง','สมุทรปราการ','11000','041590000','0.11','50,000.00','S01'),
					('S04','พรทิพย์','งามดี','พนักงานขาย','25200101','25470201','66 ถ.สุขสวัสดิ์ พระประแดง','สมุทรปราการ','11000','057100001','0.1','50,000.00','S02'),
					('S05','ดวงใจ','โอภาส','พนักงานขาย','25240524','25480114','11 ถ.สุขุมวิท คลองตัน','กรุงเทพฯ','10110','019009000','0.1','50,000.00','S01'),
					('S06','มนตรี','ธนะรัตน์','พนักงานขาย','25241011','25490115',NULL,NULL,NULL,'092330000','0.1',NULL,'S01')
					;";
			$this->mysqlQuery($InSalesTable);

			//Insert Orders Table
			$InOrdersTable = "INSERT INTO Orders (OrderID,CustomerID,SalesID,OrderDate,SentDate) 
			VALUES  ('D00001','C0001','S01','25491006','25491009'),
					('D00002','C0002','S02','25491019','25491021'),
					('D00003','C0003','S03','25491019','25491022'),
					('D00004','C0004','S01','25491020','25491023'),
					('D00005','C0005','S01','25491020','25491023'),
					('D00006','C0006','S06','25491021','25491024'),
					('D00007','C0007','S04','25491021','25491024'),
					('D00008','C0001','S01','25491021','25491024'),
					('D00009','C0008','S05','25491021','25491023'),
					('D00010','C0009','S02','25491022','25491024'),
					('D00011','C0010','S04','25491022','25491025'),
					('D00012','C0006','S06','25491022','25491025'),
					('D00013','C0003','S03','25491025','25491025'),
					('D00014','C0004','S01','25491101','25491103'),
					('D00015','C0002','S02','25491102',NULL),
					('D00016','C0003','S03','25491103',NULL);";
			$this->mysqlQuery($InOrdersTable);


			//Insert Categories Table
			$InCategoriesTable = "INSERT INTO Categories (CategoryID,CategoryName) 
			VALUES  ('11','เฟอร์นิเจอร์ห้องนอน'),
					('12','เฟอร์นิเจอร์ห้องนั่งเล่น'),
					('13','เฟอร์นิเจอร์ห้องครัว'),
					('14','เฟอร์นิเจอร์สำหรับเด็ก'),
					('15','เครื่องใช้ไฟฟ้า');";
			$this->mysqlQuery($InCategoriesTable);


			//Insert Suppliers Table
			$InSuppliersTable = "INSERT INTO Suppliers (SupID,SupName,SupAddress,City,Region,PostalCode,Phone) 
			VALUES  ('01','บ.อุดมกิจ จำกัด','15 ถ.สุขสวัสดิ์ พระประแดง','สมุทรปราการ','กลาง','11000','028880000'),
					('02','บ.ล้านนา จำกัด','31 ถ.โชตนา อ.เมือง','เชียงใหม่','เหนือ','53000','053219111'),
					('03','บ.โชคชัย จัดกัด','11 ถ.ชัยณรงค์ อ.เมือง','นครราชสีมา','ตะวันออกเฉียงเหนือ','30000','044125550'),
					('04','บ. ทวีโชค จำกัด','12 ถ.สุขุมวิท คลองตัน','กรุงเทพฯ','กลาง','10110','021553220')
					;";
			$this->mysqlQuery($InSuppliersTable);


			//Insert Products Table
			$InProductsTable = "INSERT INTO Products (ProductID,ProductName,CategoryID,Price,InStock,ReOrderPoint,DiscountLimit,SupID) 
			VALUES  ('P01','ที่นอน','11','9,900.00','5','3','0.15','01'),
					('P02','ตู้เสื้อผ้า','11','5,480.00','0','2','0.10','01'),
					('P03','โต๊ะเครื่องแป้ง','11','4,580.00','8','1','0.10','01'),
					('P04','โซฟา','12','8,800.00','3','2','0.10','02'),
					('P05','โต๊ะกลาง','12','3,900.00','0','3','0.10','02'),
					('P06','ชุดครัว','13','16,000.00','1','1','0.15','03'),
					('P07','เตียงสองชั้น','14','8,900.00','2','1','0.10','01'),
					('P08','เครื่องปรับอากาศ','15','12,500.00','10','5','0.15','04');";
			$this->mysqlQuery($InProductsTable);

			//Insert OrderDetails Table
			$InOrderDetailsTable = "INSERT INTO OrderDetails (OrderID,ProductID,Quantity,Discount) 
			VALUES  ('D00001','P01','1','0'),
					('D00001','P02','1','0'),
					('D00002','P08','3','0.15'),
					('D00003','P04','2','0.10'),
					('D00003','P05','1','0.10'),
					('D00004','P07','1','0'),
					('D00005','P07','1','0'),
					('D00006','P07','1','0'),
					('D00007','P04','1','0.10'),
					('D00007','P08','2','0.10'),
					('D00008','P08','2','0.10'),
					('D00009','P08','1','0'),
					('D00010','P04','1','0'),
					('D00011','P08','1','0'),
					('D00012','P08','1','0'),
					('D00013','P08','1','0.10'),
					('D00014','P08','1','0'),
					('D00015','P05','1','0.10'),
					('D00015','P08','2','0.15'),
					('D00016','P06','1','0.10'),
					('D00016','P08','2','0.10');";
			$this->mysqlQuery($InOrderDetailsTable);
		}

		function updateCountrestore()
		{
			mysqli_select_db($this->con,$this->mainDB);			//use main dbname
			$con = $this->con;
			if (mysqli_connect_errno())
			{
    			printf("Connect failed: %s", mysqli_connect_error());
    			exit();
			}
			$sid = $this->studentID;
			$select = "select countrestore from mdl_mysqlexp_userdb where sid ='".$sid."';";
			if($result = mysqli_query($con,$select))
			{
				$row=mysqli_fetch_array($result);
				$countrestore = $row['countrestore']+1;				//increment
				$update = "UPDATE mdl_mysqlexp_userdb SET countrestore=".$countrestore." where sid ='".$sid."';";
				if($result = mysqli_query($con,$update))
				{
					echo "ok";
				}
			}
		}

		function insertSidToUserdb()
		{
			mysqli_select_db($this->con,$this->mainDB);			//use main dbname
			$con = $this->con;
			if (mysqli_connect_errno()) 
			{
    			printf("Connect failed: %s", mysqli_connect_error());
    			exit();
			}
			$sid = $this->studentID;
			$insert = "INSERT INTO mdl_mysqlexp_userdb (sid,countrestore) VALUES ('".$sid."',0)";
			if($result = mysqli_query($con,$insert))
			{
    			echo "ok";
			}else{
				printf("Error: %s", mysqli_error($con));
				exit();
			}
		}

		function getSidRow()
		{
			$con = $this->con;
			if (mysqli_connect_errno())
			{
    			printf("Connect failed: %s", mysqli_connect_error());
    			exit();
			}
			$sid = $this->studentID;
			$select = "select * from mdl_mysqlexp_userdb where sid ='".$sid."';";
			if($result = mysqli_query($con,$select))
			{
				$row = mysqli_num_rows($result);
    			mysqli_free_result($result);		// close result set
			}
			return $row;
		}
	}
 ?>