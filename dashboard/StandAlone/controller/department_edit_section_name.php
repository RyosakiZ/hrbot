<?php



date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$time = date("H:i:s");
include('../config/dbconnect.php');

/* <input type="text" name="section_name" value="<?=$row["section_name"] ?>" class="form-control"  />   
 */

$section_name = $_POST["section_name1"];
$section_id = $_POST["section_id1"];
$department_id = $_POST["department_id"];

echo 'Section name: ' . $section_name;
echo '<br>';
echo 'Section id: ' . $section_id;
echo '<br>';
echo 'Department id: ' . $department_id;

die();

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


 $sql = "UPDATE section SET 
 section_name = '$section_name'
 WHERE section_id = '$section_id' AND section_department_id = '$department_id' ";

	$query = mysqli_query($conn,$sql);

	if($query) {
     echo "อัพเดทข้อมูลเรียบร้อยค่ะ";
     
     header( "refresh: 2; url=../department_details.php?department_id=".$department_id );
     exit(0);
	}else {
        echo "error";
    }

	mysqli_close($conn);
?>