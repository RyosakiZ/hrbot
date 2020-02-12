<?php



date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$time = date("H:i:s");
include('../config/dbconnect.php');

$department_name = $_POST["department_name"];





// echo "old = ".$old_bd; 
// echo "new".$bd;

// echo $fullname;
// // echo $id;
// // echo $info;echo $pic;
// echo $statusMessage;

 $conn=mysqli_connect($serverName,$userName,$userPassword,$dbName)or die("connecterror");
 mysqli_set_charset($conn,"utf8");


 $sql = "INSERT INTO department (department_name,department_status)
 VALUES ('$department_name','1') ";

	$query = mysqli_query($conn,$sql);

	if($query) {
        echo json_encode(array("statusCode" => 200));
	}else {
        echo json_encode(array("statusCode" => 201));
    }

	mysqli_close($conn);
