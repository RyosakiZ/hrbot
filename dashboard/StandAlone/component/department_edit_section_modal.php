<!-- Modal -->



<div class="modal fade" id="edit_section_<?= $row["section_id"]; ?>" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้ไขชื่อฝ่าย </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <form action="controller/department_edit_section_name.php" method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>ชื่อฝ่าย</h6>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-group">
                                    <?
                                    $section_name = $row["section_name"];
                                    $section_id = $row["section_id"];
                                    // $department_id = $department_id;
                                    ?>
                                    <!-- <input type="text" name="section_name" value="<?= $row["section_name"] ?>" class="form-control"  />   
                                <input type="text" name="section_id" value="<?= $row["section_id"] ?>" class="form-control"  />    -->
                                    <input type="text" name="section_name1" value="<?= $section_name ?>" class="form-control" />
                                    <input type="text" name="section_id1" value="<?= $section_id ?>" class="form-control" />
                                    <input type="text" name="department_id" value="<?= $department_id ?>" class="form-control" />
                                </div>
                            </div>
                        </div>

                    </div>







            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
            </div>

            </form>
        </div>
    </div>
</div>

<!-- <script language="JavaScript" type="text/javascript" src="./assets/js/plugins/jquery/dist/jquery.min.js">
    $(document).off('.datepicker.data-api');
</script> -->
<!-- 
<script>
    $('#btn_submit1').on('click', function(e) {

        e.preventDefault();
        var form = $(this).parent('myFormX');
        swal.fire({

            title: "ยืนยันการทำงานของท่าน?",
            text: "ตรวจสอบให้แน่ใจ การกระทำนี้ไม่สามารถยกเลิกได้!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3d9908",
            confirmButtonText: "ยืนยัน",
            showLoaderOnConfirm: true,
            preConfirm: function(isConfirm) {

                document.forms["myFormX"].submit();



            }
        });
    });

    
</script> -->

<!-- <script>
function myFunction() {
  document.getElementById("sendapi").submit();
}
</script> -->