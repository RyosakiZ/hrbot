<?php



date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$time = date("H:i:s");
include('../config/dbconnect.php');


$department_name = $_GET["department_name"];
//$section_id = $_GET["section_id_depart"];
$department_id = $_GET["department_id"];

//echo $section_name;
//echo $section_id;
// echo $id;
// echo $status;

// if(isset($_POST['btn1']))
// {
//   $data = $_POST['submit1'];
//   echo $data;
// }else if(isset($_POST['btn2']))
// {
//   $data = $_POST['submit2'];
//   echo $data;
// }else if(isset($_POST['btn3']))
// {
//   $data = "test = ".$_POST['submit3'];
//   echo $data;
// }




 $conn=mysqli_connect($serverName,$userName,$userPassword,$dbName)or die("connecterror");
 mysqli_set_charset($conn,"utf8");


 $sql = "UPDATE department SET 
 department_name = '$department_name'
 WHERE department_id = '$section_id' ";

	$query = mysqli_query($conn,$sql);

	if($query) {
     echo "อัพเดทข้อมูลเรียบร้อยค่ะ";
     
     header( "refresh: 2; url=../department_details.php?department_id=".$department_id );
     exit(0);
	}else {
        echo "eror";
    }

	mysqli_close($conn);
?>