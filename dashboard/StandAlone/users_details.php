<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php"); ?>

<body>
    <?php include("component/mod_menu.php"); ?>


    <?php
    date_default_timezone_set("Asia/Bangkok");

    $time = date("H:i:s");
    $users_id = $_GET["users_id"];

    $sql = "SELECT * FROM users 
LEFT JOIN department on users.users_department = department.department_id 
LEFT JOIN section on section.section_department_id = department_id 
LEFT JOIN section_details on section.section_details_id = section_details.section_details_id  
LEFT JOIN avatar on avatar.avatar_users_id = users.users_id
WHERE users_id = '$users_id' 
AND users_section = section_id
GROUP BY users_id
";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // var_dump($row);


    ?>

    <!-- Header -->
    <!--บน-->

    <div class="header bg-gradient-primary pb-12 pt-8 pt-md-12">

    </div>


    <div class="container-fluid mt--7">
        <!----- MAIN CONTENT ?? --->

        <div class="row">
            <div class="col-xl-4 order-xl-1 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">


                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="card-profile-image">
                            <?php if ($row["avatar_img"] != NULL) {
                                echo '<img alt=""  class=" rounded-circle"  width = "150" height="150"  src="./public/fileupload/' . $row["avatar_img"] . '">';
                            } else {
                                echo ' <img alt="" class=" rounded-circle"  width = "150" height="150"  src="assets/img/brand/bot.png">';
                            }
                            ?>

                        </div>
                        <br> <br>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">

                                <div class="text-center">
                                    <h2> <?= $row["users_fname"] . " " . $row["users_lname"] ?></h2>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <?php if ($row["users_active"] == '0') {
                                    echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-warning"></i>ไม่มีข้อมูลพนักงาน
                            </span> ';
                                }
                                if ($row["users_active"] == '1') {
                                    echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-success"></i>มีสถานะพนักงาน
                            </span> ';
                                }
                                if ($row["users_active"] == '2') {
                                    echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-primary"></i>พักงาน
                            </span> ';
                                }
                                if ($row["users_active"] == '3') {
                                    echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-danger"></i>หมดสถานะพนักงาน
                            </span> ';
                                }
                                ?>
                            </div>
                            <div class="col-1">

