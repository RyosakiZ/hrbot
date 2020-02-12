<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php"); ?>

<body>
    <?php include("component/mod_menu.php"); ?>

            <?php

            $department_id = $_GET['department_id'];


            //Method to Query pagination 
            $num = 0;
            $sql = " SELECT * FROM section WHERE section_department_id = '$department_id'
";
            //////////////////// MORE QUERY 
            // เงื่อนไขสำหรับ input text
            if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
                // ต่อคำสั่ง sql 
                $sql .= " AND department LIKE '%" . trim($_GET['keyword']) . "%' ";
            }

            // เงื่อนไขสำหรับ select
            if (isset($_GET['myselect']) && $_GET['myselect'] != "") {
                // ต่อคำสั่ง sql 
                $sql .= " AND department LIKE '" . trim($_GET['myselect']) . "%' ";
            }


            //////////////////// MORE QUERY 
            $result = $conn->query($sql);
            $total = $result->num_rows;
            $e_page = 5; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
            $step_num = 0;
            if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                $_GET['page'] = 1;
                $step_num = 0;
                $s_page = 0;
            } else {
                $s_page = $_GET['page'] - 1;
                $step_num = $_GET['page'] - 1;
                $s_page = $s_page * $e_page;
            }
            $sql .= " ORDER BY section_id  ASC LIMIT " . $s_page . ",$e_page";
            $result = $conn->query($sql);


            $sqllist = "SELECT * FROM section ORDER BY section_id";
            $get = $conn->query($sqllist);
            ?>


            <!-- Header -->
            <!--บน-->
            <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">


            </div>
    </nav>
    
    <div class="container-fluid mt--7">



        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">

                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="mb-0">รายละเอียดบุคคล</h3>
                            </div>
                            <div class="col-sm-2"><button type="button" class="btn btn-success btn-lg btn-block"  data-toggle="modal" data-target="#add_section" >เพิ่มพนักงาน</button></div>
                            <?php include('component/department_add_section_modal.php'); ?>
                            <div class="col-sm-2"><button type="button" class="btn btn-danger btn-lg btn-block"  data-toggle="modal" data-target="del_section" >ลบพนักงาน</button></div>
                            <?php //include('component/department_del_modal.php'); ?>
                        </div>
                        <form name="form1" method="get" action="">
                            <div class="form-group row">
                                <label for="keyword" class="col-sm-6 col-form-label text-left">

                                </label>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">โปรไฟล์</th>
                                                <th scope="col">ชื่อแผนก</th>

                                                <th scope="col">มีพนักงานทั้งหมด</th>
                                                <th scope="col"></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                                while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ
                                                    $num++;

                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="media align-items-center">
                                                                <a href="#" class="avatar rounded-circle mr-3">
                                                                    <img alt="" src="./assets/img/brand/bot.png">
                                                                </a>
                                                                <div class="media-body">

                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td>
                                                            <?= $row["section_name"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                    $section_id = $row["section_id"];
                                                                    $sqlcount = "SELECT COUNT(users_id) AS mycount FROM users WHERE users_section ='$section_id' ";
                                                                    $get_count = $conn->query($sqlcount);
                                                                    $row_count = $get_count->fetch_assoc();
                                                                    echo $row_count['mycount'];
                                                                    ?>
                                                            คน
                                                        </td>
                                                        <?php include('component/department_edit_section_modal.php'); ?>
                                                        <td class="text-right">
                                                        <!-- <button type="button" class="btn btn-info">ส่งข้อความฝ่าย</button> -->
                                                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#edit_section_<?=$row["section_id"]; ?>">แก้ไขชื่อฝ่าย</button>
                                                        <a href="department_details.php?department_id=<?= $row['department_id']?>" class="btn btn-default">รายละเอียดฝ่าย</a>

                                                      

                                                        <!-- <a href="department_details.php?department_id=<?= $row['department_id']?>" class="btn btn-warning">ตรวจสอบและแก้ไขเวลาหยุดงาน</a> -->
                                                        </td>

                                                    </tr>

                                                   
                                            <?php
                                            
                                                }
                                               
                                            }
                                            ?>

                                            
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                     
                            <div class="card-footer py-4">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-end mb-0">
                                        <?php
                                        page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET);
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                    </div>
                </div>
            </div>





        </div>





        <!------end ----->
        <!-- Table -->

        <!---- main content ?? --->




        <?php include("component/mod_menu_footer.php"); ?>
        <?php include('config/scipts-config.php'); ?>
</body>

</html>