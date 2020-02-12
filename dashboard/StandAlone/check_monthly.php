<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php"); ?>

<?php



//$startdate = '2019-01';
//$enddate = '2019-02';
$startdate =  $_POST['startdate1'];
$enddate = $_POST['enddate1'];
$sql = "SELECT users_id,users_fname,users_lname,checkin_time,checkin_date,(select checkout_time from checkout where checkout_users_id = a.users_id and checkout_date = checkin_date)as getcheckout 
from users a left join checkin b on b.checkin_users_id = a.users_id 
WHERE checkin_date  between '$startdate' and '$enddate'
-- AND users_id = '18'
AND checkin_category = '1' 
ORDER BY checkin_date ASC
";






$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", $conn->error);
    exit();
}

$resultArray = array();


while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {



    array_push($resultArray, $row);
}

$sql2 = "SELECT leave_paper_users_id , leave_paper_start_date , leave_paper_end_date from leave_paper 
WHERE `leave_paper_start_date`
AND `leave_paper_end_date`  between '$startdate' and '$enddate' 
-- AND leave_paper_users_id = '18'
ORDER BY leave_paper_start_date ASC
";

$resultArray_leave = array();
$result_2 = mysqli_query($conn, $sql2);
while ($row_2 = mysqli_fetch_array($result_2)) {

    array_push($resultArray_leave, $row_2);
}
// print("<pre>".print_r($resultArray,true)."</pre>");


foreach ($resultArray as $key1 => $value1) {
    foreach ($resultArray_leave as $key2 => $value2) {


/*
        if ($value1['users_id'] == $value2['leave_paper_users_id']) {
            $result_array_all[$value1['users_id'] . "-leave-" . $value2['leave_paper_start_date']] = $value2 + $value1;
        } else {
            $result_array_all[$value1['users_id'] . "-normal-" . $value1['checkin_date']] = $value1;
        }
        */

        if ($value1['users_id'] == $value2['leave_paper_users_id']) {
            $result_array_all[$value1['users_id'] . "-leave-" . $value2['leave_paper_start_date']] = $value2 + $value1;
        } else {
            $result_array_all[$value1['checkin_date']] = $value1;
        }
    }
}
echo '<hr>';
print("<pre>" . print_r($result_array_all, true) . "</pre>");


    $explode_arr = array();

    foreach($result_array_all as $k => $v) {

        $ex_temp = explode("-" ,$k);

        

        array_push($explode_arr,$ex_temp);
    }

    
echo '<hr>';
print("<pre>" . print_r($explode_arr, true) . "</pre>");

    
?>





<body>

    <?php //include("component/mod_menu.php"); 
    ?>



    <div class="header bg-gradient-primary pb-12 pt-8 pt-md-12"> </div>

    <div class="container-fluid  mt--7">
        <div class="header-body"></div>

        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header border-0">
                            <h3 class="mb-0">Monthly Report</h3>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">

                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">รหัสพนักงาน</th>
                                        <th scope="col" class="sort" data-sort="name">ชื่อ</th>
                                        <?php for ($i = 1; $i <= 31; $i++) { ?>

                                            <th scope="col"><?= $i ?></th>
                                        <?php } ?>

                                    </tr>
                                </thead>

                                <?php
                                if ($resultArray && $result_array_all) {

                                    //$mergeArray = array_merge($resultArray,$explode_arr);
                                        foreach ($explode_arr as $k_item => $v_data) {

                                        
                                         
                                        
                                            // echo "TEST";

                                ?>
                                        <tbody class="list">
                                                
                                            <tr>
                                                <!-- //แยกไอเทม เป็น arrays -->
                                                <td><?= $v_data[0]?></td>
                                                <th scope="row">

                                                    <!-- statement check Date -->
                                                    <?php for ($i = 0; $i <= 30; $i++) {

                                                        $key_date = date("Y-m-d", strtotime($startdate . " +$i day"));


                                                        //   echo $key_date;

                                                        // if (isset($v_data[$key_date]) == $key_date) {
                                                            if($v_data) {
                                                                
                                                            ?>


                                                            <?php echo '<td>' . $v_data[1] . '</td>' ?>
                                                            
                                                          


                                                    <?php

                                                        } else {



                                                            //ไม่มาทำงาน
                                                            echo ' <td bgcolor="#FF0000"> - </td>';
                                                        }
                                                    } ?>


                                            <?php


                                        }
                                    }

                                            ?>

                                                </th>


                                            </tr>
                                        </tbody>
                            </table>
                        </div>
                        <!-- Card footer -->
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">
                                            <i class="fas fa-angle-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <i class="fas fa-angle-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>





        </div>



        <?php include("component/mod_menu_footer.php"); ?>


        <?php include('config/scipts-config.php'); ?>
</body>

</html>