</div>

                            <?php

                                    if($row["users_uid"] == NULL){
                                        echo '<div class="col-1">
                                        <img alt="Image placeholder" src="assets/img/icons/LINE_APP-bw.png" class="avatar avatar-xs rounded-circle">
        
                                    </div>
                                    <div class="col-5">
        
                                    <span class="badge badge-dot mr-3">ยังไม่ถูกเชื่อมต่อ</span>
                                    </div> 
                                                        ';
                                    }else{

                                        echo '<div class="col-1">
                                        <img alt="Image placeholder" src="assets/img/icons/LINE_APP.png" class="avatar avatar-xs rounded-circle">
        
                                    </div>
                                    <div class="col-5">
        
                                    <span class="badge badge-dot mr-3">เชื่อมต่อสำเร็จ</span>
                                    </div> 
                                                        ';

                                    }

                            ?>
                            

                            <div class="col-1">

                            </div>
                        </div>

                        <div class="text-center">
                            <br>

                            <div>
                                แผนก <i class="mr-2"></i><?= $row["department_name"] ?> <br>
                                ฝ่าย <i class="mr-2"></i><?= $row["section_name"] ?>
                                <br>
                                <br>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#departmodal">ตั้งค่าแผนกและฝ่าย</button>
                            </div>
                            <hr class="my-4" />


                            <div class="h5 mt-1">
                                <i class="mr-2"></i>
                                <div class="d-flex">
                                    <div>
                                        รหัสพนักงาน
                                    </div>
                                    <div class="ml-auto">
                                        <?php if ($row["users_emp_id"] == "") {
                                            echo "ไม่มีข้อมูลค่ะ";
                                        } else {
                                            echo $row["users_emp_id"];
                                        }  ?>
                                    </div>
                                </div>

                            </div>
                            <div class="h5 mt-1">
                                <i class="mr-2"></i>
                                <div class="d-flex">
                                    <div>
                                        เบอร์โทรศัพท์ติดต่อ
                                    </div>
                                    <div class="ml-auto">
                                        <?php if ($row["users_mobile"] == "") {
                                            echo "ไม่มีข้อมูลค่ะ";
                                        } else {
                                            echo $row["users_mobile"];
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class="h5 mt-1">
                                <i class="mr-2"></i>
                                <div class="d-flex">
                                    <div>
                                        ที่อยู่
                                    </div>
                                    <div class="ml-auto">
                                        <?php if ($row["users_address"] == "") {
                                            echo "ไม่มีข้อมูลค่ะ";
                                        } else {
                                            echo $row["users_address"];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="h5 mt-1">
                                    <i class="mr-2"></i>
                                    <div class="d-flex">
                                        <div>
                                            วันเกิด
                                        </div>
                                        <div class="ml-auto">
                                            <?php if ($row["users_birthday"] == "0000-00-00") {
                                                echo "ไม่มีข้อมูลค่ะ";
                                            } else {
                                                echo date("d-m-Y", strtotime($row["users_birthday"]));
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="h5 mt-1">
                                    <i class="mr-2"></i>
                                    <div class="d-flex">
                                        <div>
                                            เพศ
                                        </div>
                                        <div class="ml-auto">
                                            <?php if ($row["users_gender"] == "0") {
                                                echo "ไม่มีข้อมูลค่ะ";
                                            } else {
                                                if ($row["users_gender"] == '1') {
                                                    echo "เพศชาย";
                                                }
                                                if ($row["users_gender"] == '2') {
                                                    echo "เพศหญิง";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <hr class="my-4" />
                                <div class= "col">     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#check_time">ตรวจสอบประวัติการเข้างาน</button>

                                </div>
                                <br>
                                <div class= "col">    
                                <a href="users_time_emp_leave.php?users_id_users=<?= $users_id ?>" class="btn btn-warning" role="button" aria-pressed="true">ตรวจสอบประวัติการลา</a>

</div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>

            <!--ขวา-->
            <div class="col-xl-8 order-xl-2">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h3 class="mb-0 "><i class="fa fa-user" aria-hidden="true"></i> รายละเอียดพนักงาน</h3>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#statusmodal">ตั้งค่าสถานะของพนักงาน</button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editmodal">แก้ไขรายละเอียด</button>
                            </div>
                            <div class="row">

                                <?php include('component/users_details_status_modal.php'); ?>
                                <?php include('component/users_details_modal.php'); ?>
                                <?php include('component/users_details_check_time.php'); ?>
                              
                            </div>
                            <div class="col-4">

                            </div>

                        </div>
                    </div>

                    <?php




                    if ($row["users_startjob"] == "0000-00-00") {
                        $startjob_temp = "ไม่มีข้อมูลค่ะ";
                        $diff_result = "ไม่มีข้อมูลค่ะ";
                    } else {
                        $date = date("d-m-Y");
                        $date1 = $row["users_startjob"];
                        $users_start_date = date("d-m-Y", strtotime($row["users_startjob"]));
                        $startjob_temp = $users_start_date;

                        $currentdate = date("Y-m-d", strtotime($date));
                        $datetocompare = date("Y-m-d", strtotime($row["users_startjob"]));
                        $datetime1 = new DateTime($currentdate);
                        $datetime2 = new DateTime($datetocompare);
                        $interval = $datetime1->diff($datetime2);
                        $diff_result = $interval->format('%y ปี %m เดือน  %d วัน');



                        $datestart = date("d-m-Y", strtotime($row["users_startjob"]));
                        $startjob_temp = $datestart;
                    }

                    if ($row["users_probationary"] == "0000-00-00") {
                        $probationary_temp = "ไม่มีข้อมูลค่ะ";
                    } else {
                        $users_promote_date = date("d-m-Y", strtotime($row["users_probationary"]));
                        $probationary_temp = $users_promote_date;
                    }

                    if ($row["users_promote_date"] == "0000-00-00") {
                        $promote_temp = "ไม่มีข้อมูลค่ะ";
                    } else {
                        $users_promote_date = date("d-m-Y", strtotime($row["users_promote_date"]));
                        $promote_temp = $users_promote_date;
                    }

                    $users_probationary = date("d-m-Y", strtotime($row["users_probationary"]));

                    ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                                <span class="badge badge-pill badge-success">วันที่เริ่มงาน</span>

                            </div>
                            <div class="col"><?= $startjob_temp ?></div>
                            <div class="col">
                                <span class="badge badge-pill badge-warning">ผ่านทดลองงาน</span>
                            </div>
                            <div class="col"><?= $probationary_temp ?></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="badge badge-pill badge-primary">วันที่บรรจุ</span>
                            </div>
                            <div class="col"><?= $promote_temp ?></div>
                            <div class="col">
                                <span class="badge badge-pill badge-danger">อายุงาน</span>
                            </div>
                            <div class="col"><?= $diff_result ?></div>
                        </div>

                    </div>
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0 "> <i class="fa fa-calendar" aria-hidden="true"></i> สรุปการลาประจำปีงบประมาณ : 2563</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ประเภทการลา</th>
                                        <th scope="col">สิทธิ</th>
                                        <th scope="col">ใช้ไป</th>
                                        <th scope="col">คงเหลือ</th>
                                    </tr>
                                </thead>
                                <?php
                                $sick = $row["section_details_sick"];
                                $purpose = $row["section_details_purpose"];
                                $years = $row["section_details_years"];
                                $absence = $row["section_details_absence"];

                                $check_application = "SELECT COUNT(leave_paper_id) AS leavecount FROM leave_paper 
                                    WHERE leave_paper_category = '1' AND leave_paper_users_id = '$users_id' ";
                                $result_count = $conn->query($check_application);
                                $row_count = $result_count->fetch_assoc();
                                $leavecount =  $row_count["leavecount"];


                                $purpose_application = "SELECT COUNT(leave_paper_id) AS purposecount FROM leave_paper 
                                    WHERE leave_paper_category = '2' AND leave_paper_users_id = '$users_id' ";
                                $result_count_purpose = $conn->query($purpose_application);
                                $row_count_purpose = $result_count_purpose->fetch_assoc();
                                $purposecount =  $row_count_purpose["purposecount"];

                                $vacation_application = "SELECT COUNT(leave_paper_id) AS vacationcount FROM leave_paper 
                                    WHERE leave_paper_category = '3' AND leave_paper_users_id = '$users_id' ";
                                $result_count_vacation = $conn->query($vacation_application);
                                $row_count_vacation = $result_count_vacation->fetch_assoc();
                                $vacationcount =  $row_count_vacation["vacationcount"];

                                ?>
                                <tbody>
                                    <tr>
                                        <th scope="row">ลาป่วย</th>
                                        <td><?= $sick ?> วัน</td>
                                        <td><?= $leavecount  ?> วัน</td>
                                        <td><?php
                                            $sum_sick = $sick - $leavecount;
                                            echo $sum_sick; ?> วัน </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ลากิจ</th>
                                        <td><?= $purpose ?> วัน</td>

                                        <td><?= $purposecount ?> วัน</td>
                                        <td><?php
                                            $sum_purpose = $purpose - $purposecount;
                                            echo $sum_purpose; ?> วัน </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ลาพักผ่อนประจำปี</th>
                                        <td><?= $years ?> วัน</td>
                                        <td><?= $vacationcount ?> วัน</td>
                                        <td><?php
                                            $sum_vacation = $years - $vacationcount;
                                            echo $sum_vacation; ?> วัน </td>
                                    </tr>
                                    <th scope="row">ขาดงาน</th>
                                    <td><?= $absence ?> วัน</td>
                                    <td> - วัน</td>
                                    <td> - วัน</td>
                                    </tr>
                                    <th scope="row">รวม</th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>


        </div>


        <?php include('component/users_details_department_modal.php'); ?>



        <?php include("component/mod_menu_footer.php"); ?>
        <?php include('config/scipts-config.php'); ?>


</body>

</html>