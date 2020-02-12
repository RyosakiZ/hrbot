<style>
    .swal2-container {
        z-index: 10000;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="add_department" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มแผนก </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="controller/department_add_save.php" id="myForm1" method="post">



                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>ชื่อแผนก</h6>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="department_name" placeholder="" class="form-control" />
                                </div>
                            </div>
                        </div>

                    </div>







            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="submit" id="btn_submit" onsubmit="return validateForm()" class="btn btn-primary">บันทึกข้อมูล</button>
            </div>
            </form>

        </div>
    </div>
</div>

<script language="JavaScript" type="text/javascript" src="./assets/js/plugins/jquery/dist/jquery.min.js">
    $(document).off('.datepicker.data-api');
</script>

<script>
    $('#btn_submit').on('click', function(e) {

        e.preventDefault();
        var form = $(this).parent('myForm1');
        swal.fire({

            title: "ยืนยันการทำงานของท่าน?",
            text: "ตรวจสอบให้แน่ใจ การกระทำนี้ไม่สามารถยกเลิกได้!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3d9908",
            confirmButtonText: "ยืนยัน",
            showLoaderOnConfirm: true,
            preConfirm: () => {

                $.ajax({
                    url: 'controller/department_add_save.php',
                    type: "post",
                    data: $('#myForm1').serialize(),
                    cache: false,
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        console.log(dataResult);

                        if (dataResult.statusCode == 200) {
                            console.log("200");

                            Swal.fire(
                                'สำเร็จ',
                                'ทำการเพิ่มแผนกเรียบร้อย',
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
</script>