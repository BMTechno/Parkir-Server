<?php
/*
	by Albert Alfrianta @Tomcat INC
	22 Mei 2015, Bogor
*/
class MySql{
private $dbLink;
	private $dbHost;
	private $dbUsername;
    private $dbPassword;
	private $dbName;
	public  $queryCount;
	
	function MySQL($dbHost,$dbUsername,$dbPassword,$dbName)	{
		$this->dbHost = $dbHost;
		$this->dbUsername = $dbUsername;
		$this->dbPassword = $dbPassword;
		$this->dbName = $dbName;	
		$this->queryCount = 0;		
	}

	function __destruct()	{
		$this->close();
	}

	//connect to database
	private function connect() {	
		$this->dbLink = mysql_connect($this->dbHost, $this->dbUsername, $this->dbPassword);		
		if (!$this->dbLink)	{			
			$this->ShowError();
			return false;
		}
		else if (!mysql_select_db($this->dbName,$this->dbLink))	{
			$this->ShowError();
			return false;
		}
		else {
			mysql_query("set names latin5",$this->dbLink);
			return true;
		}
		unset ($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);		
	}	

	/*****************************
	 * Method to close connection *
	 *****************************/
	function close()	{
		@mysql_close($this->dbLink);
	}

	function ShowError(){
		$error = mysql_error();
		//echo $error;		
	}
	
	function query($sql){
		if (!$this->dbLink)	
			$this->connect();
		if (!$result=mysql_query($sql,$this->dbLink)) { 
			return false;
		}
		$this->queryCount++;	
		return $result;
	}

	//fetch 1 row
	function fetchRow($sql){
		$query=$this->query($sql);
		if($row=mysql_fetch_row($query))		
			return $row;
	}

	//fetch object
	function fetch($result){
		while($data=mysql_fetch_assoc($result)){
		    $json[]=$data;
		}
		if(isset($json))
			return json_encode($json);
		else
			return null;
	}

	//get number of rows
	function numRows($result) {
		if (false === ($num = mysql_num_rows($result))) {
			$this->ShowError();
			return -1;
		}
		return $num;		
	}

}
