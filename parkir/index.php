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
	$sql="SELECT * FROM user_customer WHERE id='$id' AND user_key='$password'";
	if($db->query($sql)){
		if($db->fetchRow($sql)!=null){
			$newPassword=generatePassword();
			$sql="UPDATE user_customer
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
else if($action=="register"){
	$sql="SELECT * FROM user_customer WHERE id='$id' AND user_key='$password'";
	if($db->query($sql)){
		if($db->fetchRow($sql)==null){
			$sql="INSERT INTO user_customer(id,user_key)
					VALUES ('$id','$password')";
			$out=query($db,$sql);
			//$out=$sql;
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
		case "getListParkirSave":	
			$sql="SELECT id,latitude,longitude,name
					FROM parkir
					LEFT JOIN parkir_save
					ON parkir.id=parkir_save.id_parkir
					WHERE parkir_save.customer='$id'
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
			$out=get($db,$sql);		//gunakan method get untuk ambil data! $out= hasil return method get tadi
			//Contoh Hasil: [{"nama":"albert"}]
		break;
		case "checkParkirSave":	
			$parkirId=$_POST['parkir_id'];
			$sql="SELECT COUNT(*) as total
					FROM parkir_save
					WHERE customer='$id' AND id_parkir='$parkirId'
					;";
			$out=get($db,$sql);		//gunakan method get untuk ambil data! $out= hasil return method get tadi
			//Contoh Hasil: [{"nama":"albert"}]
		break;
		case "saveParkir":	
			$parkirId=$_POST['parkir_id'];
			$sql="INSERT INTO parkir_save(customer,id_parkir)
					VALUES ('$id','$parkirId')
					;";
			$out=query($db,$sql);		//gunakan method get untuk ambil data! $out= hasil return method get tadi
			//Contoh Hasil: [{"nama":"albert"}]
		break;
		case "removeSaveParkir":	
			$parkirId=$_POST['parkir_id'];
			$sql="DELETE FROM parkir_save
					WHERE customer='$id' AND id_parkir='$parkirId'
					;";
			$out=query($db,$sql);		//gunakan method get untuk ambil data! $out= hasil return method get tadi
			//Contoh Hasil: [{"nama":"albert"}]
		break;

		case "insertMhs":
			$id_mhs=$_POST['id_mhs'];
			$nama=$_POST['nama'];
			$sql="INSERT INTO mahasiswa(id_mhs,nama)
					VALUES ('$id_mhs','$nama')
					;";
			$out=query($db,$sql);		//gunakan method query! $out= hasil return method quert tadi
			//contoh hasil: 1 	//1 berarti sukses
		break;

		case "updateMhs":
			$id_mhs=$_POST['id_mhs'];
			$nama=$_POST['nama'];
			$sql="UPDATE mahasiswa
					SET nama='$nama'
					WHERE id_mhs='$id_mhs'
					;";
			$out=query($db,$sql);		//gunakan method query! $out= hasil return method query tadi
			//contoh hasil: 1 	//1 berarti sukses
		break;

		case "deleteMhs":
			$id_mhs=$_POST['id_mhs'];
			$sql="DELETE FROM mahasiswa
					WHERE id_mhs='$id_mhs'
					;";
			$out=query($db,$sql);		//gunakan method query! $out= hasil return method delete tadi
			//contoh hasil: 1 	//1 berarti sukses
		break;
	}

}

function auth($db,$id,$password){
	$sql="SELECT * FROM user_customer WHERE id='$id' AND password='$password'";
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
