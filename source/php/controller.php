<?php 
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/lib.php');
//check login
if(empty($USER->username)){
	header( "refresh: 0; url=../../../../login/index.php" );	//redirect to http://localhost/moodle/login/index.php
	exit(0);
}

$mode = $_REQUEST["mode"];
if(empty($mode)){
	echo "Error: Mode was empty";
	exit(0);
}

if($mode == "checkdb")
{
	include("./model_userdb.php");
	$udb = new userDB('localhost','root','1234',$USER->username);

	if($udb->getSidRow() == 0)		//if mdl_mysqlexp_userdb table not have sid 
	{
		//create database and user
		$udb->connect();																
		$udb->createUserDB();							
		$udb->createTables();							
		$udb->insertTables();							
		$udb->disConnect();

		//insert sid to mdl_mysqlexp_userdb table
		$udb->insertSidToUserdb();							
	}
}

if($mode == "restoredb")
{
	//restore database
	include("./model_userdb.php");
	$udb = new userDB('localhost','root','1234',$USER->username);
	$udb->connect();								
	$udb->dropDB();									
	$udb->createUserDB();							
	$udb->createTables();							
	$udb->insertTables();							
	$udb->disConnect();								

	//increment countRestore ;
	$udb->updateCountrestore();
}

if($mode == "sendcode")
{
	$code = $_REQUEST["code"];
	if(empty($code)){
		echo "Error: Query was empty";
		exit(0);
	}
	include("./model_sqlquery.php");
	$query = new userQuery('localhost',$USER->username,'pwn_'.$USER->username,$code);
	$query->connect();
	$query->selectDB();
	$query->mysqlQuery();
	$query->disConnect();

}


?>