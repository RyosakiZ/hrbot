<?php
require_once("config/dbconnect.php");

//$datarange = $_POST['daterange'];
//$datarange = '01/01/2018 - 01/12/2018';
//$datarange = $_POST['monthrange'];
$startdate = $_POST['startdate'];
//$startdate = '2019-12-01';
$enddate = $_POST['enddate'];
if ($startdate){
    echo $startdate;
}
//$enddate = '2019-12-10';
//echo $startdate;
die();
$sql = "SELECT users_id,users_fname,users_lname,checkin_date,checkin_time,(select checkout_time from checkout where checkout_users_id = a.users_id and checkout_date = checkin_date)as getcheckout 
from users a left join checkin b on b.checkin_users_id = a.users_id 

WHERE checkin_date  between '$startdate' and '$enddate'

AND checkin_category = '1'



        ";

$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", $conn->error);
    exit();
}

// $resultArray = array();
// while ($resultx = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//     array_push($resultArray, $resultx);
// }
$resultArray = array();
$resultArray2 = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

    $checkout_time = $row['getcheckout'];
    $checkin_time = $row['checkin_time'];
    $checkin_date = $row['checkin_date'];
  

        $resultArray[$row['users_id']][$row['checkin_date']]  = $row['checkin_time']."|".$checkout_time  ;   
        // $resultArray2[$row['users_id']][$row['checkout_date']]  = $row['checkout_time'];
    // if (isset($resultArray[$row['users_id']][$row['checkin_date']]) || isset($resultArray2[$row['users_id']][$row['checkout_date']])) {
        //   $resultArray[$row['users_id']][$row['checkin_date']]  = $row['checkin_time'];   
        //  $resultArray2[$row['users_id']][$row['checkout_date']]  = $row['checkout_time'];
    // } else { // ถ้ายังไม่มีให้เท่ากับ 1

  
    //      $resultArray[$row['users_id']][$row['checkin_date']] =  $row['checkin_time'];
    //      $resultArray2[$row['users_id'] ][$row['checkout_date']]  = $row['checkout_time'];


    
    }
// }


// echo '<pre>';
// var_dump(array_merge($resultArray,$resultArray2));
// echo '</pre><hr />';


?>

<?php
//เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor

require_once __DIR__ . '/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([


    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/custom/font/directory',
    ]),
    'fontdata' => $fontData + [
        'THSaraban' => [
            'R' => "THSaraban.ttf",
            'B' => "THSaraban Bold.ttf",
            'I'  => "THSaraban Italic.ttf",
            'BI'   =>  "THSaraban BoldItalic.ttf",
        ]
    ],
    'default_font' => 'THSaraban'
]);


function diff2time($time_a, $time_b)
{
    $now_time1 = strtotime(date("Y-m-d " . $time_a));
    $now_time2 = strtotime(date("Y-m-d " . $time_b));
    $time_diff = abs($now_time2 - $now_time1);
    $time_diff_h = floor($time_diff / 3600); // จำนวนชั่วโมงที่ต่างกัน
    $time_diff_m = floor(($time_diff % 3600) / 60); // จำวนวนนาทีที่ต่างกัน
    $time_diff_s = ($time_diff % 3600) % 60; // จำนวนวินาทีที่ต่างกัน
    return $time_diff_h . " ชั่วโมง " . $time_diff_m . " นาที " . $time_diff_s . " วินาที";
}






$content = '';


  
        foreach ($resultArray as $k_item => $v_data) {

            $sql_checkname = "SELECT users_fname,users_lname,users_emp_id from users where users_id = $k_item ";

                $resultc = mysqli_query($conn, $sql_checkname);
                if (!$resultc) {
                    printf("Error: %s\n", $conn->error);
                    exit();
                }
                $name = $resultc->fetch_assoc();


            for ($i = 0; $i <= 30; $i++) {

                $key_date = date("Y-m-d", strtotime($startdate . " +$i day"));


                if (isset($v_data[$key_date]) == $key_date) {

    $content .= ' <tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:3px;text-align:center;"  > <h1 align="center">'.$name['users_fname'].' '.$name['users_lname'].'</h1></td>
    <td style="border-right:1px solid #000;padding:3px;text-align:center;"  > <h1 align="center">'.$name['users_emp_id'].'</h1></td>
                    
    </tr>';


    }

    }

    }



