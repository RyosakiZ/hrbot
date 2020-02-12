<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php"); ?>

<?php



$startdate =  $_POST['startdate1'];
$enddate = $_POST['enddate1'];
$sql = "SELECT *,(select checkout_time from checkout where checkout_users_id = a.users_id and checkout_date = checkin_date)as getcheckout 
from users a left join checkin b on b.checkin_users_id = a.users_id 

WHERE checkin_date  between '$startdate' and '$enddate'

AND checkin_category = '1'

        ";

$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", $conn->error);
    exit();
}

$resultArray = array();
$resultArray2 = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

    $checkout_time = $row['getcheckout'];
    $checkin_time = $row['checkin_time'];
    $checkin_date = $row['checkin_date'];


    $resultArray[$row['users_fname']." ".$row['users_lname']][$row['checkin_date']]  = $row['checkin_time'] . "|" . $checkout_time;
    // $resultArray2[$row['users_id']][$row['checkout_date']]  = $row['checkout_time'];
    // if (isset($resultArray[$row['users_id']][$row['checkin_date']]) || isset($resultArray2[$row['users_id']][$row['checkout_date']])) {
    //   $resultArray[$row['users_id']][$row['checkin_date']]  = $row['checkin_time'];   
    //  $resultArray2[$row['users_id']][$row['checkout_date']]  = $row['checkout_time'];
    // } else { // ถ้ายังไม่มีให้เท่ากับ 1


    //      $resultArray[$row['users_id']][$row['checkin_date']] =  $row['checkin_time'];
    //      $resultArray2[$row['users_id'] ][$row['checkout_date']]  = $row['checkout_time'];



}
// }


?>



<body>

    <?php include("component/mod_menu.php"); ?>



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
                            <h3 class="mb-0">Monthly Report </h3>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">

                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">ชื่อ</th>
                                        <!--<th scope="col" class="sort" data-sort="name">ชื่อ</th>-->
                                        <th scope="col">วันที่</th>
                                        <?php for ($i = 1; $i <= 31; $i++) { ?>

                                            <th scope="col"><?= $i ?></th>
                                        <?php } ?>

                                    </tr>
                                </thead>

                                <?php
                                if ($resultArray) {


                                    foreach ($resultArray as $k_item => $v_data) {
                                        




                                ?>
                                        <tbody class="list">

                                            <tr>

                                            <td><?=  $k_item ?></td>
                                                <th scope="row">

                                                    <!-- statement check Date -->
                                                    <?php for ($i = 0; $i <= 30; $i++) {

                                                        $key_date = date("Y-m-d", strtotime($startdate . " +$i day"));


                                                        //   echo $key_date;

                                                        if (isset($v_data[$key_date]) == $key_date) { ?>


                                                            <?php echo '<td>' . $v_data[$key_date] . '</td>' ?>
                                                            <!-- <?php echo '<td> ' . $v2_data[$key_date] . '</td>' ?> -->


                                                    <?php

                                                        } else {
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