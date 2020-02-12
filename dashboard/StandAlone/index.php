<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php");?>




<body>

      <?php include("component/mod_menu.php"); ?>

     

      <div class="header bg-gradient-primary pb-12 pt-8 pt-md-12">
</div>
        <div class="container-fluid  mt--7">
          <div class="header-body">
         
            <?php


            $countemp = "SELECT COUNT(users_id) AS countEmployee FROM users ";
            $resultcount = $conn->query($countemp);
            $rowcount = $resultcount->fetch_assoc();

            $check_emp_checkin = "SELECT COUNT(checkin_id) AS countCheckinEmp FROM checkin WHERE checkin_date = CAST(CURRENT_TIMESTAMP as DATE) AND `checkin_category` = '1' ";
            $result_check_emp_checkin = $conn->query($check_emp_checkin);
            $row_stat2 = $result_check_emp_checkin->fetch_assoc();

            $check_emp_checkin_yesterday = "SELECT COUNT(checkin_id) AS countCheckinEmp_yesterdays FROM checkin 
            WHERE date(checkin_date)=date(date_sub(now(),interval 1 day)) 
            AND `checkin_category` = '1'";
            $result_check_emp_checkin_yesterday = $conn->query($check_emp_checkin_yesterday);
            $row_stat2_yesterday = $result_check_emp_checkin_yesterday->fetch_assoc();

            $check_emp_out = "SELECT COUNT(checkout_id) AS count_emp_out FROM checkout WHERE checkout_date = CAST(CURRENT_TIMESTAMP as DATE) AND `checkout_category` = '3'";
            $result_check_out = $conn->query($check_emp_out);
            $row_result_check_out = $result_check_out->fetch_assoc();

            $count_leave = "SELECT COUNT(leave_paper_id) AS leave_paper_count FROM leave_paper WHERE leave_paper_start_date = CAST(CURRENT_TIMESTAMP as DATE)";
            $result_leave = $conn->query($count_leave);
            $row_result_leave = $result_leave->fetch_assoc();


            $count_leave_yesterday = "SELECT COUNT(leave_paper_id) AS leave_paper_count_yesterday FROM leave_paper WHERE leave_paper_start_date = CAST(CURRENT_TIMESTAMP as DATE)";
            $result_leave_yesterday = $conn->query($count_leave_yesterday);
            $row_result_leave_yesterday = $result_leave_yesterday->fetch_assoc();
            


            //Method to Query pagination 
            $num = 0;
            $get_leave = " SELECT * , users_fname , users_lname FROM leave_paper 
            LEFT JOIN users on users.users_id = leave_paper.leave_paper_users_id 
            LEFT JOIN avatar on avatar.avatar_users_id = users.users_id
             
             WHERE 1
            ";
            $result = $conn->query($get_leave);
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
            $get_leave .= " ORDER BY leave_paper_id  DESC LIMIT " . $s_page . ",$e_page";
            $result = $conn->query($get_leave);






            $leavetoday = $row_result_leave["leave_paper_count"];
            $leaveyesterday = $row_result_leave_yesterday["leave_paper_count_yesterday"];
            $checkout = $row_result_check_out["count_emp_out"];
            $todaycount = $row_stat2["countCheckinEmp"];
            $yesterdaycount = $row_stat2_yesterday["countCheckinEmp_yesterdays"];
            // $todaycount = 10000;
            // $yesterdaycount = 65000000;

            //print_r($row_stat2);

            ?>

            <!-- Card stats -->
            <div class="row">
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">จำนวนพนักงานทั้งหมด</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $rowcount["countEmployee"]; ?> คน</span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <span class="text-muted mr-2"><i class="fa fa-exchange-alt"></i> 0.00%</span>
                      <span class="text-nowrap">จากเดือนที่แล้ว</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">จำนวนพนักงานที่เข้างานวันนี้</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $row_stat2["countCheckinEmp"]; ?> คน</span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                          <i class="fas fa-check"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <?php


                      if ($yesterdaycount != '0' || $todaycount != '0') {

                        if ($yesterdaycount < $todaycount) {

                          $global_count = @(((abs($yesterdaycount - $todaycount) * 100)) / $yesterdaycount);
                          $emp_enter_count = substr($global_count, 0, strpos($global_count, '.') + 3);
                          
                          echo  " <span class='text-success mr-2'><i class='fas fa-arrow-up'></i> " . $emp_enter_count . " %  </span>";

                      
                        }
                        if ($yesterdaycount > $todaycount) {

                          $global_count = @(((abs($yesterdaycount - $todaycount) * 100)) / $yesterdaycount);
                          $emp_enter_count = substr($global_count, 0, strpos($global_count, '.') + 3);
                          echo " <span class='text-warning mr-2'><i class='fas fa-arrow-down'></i> " . $emp_enter_count . " %  </span>";
                        }
                      } else {
                        echo "ไม่สามารถประมวลผลได้";
                      }
                      ?>
                      <span class="text-nowrap">จากเมื่อวาน</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">จำนวนคนที่ออกงานวันนี้</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $checkout; ?> คน </span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                          <i class="fas fa-clock"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">

                      <?php


                      if ($checkout == '0') {
                        $x = " <span class='text-warning mr-2'><i class='fas fa-arrow-down'></i> ยังไม่มีพนักงานของท่านออกจากงานในเวลานี้ค่ะ  </span>";

                        echo $x;
                      } else if ($checkout == $todaycount) {
                        $x = " <span class='text-success mr-2'><i class='fas fa-arrow-up'></i> วันนี้พนักงานของท่านออกงานครบทุกท่านแล้วค่ะ </span>";

                        echo $x;
                      } else {
                        $x = " <span class='text-success mr-2'><i class='fas fa-arrow-up'></i>ขณะนี้พนักงานของท่านได้ออกงานบางส่วนแล้วค่ะ</span>";

                        echo $x;
                      }

                      ?>

                      </span>
                      <!-- <span class="text-nowrap">จากเมื่อวาน</span> -->
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">จำนวนคนขอลาวันนี้</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $row_result_leave["leave_paper_count"] ?> คน </span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                          <i class="fas fa-bed"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <span class="text-success mr-2">
                        <?php


                        if ($leavetoday != '0' || $leaveyesterday != '0') {

                          if ($leaveyesterday < $leavetoday) {

                            $global_count = (((abs($leaveyesterday - $leavetoday) * 100)) / $leaveyesterday);
                            $emp_leave_count = substr($global_count, 0, strpos($global_count, '.') + 3);
                            echo " <span class='text-success mr-2'>  " . $emp_leave_count . " %  </span>   ";
                            echo " <span class='text-nowrap'>จากเมื่อวาน</span>";
                          }
                          if ($leaveyesterday > $leavetoday) {

                            $global_count = (((abs($leaveyesterday - $leavetoday) * 100)) / $leaveyesterday);
                            $emp_leave_count = substr($global_count, 0, strpos($global_count, '.') + 3);
                            echo " <span class='text-warning mr-2'> " . $emp_leave_count . " %  </span>";
                            echo " <span class='text-nowrap'>จากเมื่อวาน</span>";
                          }
                        } else {
                          echo " <span class='text-info mr-2'> ไม่มีการลาเมื่อวานและวันนี้   </span>";
                        }
                        ?>

                      </span>

                    </p>
                  </div>
                </div>
              </div>
              
            </div>


            <!------ CARD -------->

            <!-- Table -->
            <br>
            <div class="row">
              <div class="col">
                <div class="card shadow">
                  <div class="card-header border-0">
                    <h3 class="mb-0"> คำร้องขออนุมัติ</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">โปรไฟล์</th>
                          <th scope="col">ชื่อ</th>
                          <th scope="col">ประเภท</th>
                          <th scope="col">สาเหตุ</th>
                          <th scope="col">สถานะ</th>
                          <th scope="col">วันที่</th>
                          <th scope="col">ติดตาม</th>
                          
                          
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
                                  <a href="#">
                                    <?php  if ( $row["avatar_img"] != NULL ){
                                      echo '<img alt=""  class="rounded-circle" width="60" height="60" src="./public/fileupload/'.$row["avatar_img"].'">'; 
                                    } else{
                                      echo ' <img alt=""  class="rounded-circle" width="60" height="60"  src="assets/img/brand/bot.png">';
                                    }
                                    ?> 
                                   
                                  </a>
                                  <div class="media-body">
                                    
                                  </div>
                                </div>
                              </th>
                              <td>
                                <?=$row["users_fname"]."   ".$row["users_lname"]; ?>
                              </td>
                              <td>
                              <?php 

                              $typeofpaper = $row["leave_paper_category"]; 
                              
                                  if($typeofpaper == '1'){
                                    $global = '<span class="badge badge-pill badge-warning">ลาป่วย</span>';
                                  }else if($typeofpaper== '2'){
                                    $global = '<span class="badge badge-pill badge-info">ลากิจ</span>';
                                  }else {
                                    $global = '<span class="badge badge-pill badge-default">ลาประเภทอื่นๆ</span>';
                                  }

                                  echo $global;
                              
                              ?>
                              </td>
                              <td>
                                <?=$row["leave_paper_reason"]; ?>
                          </td>
                              <td>
                                <?php 
                                
                                if($row["leave_paper_confirm"] == '0'){
                                  echo '<span class="badge badge-dot mr-4">
                                  <i class="bg-info"></i> ยังไม่ได้รับการอนุมัติ
                                </span>';
                                }
                                if($row["leave_paper_confirm"] == '1'){
                                  echo '<span class="badge badge-dot mr-4">
                                  <i class="bg-danger"></i>ไม่ได้รับการอนุมัติ
                                </span>';
                                }
                                if($row["leave_paper_confirm"] == '2'){
                                  echo '<span class="badge badge-dot mr-4">
                                  <i class="bg-success"></i> ได้รับการอนุมัติ
                                </span>';
                                }
                                
                                ?>
                                <!-- <span class="badge badge-dot mr-4">
                                  <i class="bg-warning"></i> ยังไม่ได้รับการอนุมัติ
                                </span> -->
                              </td>
                              <td>
                                <div class="avatar-group">
                                  <?php 
                                  $originalDate1 =  $row["leave_paper_created"];
                                  $newDate1 = date("d-m-Y", strtotime($originalDate1));
                                  echo $newDate1;
                                  ?>
                                  </a>
                                 
                                </div>
                              </td>
                             
                              <td >
                              <a href="../../liff_app/confirm_leave/index.php?users_id=<?= $row['users_id']?>&leave_paper_id=<?= $row['leave_paper_id']?>" class="btn btn-default">ตรวจสอบ</a>
                            
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
                    page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
                    ?>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>


          <!-----END CARD ------->

          <!------- MAP -------->
          <style>
            #map_canvas {
              overflow: hidden;
              padding-bottom: 50%;
              position: relative;
              height: 0;
            }
          </style>

          <br>

          <div id="map_canvas"></div>

          <!---- main content ?? --->

        </div>
   
      <?php include("component/mod_menu_footer.php"); ?>

    </div>
    <?php include('config/scipts-config.php'); ?>


    <!--- map google --->
    <script>
      function initMap() {
        var mapOption = {
          center: {
            lat: 13.847860,
            lng: 100.604274
          },
          zoom: 10,
        }
        let maps = new google.maps.Map(document.getElementById("map_canvas"), mapOption);
        let marker, info;
        $.getJSON("controller/index_mapcontroller.php", function(jsonObj) {
          $.each(jsonObj, function(i, item) {
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(item.checkin_lat, item.checkin_long),
              map: maps,

            });
            info = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                info.setContent(item.users_fname + " " + item.users_lname + " \n " + "เข้างานเวลา" + item.checkin_time);
                info.open(maps, marker);
              }
            })(marker, i));
          });
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALSzf_EiskJSQXKSkvGdA4CTwrZ-3MSEI&callback=initMap" async defer></script>
</body>

</html>