$head = '
            <style>
                body{
                    font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
                }@page { sheet-size: A3-L; }
            </style>

            <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12pt;margin-top:8px;">
            <thead>

            <tr style="border:0px solid #000;padding:4px;">
            <td  style="border-right:0px solid #000;padding:4px;text-align:left;"   width="15%"><img src="assets/img/icons/pnlogo.png"  width="130" height="100" class="img-thumbnail">
      
            </td>
            <td  style="border-right:0px solid #000;padding:4px;text-align:center;"   width="65%">          
            <h3 align="center"> รายละเอียดชั่วโมงการทำงานของพนักงาน แสดงตามชั่วโมง รายเดือน ประจำวัน  <br>' . $datarange . '</h3> 
          
            <td  width="20%" style="border-right:0px solid #000; "><h2 style="text-align:right" >&nbsp; บริษัท พีเอ็น ออลล์ จำกัด</h2>  
            <p align="right"> สำนักงานคู้บอน 170 1 ซอยคู้บอน27 แขวง ท่าแร้ง เขตบางเขน กรุงเทพมหานคร 10220</p></td> 
          

        </tr>   
    </thead>
    <tbody>
    </tbody></table>     
            <hr>
            <br>
            <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12pt;margin-top:8px;">
            <thead>
                <tr style="border:1px solid #000;padding:4px;">
                <th  width="60%" style="border-right:1px solid #000;padding:4px;text-align:center;"><h1>&nbsp;ชื่อ นามสกุล </h1></th>
                    <th  width="60%" style="border-right:1px solid #000;padding:4px;text-align:center;"><h1>&nbsp;พนักงาน </h1></th>
                    <th  width="60%" style="border-right:1px solid #000;padding:4px;text-align:center;"><h1>&nbsp;เข้างานเวลา </h1></th>
                 
            
            
            ';
           
$head .= ' <th  width="60%" style="border-right:1px solid #000;padding:4px;text-align:center;"><h1>&nbsp;ออกงานเวลา </h1></th>';
$head .= "</tr>   </thead><tbody>";



$end = "</tbody></table>";


$footer = '<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>';

$mpdf->SetTitle("PN ALL Co.,LTD - รายงานการทำงานของพนักงานช่วงเวลา " . $datarange . "");
$mpdf->SetAuthor("HR BOT.");
$mpdf->WriteHTML($head);
$mpdf->WriteHTML($content);
$mpdf->WriteHTML($end);
$mpdf->WriteHTML($footer);

$mpdf->Output();

?>






<!-- 
main conent -->


<!-- 
$checkin = $row['checkin_time'];
       $checkout = $row['checkout_time '];

       $originalDate =  $row['checkin_date'];
       $newDate = date("d/m/Y", strtotime($originalDate));


        $content .= '
        <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"  > <h1 align="center">'.
         
            $newDate
          
          .'</h1></td>

            <td style="border-right:1px solid #000;padding:3px;" > <h1 align="center">'.$row['users_fname'] .' '.$row['users_fname'].'</h1></td>

            <td style="border-right:1px solid #000;padding:3px;" > <h1 align="center">' . $row['checkin_time'].'</h1></td>

            <td style="border-right:1px solid #000;padding:3px;" > <h1 align="center">' . $row['checkout_time'].'</h1></td>

            

            <td style="border-right:1px solid #000;padding:3px;" > <h1 align="center">' . diff2time(  $checkin, $checkout).'</h1></td>
        </tr>'
        
        
        ;
        $i++; --><!-- 
$sql = "SELECT
*,
(
SELECT
min(checkin_time)
FROM
checkin b
WHERE b.checkin_id > a.checkin_id
AND b.checkin_users_id = a.checkin_users_id
AND checkin_category = '3'
) AS checkout
FROM
checkin a
LEFT JOIN users c ON c.users_id = a.checkin_users_id
WHERE
checkin_category = 1
AND checkin_date between '$startdate' and '$enddate'
ORDER BY checkin_id ASC


";



$sql = " SELECT users_id , users_fname , users_lname , users_emp_id ,checkin_date ,checkout_date , checkin_time , checkout_time  FROM  users 
        LEFT JOIN checkin on checkin.checkin_users_id = users.users_id 
        LEFT JOIN checkout on checkout.checkout_users_id = users.users_id 
        where checkin_date between '$startdate' and '$enddate' AND checkout_date between '$startdate' and '$enddate'
        ";

-->
