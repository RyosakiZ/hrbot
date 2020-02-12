<?php include("middleware/middleware.php"); ?>
<?php include('config/css-headconfig.php'); ?>
<?php include("config/dbconnect.php"); ?>
<?php require_once("config/pagination.php");?>




<body >
  


            <?php include("component/mod_menu.php"); ?>



            <div class="header bg-gradient-primary pb-12 pt-8 pt-md-12">


            </div>

    <div class="container-fluid mt--7">



        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">

                        <form action="controller/broadcast_pushmessage.php" id="form_department" method="POST">
                            <input type="hidden" class="form-control" name="users_id" value="<?php echo $row["users_id"]; ?>">
                            <div>แผนก</div>
                            <select id="sel_depart" name="department" class="form-control">
                                <option value="99">ส่งข้อความไปยังทุกแผนก</option>
                                <?php
                                                                                                // Fetch Department
                                                                                                $sql_department = "SELECT * FROM department  WHERE department_id != '1'";
                                                                                                $department_data = mysqli_query($conn, $sql_department);
                                                                                                while ($row = mysqli_fetch_assoc($department_data)) {
                                                                                                    $departid = $row['department_id'];
                                                                                                    $depart_name = $row['department_name'];

                                                                                                    // Option
                                                                                                    echo "<option value='" . $departid . "' >" . $depart_name . "</option>";
                                                                                                }
                                ?>
                            </select>
                            <div class="clear"></div>

                            <div>ฝ่าย </div>
                            <select id="sel_user" class="form-control" name="section">
                                <option value="0">- Select -</option>
                            </select>

                            <br>
                            <hr>
                            <div>หัวเรื่อง </div>
                            <input type="text" placeholder="หัวข้อ" name="pushmessage_subject" class="form-control" />
                            <br>
                            <div> เนื้อหา </div>
                            <textarea class="form-control form-control-alternative" name="pushmessage_msg" rows="3" placeholder="ข้อความที่ต้องการส่ง"></textarea>

                    </div>



                    <div class="modal-footer">

                        <button type="submit" id="submit_department" onsubmit="return validateForm()" class="btn btn-success">ส่งข้อความ</button>
                    </div>

                </div>
            </div>

        </div>
        </form>






        <!------end ----->
        <!-- Table -->






        <?php include("component/mod_menu_footer.php"); ?>

        <?php include('config/scipts-config.php'); ?>


        <script>
            $('#submit_department').on('click', function(e) {
                e.preventDefault();
                var form = $(this).parent('form_department');

                swal.fire({

                    title: "ยันยันการเปลี่ยนฝ่ายและแผนกงาน?",
                    text: "ตรวจสอบให้แน่ใจ การกระทำนี้ไม่สามารถยกเลิกได้!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#5e72e4",
                    confirmButtonText: "ยืนยัน",
                    showLoaderOnConfirm: true,
                    preConfirm: () => {

                        $.ajax({
                            url: 'controller/broadcast_pushmessage.php',
                            type: "post",
                            data: $('#form_department').serialize(),
                            cache: false,
                            success: function(dataResult) {
                                var dataResult = JSON.stringify(dataResult);
                                console.log(dataResult);

                                if (dataResult) {
                                    console.log("200");

                                    Swal.fire(
                                        'สำเร็จ',
                                        'ส่งข้อความเรียบร้อย',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                        console.log('reload');
                                    });

                                } else if (dataResult.statusCode == 201) {
                                    console.log("201");
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'เกิดบางอย่างผิดพลาด',

                                    }).then(() => {
                                        location.reload();
                                        console.log('reload ');
                                    });
                                }

                            }

                        });
                    }
                });
            });


            $(document).ready(function() {

                $("#sel_depart").change(function() {
                    var deptid = $(this).val();

                    $.ajax({
                        url: 'controller/broadcast_ajax.php',
                        type: 'post',
                        data: {
                            depart: deptid
                        },
                        dataType: 'json',
                        success: function(response) {

                            var len = response.length;

                            $("#sel_user").empty();
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['section_id'];
                                var name = response[i]['section_name'];

                                $("#sel_user").append("<option value='" + id + "'>" + name + "</option>");

                            }
                        }
                    });
                });

            });
        </script>
</body>

</html>