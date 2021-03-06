<!DOCTYPE html>

<html>

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>บันทึกการเข้างาน</title>

  <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>

  <script src="lib/jquery-3.3.1.min.js"></script>

  <script src="lib/bootstrap.min.js"></script>

  <link href="lib/bootstrap.min.css" rel="stylesheet" />


  <script src="mobile-detect.js-master/mobile-detect.js"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>

  <script>
    //init LIFF

    function initializeApp(data) {

      let urlParams = new URLSearchParams(window.location.search);

      $('#name').val(urlParams.toString());

      $('#userid').val(data.context.userId);


      let uid_var = data.context.userId;
      document.cookie = "myUid = " + uid_var;

      // $('#statusMessage').val(data.context.statusMessage);

      liff.getProfile()
        .then(profile => {
          const name = profile.displayName
          const statusMessage = profile.statusMessage
          const picdisplay = profile.pictureUrl





          $('#displayName').val(profile.displayName);
          $('#pictureUrl').val(profile.pictureUrl);
          $('#statusMessage').val(profile.statusMessage);

          var inputVal = document.getElementById("pictureUrl").value;
          document.getElementById("myImg").src = inputVal;

        })



    }


    //ready

    $(function() {

      //init LIFF

      liff.init(function(data) {

        initializeApp(data);

      });

      //ButtonGetProfile

      $('#ButtonGetProfile').click(function() {

        liff.getProfile().then(

          profile => {

            $('#displayName').val(profile.displayName);

            alert('done');

          }

        );

      });

      //ButtonSendMsg #QueryString

      $('#ButtonSendMsg').click(function() {

        liff.sendMessages([

            {

              type: 'text',

              // text: $(‘#userid’).val() + $(‘#QueryString’).val() + $(‘#msg’).val()
              text: $('คุณเคยลงทะเบียนแล้ว').val()

            }

          ])

          .then(() => {

            alert('done');

          })

      });

    });
  </script>

  <?php

  // @@AESC PUBLIC 
  // @@DESC -- CHECK IS checkin or out 
  // @@route -- SAVE.php
  include("../../dashboard/StandAlone/config/dbconnect.php");
  $myuid = $_COOKIE['myUid'];
  // echo "TEST" . $myuid; 

  //Query Name
  $checkuid_query = "SELECT * FROM users WHERE users_uid = '$myuid' ";
  $result = $conn->query($checkuid_query);
  $row = $result->fetch_assoc();

  //Query Checking 

  $countemp = "SELECT COUNT(checkin_id) AS countCheckin FROM checkin WHERE checkin_users_uid= '$myuid' AND checkin_date = CAST(CURRENT_TIMESTAMP as DATE) ";
  $resultcount = $conn->query($countemp);
  $rowcount = $resultcount->fetch_assoc();
  $total = $rowcount["countCheckin"];

  $countCheckout = "SELECT COUNT(checkout_id) AS countCheckout FROM checkout WHERE checkout_users_uid= '$myuid' 
  AND checkout_category = '3'
  AND checkout_date = CAST(CURRENT_TIMESTAMP as DATE) ";
  $resultcountout = $conn->query($countCheckout);
  $rowcountout = $resultcountout->fetch_array();
  $totalout = $rowcountout["countCheckout"];

  ?>

</head>

