<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php"); ?>

<body>
    <?php include("component/mod_menu.php"); ?>


    <?php

    $sql = "SELECT * FROM checkin LEFT JOIN users on users_id = checkin.checkin_users_id 
        LEFT JOIN checkout ON checkin.checkin_users_id = checkout.checkout_users_id
        LEFT JOIN avatar on avatar.avatar_users_id = users.users_id
        WHERE checkin_date = CAST(CURRENT_TIMESTAMP as DATE) AND  checkout_date = CAST(CURRENT_TIMESTAMP as DATE) 
         ";
    $query = mysqli_query($conn, $sql);





    ?>

    <body>


        <!-- Header -->
        <!--บน-->
        <div class="header bg-gradient-primary pb-12 pt-8 pt-md-12">
            <div class="container-fluid mt--7">
                <div class="header-body">

                    <!-- Card stats -->
        <div class="container-fluid mt--4">

            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <h3 class="mb-0">เอกสารรอตรวจสอบ ณ​ ปัจจุบัน <p id="time"></p>
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">


                                    <tr>
                                        <th>ชื่อ</th>
                                        <th scope="col">ประเภท</th>

                                        <th scope="col">วันที่</th>
                                        <th scope="col">ส่งโดย</th>
                                        <th scope="col">รหัสพนักงาน</th>
                                        <th scope="col">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {


                                        ?>
                                            <th scope="row">
                                                <div class="media align-items-center">
                                                    <a href="#">
                                                    <?php  if ( $result["avatar_img"] != NULL ){
                                      echo '<img alt=""    class=" rounded-circle "width="80" height="80" src="./public/fileupload/'.$result["avatar_img"].'">'; 
                                    } else{
                                      echo ' <img alt=""   class=" rounded-circle " width="80" height="80"  src="assets/img/brand/bot.png">';
                                    }
                                    ?> 
                                                    </a>
                                                    <div class="media-body">

                                                    </div>
                                                </div>
                                            </th>
                                            <td>
                                                <?php echo $result["users_fname"]; ?>
                                                <?php echo $result["users_lname"]; ?>
                                            </td>


                                            <td>
                                                <i class="fas fa-calendar text-primary mr-2"></i> <?php echo $result["checkin_date"]; ?>

                                            </td>

                                            <td>
                                                <i class="fas fa-check text-success mr-2"></i> <?php echo $result["checkin_time"]; ?>

                                            </td>

                                            <td>
                                                <i class="fas fa-clock text-warning mr-2"></i> <?php echo $result["checkout_time"]; ?>

                                            </td>

                                            <td>
                                                <a href="Master-detail.php?checkin_id=<?php echo $result["checkin_id"]; ?>">
                                                    <button class="btn btn-icon btn-3 btn-primary" type="button">
                                                        <span class="btn-inner--icon"><i class="fas fa-info"></i></span>

                                                        <span class="btn-inner--text">รายละเอียด</span>

                                                    </button>
                                            </td>
                                    </tr>

                                </tbody>

                            <?php
                                                                                                }
                            ?>
                            </table>
                        </div>
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
                        </div>
                        </div>
                        
                        
            

            <!---- main content ?? --->

        <?php include('config/scipts-config.php'); ?>
        <?php include("component/mod_menu_footer.php"); ?>
        <script>
            var timeDisplay = document.getElementById("time");


            function refreshTime() {
                var dateString = new Date().toLocaleString("th-TH");
                var formattedString = dateString.replace(", ", " - ");
                timeDisplay.innerHTML = formattedString;
            }

            setInterval(refreshTime, 10);

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    "startDate": "10/08/2019",
                    "endDate": "10/12/2019"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('MM-DD-YYYY') + ' to ' + end.format('MM-DD-YYYY') + ' (predefined range: ' + label + ')');
                    document.getElementById('startdate').value = start.format('YYYY-MM-DD');
                    document.getElementById('enddate').value = end.format('YYYY-MM-DD');
                });

            });
        </script>
    </body>

    </html>