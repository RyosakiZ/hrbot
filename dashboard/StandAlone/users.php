<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php");?>

<body >
<?php include("component/mod_menu.php"); ?>
<?php include('component/users_modal.php'); ?>

      <?php


      //Method to Query pagination 
      $num = 0;
      $sql= " SELECT * FROM users  LEFT JOIN department on users.users_department = department.department_id 
      LEFT JOIN section on section.section_department_id = department_id 
      LEFT JOIN avatar on avatar.avatar_users_id = users.users_id
      WHERE 1 AND users_section = section_id
      ";
      //////////////////// MORE QUERY 
      // เงื่อนไขสำหรับ input text
      if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
        // ต่อคำสั่ง sql 
        $sql.= " AND users_emp_id  LIKE '%" . trim($_GET['keyword']) . "%' ";
      }

      // เงื่อนไขสำหรับ select
      if (isset($_GET['myselect']) && $_GET['myselect'] != "") {
        // ต่อคำสั่ง sql 
        $sql.= " AND users_department LIKE '" . trim($_GET['myselect']) . "%' ";
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
      $sql.= " ORDER BY users_id  DESC LIMIT " . $s_page . ",$e_page";
      $result = $conn->query($sql);


      $sqllist = "SELECT * FROM department ORDER BY department_id";
      $get = $conn->query($sqllist);
      ?>


      <!-- Header -->
      <!--บน-->
      <div class="header bg-gradient-primary pb-12 pt-8 pt-md-12">
      

      </div>
  </nav>
  <div class="container-fluid mt--7">

 


    <div class="row">
      
      <div class="col">
        <div class="card shadow">
          <div class="card-header border-0">
            
            <div class="row">
  <div class="col-8"><h3 class="mb-0">ข้อมูลพนักงาน</h3></div>
  <div class="col-4">   <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_employee">เพิ่มพนักงาน</button> </div>
</div>
<br>

            
            <form name="form1" method="get" action="">
              <div class="form-group row">
                <label for="keyword" class="col-sm-6 col-form-label text-left">
                  ค้นหารหัสพนักงาน
                </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="keyword" id="keyword" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : "" ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="myselect" class="col-sm-6 col-form-label text-left">
                  ค้นหาเฉพาะแผนก
                </label>
                <div class="col-sm-6">
                  <select class="form-control" name="myselect" id="myselect">
                    <option value="">เลือกแผนก</option>
                    <?php 
                      while($row_get = $get->fetch_assoc()) {
                        ?>
                         <option value="<?php echo $row_get["department_id"] ?>" <?= (isset($_GET['myselect']) && $_GET['myselect'] == "") ? " selected" : "" ?>><?= $row_get["department_name"]; ?></option>
                    
                        <?php
                      }


                    ?>

                  </select>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-3 offset-sm-9">
                  <button type="submit" class="btn btn-primary" name="btn_search" id="btn_search">ค้นหา</button>
                  &nbsp;&nbsp;
                  <a href="users.php" class="btn btn-danger">ล้างค่า</a>
    
                </div>
              </div>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col">โปรไฟล์</th>
                  <th scope="col">ชื่อ</th>
                  <th scope="col">รหัสประชาชน</th>
                  <th scope="col">รหัสพนักงาน</th>
                  <th scope="col">แผนก</th>
                  <th scope="col">สถานะ</th>
                
                  <th scope="col">ติดตาม</th>
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
                          <a href="#" >
                          <?php  if ( $row["avatar_img"] != NULL ){
                                      echo '<img alt=""  class="rounded-circle" width="60" height="60" src="./public/fileupload/'.$row["avatar_img"].'">'; 
                                    } else{
                                      echo ' <img alt=""   class="rounded-circle" width="60" height="60" src="assets/img/brand/bot.png">';
                                    }
                                    ?> 
                          </a>
                          <div class="media-body">

                          </div>
                        </div>
                      </th>
                      <td>
                        <?= $row["users_fname"] . "   " . $row["users_lname"]; ?>
                      </td>
                      <td>
                        <?=  $row["users_citizenid"];
                            ?>
                      </td>
                      <td>
                        <?=  $row["users_emp_id"];
                            ?>
                      </td>
                      <td>
                        <?= $row["section_name"]; ?>
                      </td>
                      <td>
                         
                      <?php if ($row["users_active"] == '0') {
                                            echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-warning"></i> ยังไม่มีข้อมูลพนักงาน
                            </span> ';
                                        }
                                        if ($row["users_active"] == '1') {
                                            echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-success"></i> มีสถานะพนักงาน
                            </span> ';
                                        } if ($row["users_active"] == '2') {
                                            echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-primary"></i> พักงาน
                            </span> ';
                                        } if ($row["users_active"] == '3') {
                                            echo '<span class="badge badge-dot mr-3"> 
                            <i class="bg-danger"></i> หมดสถานะพนักงาน
                            </span> ';
                                        }
                            ?>
                          
                      </td>
                   

                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" 
                            href="users_details.php?users_id=<?php echo $row["users_id"];?>">
                            ตรวจสอบและแก้ไขรายละเอียด
                            </a>

                          
                            <a class="dropdown-item" 
                            href="users_sendmessage.php?users_id=<?php echo $row["users_id"];?>">
                            ส่งข้อความ
                            </a>
                            <a class="dropdown-item" href="#">อนุมัติเอกสาร</a>
                          </div>
                        </div>
                      </td>

                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>

          
        </div>
        <div class="card-footer py-4">
          <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0">
              <?php
             page_navi($total,(isset($_GET['page']))?$_GET['page']:1,$e_page,$_GET);
              ?>
            </ul>
          </nav>
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