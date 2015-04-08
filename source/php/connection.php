<?php 
// dirname is get path of source file for use this function all directory when include this file
//ใช้ dirname ทำให้เราสามารถเรียกฟังก์ชั่นนี้จากที่ไหนก็ได้เมื่อใช้การ include 
//ก่อนหน้านี้จะมีปัญหาเรื่อง paht เพราะบางไฟล์ include ไฟล์นี้ไปใช้กันคนละที่ paht เลยไม่ตรงกัน
	include(dirname(__FILE__).'/model_connection.php');
	include(dirname(__FILE__).'/model_getJsonConnection.php');

function connection()
{
	//get json connection
	$gjc = new getJsonConnection();
	$c = $gjc->getConnection(dirname(dirname(__FILE__)).'/connection.json');
	//get connect to db
	$cdb = new connectDB($c['host'],$c['user'],$c['pass'],$c['dbname']);
	$cdb->connect();
	$con = $cdb->con;
	return $con;
}

function getConInfo()
{
	$gjc = new getJsonConnection();
	$c = $gjc->getConnection(dirname(dirname(__FILE__)).'/connection.json');
	
	$conInfo = array('host' => $c['host'],'user' => $c['user'],'pass' => $c['pass'],'dbname' => $c['dbname']);
	return $conInfo;
}
?>