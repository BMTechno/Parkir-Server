<?php
/*
	by Albert Alfrianta @Tomcat INC
	22 Mei 2015, Bogor
*/
require_once("mysql.php");
$dbHost = "localhost";	//server
$dbUsername = "root";	//usernamenya
$dbPassword = "";		//password database
$dbName = "parkir";		//nama databasenya
$db = new MySQL($dbHost,$dbUsername,$dbPassword,$dbName);

//konstanta untuk sinyal pesan sukses atau failed atau error
define("SUCCESS", 0);	//signal success
define("FAILED", 1);	//signal failed
define("ERROR", 2);		//signal error
define("AUTHFAILED", 6);	//signal failed

$out=0;

$action = '';
$id = '';
$password='';

$action = $_POST['action'];		//ambil isi data pada variable 'action' yg di post client
$id = $_POST['id'];
$password=$_POST['password'];
$auth=FAILED;
if($action=="login"){
	$sql="SELECT * FROM user_admin WHERE id='$id' AND user_key='$password'";
	if($db->query($sql)){
		if($db->fetchRow($sql)!=null){
			$newPassword=generatePassword();
			$sql="UPDATE user_admin
					SET password='$newPassword'
					WHERE id='$id' AND user_key='$password'
					;
					";
			$out=query($db,$sql);
			if($out==SUCCESS){
				$password=array();
				$password[0]['password']=$newPassword;
				$out=json_encode($password);
			}
			else
				$out=FAILED;
		}
		else
			$out=FAILED;
	}
	else
		$out=FAILED;
}
else{
	$auth=auth($db,$id,$password);
	if($auth==SUCCESS)
		$out=SUCCESS;
	else
		$out=FAILED;
}

if($auth==SUCCESS && isset($action)){	//jika $action tidak null
	switch($action) {
		case "getListParkir":	
			$sql="SELECT id,latitude,longitude,name
					FROM parkir
					;";
			$out=get($db,$sql);		//gunakan method get untuk ambil data! $out= hasil return method get tadi
			//Contoh Hasil: [{"nama":"albert"}]
		break;
		case "getDetailParkir":	
			$parkirId=$_POST['parkir_id'];
			$sql="SELECT id,latitude,longitude,name,address,price,capacity,available
					FROM parkir
					WHERE id='$parkirId'
					;";
			$out=get($db,$sql);		//gunakan method get untuk ambitl data! $out= hasil return method get tadi
			//Contoh Hasil: [{"nama":"albert"}]
		break;
		case "getListRequestedParkir":	
			$sql="SELECT id,latitude,longitude,name
					FROM parkir_request
					;";
			$out=get($db,$sql);	
		break;
		case "getDetailRequestedParkir":	
			$parkirId=$_POST['parkir_id'];
			$sql="SELECT id,latitude,longitude,name,address,price,capacity
					FROM parkir_request
					WHERE id='$parkirId'
					;";
			$out=get($db,$sql);
		break;

		case "addParkir":	
			$parkir_lat = $_POST['parkir_lat'];
			$parkir_lng = $_POST['parkir_lng'];
			$parkir_name = $_POST['parkir_name'];
			$parkir_address = $_POST['parkir_address'];
			$parkir_price = $_POST['parkir_price'];
			$parkir_capacity = $_POST['parkir_capacity'];
			$sql="INSERT INTO parkir(latitude,longitude,name,address,price,capacity,available)
					VALUES ('$parkir_lat','$parkir_lng','$parkir_name','$parkir_address','$parkir_price','$parkir_capacity','$parkir_capacity')
					;";
			$out=query($db,$sql);
		break;
		case "editParkir":	
			$parkir_id = $_POST['parkir_id'];
			$parkir_lat = $_POST['parkir_lat'];
			$parkir_lng = $_POST['parkir_lng'];
			$parkir_name = $_POST['parkir_name'];
			$parkir_address = $_POST['parkir_address'];
			$parkir_price = $_POST['parkir_price'];
			$parkir_capacity = $_POST['parkir_capacity'];
			$sql="UPDATE parkir
					SET 
						id='$parkir_id',
						latitude='$parkir_lat',
						longitude='$parkir_lng',
						name='$parkir_name',
						address='$parkir_address',
						price='$parkir_price',
						capacity='$parkir_capacity'
					WHERE id='$parkir_id'
					;";
			$out=query($db,$sql);
		break;
		case "deleteParkir":	
			$parkir_id = $_POST['parkir_id'];
			$sql="DELETE FROM parkir
					WHERE id='$parkir_id'
					;";
			$out=query($db,$sql);
		break;
		

		case "confirmRequestedParkir":	
			$requested_parkir_id = $_POST['parkir_id'];
			$parkir_lat = $_POST['parkir_lat'];
			$parkir_lng = $_POST['parkir_lng'];
			$parkir_name = $_POST['parkir_name'];
			$parkir_address = $_POST['parkir_address'];
			$parkir_price = $_POST['parkir_price'];
			$parkir_capacity = $_POST['parkir_capacity'];
			$sql="INSERT INTO parkir(latitude,longitude,name,address,price,capacity)
					VALUES ('$parkir_lat','$parkir_lng','$parkir_name','$parkir_address','$parkir_price','$parkir_capacity')
					;";
			$out=query($db,$sql);
			if($out==SUCCESS){
				$sql="DELETE FROM parkir_request
						WHERE id='$requested_parkir_id'
						;";
				$out=query($db,$sql);
			}
		break;
		case "deleteRequestedParkir":	
			$requested_parkir_id = $_POST['parkir_id'];
			$sql="DELETE FROM parkir_request
					WHERE id='$requested_parkir_id'
					;";
			$out=query($db,$sql);
		break;
		
	}

}

function auth($db,$id,$password){
	$sql="SELECT * FROM user_admin WHERE id='$id' AND password='$password'";
	if($db->query($sql)){
		if($db->fetchRow($sql)!=null){
			return SUCCESS;
		}
		else
			return FAILED;
	}
	else
		return ERROR;
}

function generatePassword(){
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()";
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 15; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return md5(implode($pass),FALSE);
}

//Ini gk usah di edit

//untuk menjalani perintah ke database. 
function query($db,$sql){
	if($db->query($sql))	//laksanakan query di mysql.php!
		return SUCCESS;		////jika sukses query di mysql
	else
		return FAILED;		//jika gagal saat query di mysql
}


//untuk mengambil data
function get($db,$sql){
	$query=$db->query($sql);				//panggil method query
	if($query){
		if($json=$db->fetch($query))		//jika query sukses
			return $json;					//return data
		else 
			return FAILED;					//jika gagal saat query di mysql
	}
	else 
		return ERROR;						//jika error saat query di mysql
}

echo $out;		//tulis outputnya!

?>