<body>




  <form action="save.php" method="get" class="login-form" id="myForm">

    <div class="login-page">
      <div class="form">


        <p>บันทักการเข้างาน</p>
        <p id="time"></p>
        <p> สวัสดีค่ะ คุณ <?php echo $row["users_fname"] . "    " . $row["users_lname"]; ?></p>


        <div class="container-fluid">
          <!-- Control the column width, and how they should appear on different devices -->
          <div class="row">
            <div class="col-sm-4"> <img id="myImg" src="" width="100" height="100" class="circular--square"></div> <br>
            <div class="col-sm-8">



              <div class="form-group purple-border">

                <textarea name="status" class="form-control" placeholder="เขียนทักทายเพื่อนร่วมงาน หรือ เขียนอะไรที่นี่ ..." rows="2"></textarea>
              </div>

            </div>
            <select name="type" class="form-control form-control-lg">
              <option value="1"> อยู่ออฟฟิศ</option>
              <option value="2"> ทำงานที่บ้าน</option>
              <option value="3"> ประชุมนอกสถานที่</option>
              <option value="4"> ออก siteงาน </option>
              <option value="5"> ทาน อาหาร</option>
              <option value="6"> อื่นๆ</option>
            </select>

            <br>
            <div class="container">
              <div class="row">
                <div class="btn-group btn-group-justified" data-toggle="buttons">

                  <?php

                  if ($totalout == '0') {


                    if ($total == '0') {

                      echo '<label class="btn btn-success active">
                  <input type="radio" name="category" id="option1" value="1" autocomplete="off" checked> เข้างาน
                </label>';
                    } else if ($total >= '1') {
                      echo ' <label class="btn btn-primary">
                  <input type="radio" name="category" id="option2" value="2" autocomplete="off"> ON SITE
                </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="category" id="option3" value="3" autocomplete="off"> ออกงาน
                  </label>';
                    } else {
                      echo "คุณไม่ได้เป็นพนักงาน";
                    }
                  } else {

                    echo "คุณได้ทำการออกงานไปแล้วค่ะ ไว้กลับมาทำงานอีกพรุ้งนี้นะคะ";
                  }
                  ?>

                </div>
              </div>
            </div>


            <br>
            <div id="map"></div>

            <br>


            <input id="userid" name="userid" type="hidden">
            <input id="ip" name="ip" type="hidden">
            <input id="lat" name="lat" type="hidden">
            <input id="long" name="long" type="hidden">
            <input id="mobile" name="mobile" type="hidden">
            <input id="phone" name="phone" type="hidden">
            <input id="tablet" name="tablet" type="hidden">
            <input id="userAgent" name="userAgent" type="hidden">
            <input id="os" name="os" type="hidden">
            <input id="iPhone" name="iPhone" type="hidden">
            <input id="bot" name="bot" type="hidden">
            <input id="Webkit" name="Webkit" type="hidden">
            <input id="Build" name="Build" type="hidden">

            <body onload='getLocation();'>
              <!--     
            insert pic -->
              <input class="form-control" type="hidden" id="pictureUrl" name="pictureUrl" />

                  
                
              <button type="submit" id="btn_submit" onsubmit="return validateForm()">ยืนยัน</button>
              <p class="message">หากมีปัญหาในการใช้งานกรุณาติดต่อเจ้าหน้าที่</p>
  </form>
  </div>
  </div>



  <script>
    $.getJSON("https://api.ipify.org/?format=json", function(e) {
      console.log(e.ip);

      document.getElementById('ip').value = e.ip;
    });


    var md = new MobileDetect(window.navigator.userAgent);

    // more typically we would instantiate with 'window.navigator.userAgent'
    // as user-agent; this string literal is only for better understanding

    console.log(md.mobile()); // 'Sony'
    console.log(md.phone()); // 'Sony'
    console.log(md.tablet()); // null
    console.log(md.userAgent()); // 'Safari'
    console.log(md.os()); // 'AndroidOS'
    console.log(md.is('iPhone')); // false
    console.log(md.is('bot')); // false
    console.log(md.version('Webkit')); // 534.3
    console.log(md.versionStr('Build')); // '4.1.A.0.562'

    document.getElementById('mobile').value = md.mobile();
    document.getElementById('phone').value = md.phone();
    document.getElementById('tablet').value = md.tablet();
    document.getElementById('userAgent').value = md.userAgent();
    document.getElementById('os').value = md.os();
    document.getElementById('iPhone').value = md.is('iPhone');
    document.getElementById('bot').value = md.is('bot');
    document.getElementById('Webkit').value = md.version('Webkit');
    document.getElementById('Build').value = md.versionStr('Build');
  </script>



</body>
<style>
  .slidecontainer {
    width: 100%;
    /* Width of the outside container */
  }

  /* The slider itself */
  .slider {
    -webkit-appearance: none;
    /* Override default CSS styles */
    appearance: none;
    width: 100%;
    /* Full-width */
    height: 25px;
    /* Specified height */
    background: #d3d3d3;
    /* Grey background */
    outline: none;
    /* Remove outline */
    opacity: 0.7;
    /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s;
    /* 0.2 seconds transition on hover */
    transition: opacity .2s;
  }

  /* Mouse-over effects */
  .slider:hover {
    opacity: 1;
    /* Fully shown on mouse-over */
  }

  /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
  .slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    /* Override default look */
    appearance: none;
    width: 25px;
    /* Set a specific slider handle width */
    height: 25px;
    /* Slider handle height */
    background: #4CAF50;
    /* Green background */
    cursor: pointer;
    /* Cursor on hover */
  }

  .slider::-moz-range-thumb {
    width: 25px;
    /* Set a specific slider handle width */
    height: 25px;
    /* Slider handle height */
    background: #4CAF50;
    /* Green background */
    cursor: pointer;
    /* Cursor on hover */
  }

  @import url(https://fonts.googleapis.com/css?family=Roboto:300);

  .login-page {
    width: 360px;
    padding: 8% 0 0;
    margin: auto;
  }

  .form {
    position: relative;
    z-index: 1;
    background: #FFFFFF;
    max-width: 360px;
    margin: 0 auto 100px;
    padding: 45px;
    text-align: center;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
  }

  .form input {
    font-family: "Roboto", sans-serif;
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
  }

  .form button {
    font-family: "Roboto", sans-serif;
    text-transform: uppercase;
    outline: 0;
    background: #4CAF50;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
  }

  .form button:hover,
  .form button:active,
  .form button:focus {
    background: #43A047;
  }

  .form .message {
    margin: 15px 0 0;
    color: #b3b3b3;
    font-size: 12px;
  }

  .form .message a {
    color: #4CAF50;
    text-decoration: none;
  }

  .form .register-form {
    display: none;
  }

  .container {
    position: relative;
    z-index: 1;
    max-width: 300px;
    margin: 0 auto;
  }

  .container:before,
  .container:after {
    content: "";
    display: block;
    clear: both;
  }

  .container .info {
    margin: 50px auto;
    text-align: center;
  }

  .container .info h1 {
    margin: 0 0 15px;
    padding: 0;
    font-size: 36px;
    font-weight: 300;
    color: #1a1a1a;
  }

  .container .info span {
    color: #4d4d4d;
    font-size: 12px;
  }

  .container .info span a {
    color: #000000;
    text-decoration: none;
  }

  .container .info span .fa {
    color: #EF3B3A;
  }

  body {
    background: #76b852;
    /* fallback for old browsers */
    background: -webkit-linear-gradient(right, #76b852, #8DC26F);
    background: -moz-linear-gradient(right, #76b852, #8DC26F);
    background: -o-linear-gradient(right, #76b852, #8DC26F);
    background: linear-gradient(to left, #76b852, #8DC26F);
    font-family: "Roboto", sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .circular--square {
    border-radius: 50%;
  }

  /* css กำหนดความกว้าง ความสูงของแผนที่ */
  #map {
    height: 150px;
    width: 260px;
  }

  .switch-field {
    display: flex;
    margin-bottom: 36px;
    overflow: hidden;
  }
</style>




<script>
  var timeDisplay = document.getElementById("time");


  function refreshTime() {
    var dateString = new Date().toLocaleString("th-TH");
    var formattedString = dateString.replace(", ", " - ");
    timeDisplay.innerHTML = formattedString;
  }

  setInterval(refreshTime, 10);


  function initMap() {
    var mapOptions = {
      center: {
        lat: 13.847860,
        lng: 100.604274
      },
      zoom: 17,
      draggable: false,
      disableDefaultUI: true,
      clickableIcons: false
    }

    var maps = new google.maps.Map(document.getElementById("map"), mapOptions);

    infoWindow = new google.maps.InfoWindow;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {

        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('คุณมาทำงานทีนี่  !. lat: ' + position.coords.latitude + ', lng: ' + position.coords.longitude + ' ');
        infoWindow.open(maps);
        map.setCenter(pos);
      }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }

  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }


  $(".toggle").change(function() {
    if ($(this).is(":checked")) {
      $('[id^="toggle"]').not(this).each(function() {
        $(this).bootstrapToggle('off');
      });
    }
  });


  var x = document.getElementById("getlocation");

  function getLocation()

  {

    navigator.geolocation.getCurrentPosition(function(position) {
      var coordinates = position.coords;
      document.getElementById('lat').value = coordinates.latitude;
      document.getElementById('long').value = coordinates.longitude;
    });
  }


  function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude +
      "<br>Longitude: " + position.coords.longitude;
  }



  $('#btn_submit').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parent('myForm');
    swal.fire({
      title: "ยืนยันการทำงานของท่าน?",
      text: "ตรวจสอบให้แน่ใจ การกระทำนี้ไม่สามารถยกเลิกได้!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3d9908",
      confirmButtonText: "confirm",
      showLoaderOnConfirm: true,
      preConfirm: function(isConfirm) {

        document.forms["myForm"].submit();



      }
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/mobile-detect@1.4.4/mobile-detect.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALSzf_EiskJSQXKSkvGdA4CTwrZ-3MSEI&callback=initMap" async defer></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>