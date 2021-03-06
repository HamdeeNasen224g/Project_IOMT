<!--
=========================================================
* * Black Dashboard - v1.0.1
=========================================================
* Product Page: https://www.creative-tim.com/product/black-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Coded by Creative Tim
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php include 'db_con.php'; ?>
<?php include 'pulldatafromdatabase.php'; ?>
<?php include 'querydatadanger.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">
  <link rel="icon" type="image/png" href="../img/favicon.png">
  <title>
    Dashboard WUH
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../demo/demo.css" rel="stylesheet" />
</head>
<body class="">
  <div class="wrapper">
    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-mini">
            WUH
          </a>
          <a href="javascript:void(0)" class="simple-text logo-normal" >
            Hospital
          </a>
        </div>
        <ul class="nav">
          <li class="active ">
            <a href="./index.php">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="./map.php">
              <i class="tim-icons icon-pin"></i>
              <p>Maps</p>
            </a>
          </li>
          <li>
            <a href="./patient.php">
              <i class="tim-icons icon-single-02"></i>
              <p>Patient Profile</p>
            </a>
          </li>
          <li>
            <a target="_blank" href="https://docs.google.com/spreadsheets/d/1QfE0M5o-lNz7Lr5RkEaPbEzHpKQ4ZbS1MFhXOa2PLgM/edit?fbclid=IwAR37HzzQ8jFZPjCj25Iz8q90r9-d-vwCQdCj1GdiaGYElNDpJE3ctiuxmFw#gid=0">
              <i class="tim-icons icon-notes"></i>
              <p>Google Sheet</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
                
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="search-bar input-group">
                <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split" ></i>
                  <span class="d-lg-none d-md-block">Search</span>
                </button>
              </li>
              <li class="dropdown nav-item">
                <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="notification d-none d-lg-block d-xl-block"></div>
                  <i class="tim-icons icon-bell-55"></i>
                  <p class="d-lg-none">
                    Notifications
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                  <li class="nav-link"><a href="#" class="nav-item dropdown-item">Mike John responded to your email</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">You have 5 more tasks</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Your friend Michael is in town</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Another notification</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Another one</a></li>
                </ul>
              </li>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="../img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Profile</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Settings</a></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Log out</a></li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-chart">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h4 class="card-category">Status Patient</h4>
                    <br><h2 class="card-title">Notification Center</h2></br>
                    <div class="row">
                    <div class="col-sm-4">
                    <div class="card card-chart">
                      <div class="card-header">
                      <div class="col 6"></div>
                        <h5 class="card-category text-success">Status BPM</h5>
                        <h3 class="card-title text-center"><span class="text-danger" id="statusbpm1"></span><span class="text-white" id="statusbpm"></span></h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="card card-chart">
                      <div class="card-header">
                        <h5 class="card-category text-info">Status SPO2</h5>
                        <h3 class="card-title text-center"><span class="text-danger" id="statusspo21"></span><span class="text-white" id="statusspo2"></span></h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="card card-chart">
                      <div class="card-header">
                        <h5 class="card-category text-primary">Status Temper</h5>
                        <h3 class="card-title text-center"><span class="text-danger" id="statustemp1"></span><span class="text-white" id="statustemp"></span></h3>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                  <div class="col-sm-6 text-left">
                    <div class="btn-group btn-group-toggle float-right" >
                      <label class="btn btn-sm btn-primary btn-simple active">
                        <input type="radio" name="options" checked>
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block" >HN <?php echo $hid;?></span>
                        <span class="d-block d-sm-none">
                          <i class="tim-icons icon-single-02"></i>
                        </a>
                        </span>
                      </label>
                      <a href="patient.php" class="btn btn-sm btn-primary btn-simple">
                        <input type="radio" class="d-none d-sm-none" name="options">
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block"><?php echo $p_Fname." ".$p_Lname;?></span>
                        <span class="d-block d-sm-none"></span>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <div class="card-body text-left">
          <div class="chart-area" style="overflow-x:auto; ">
          <table class="table">  
            <thead>
              <h4 class="text-left"> History of Data Danger</h4>
                  <tr>
                    <th>Time Stamp</th>
                    <th>BPM</th>
                    <th>SPO2</th>
                    <th>Temperature</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  for($i=0; $i<count($alertdata);$i++){

                  ?> 
                  <tr>
                    <td> <?php echo $alertdata[$i][0];?></td>
                    <td><?php echo $alertdata[$i][1];?></td>
                    <td><?php echo $alertdata[$i][2];?></td>
                    <td><?php echo $alertdata[$i][3];?></td>
                  </tr>

                <?php }?>  
            </tbody>
          </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <div class="col 6"></div>
                <h5 class="card-category">Total BPM</h5>
                <h3 class="card-title"><i class="tim-icons icon-heart-2 text-success"></i> BPM : <span id ="bpm"></span></h3>
              </div>
              <div class="card-body">
              <div class="chart-area">
                  <canvas id="myChart1"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Total SPO2</h5>
                <h3 class="card-title"><i class="tim-icons icon-sound-wave text-info"></i> SPO2 : <span id ="spo2"></h3>
              </div>
              <div class="card-body">
              <div class="chart-area">
                  <canvas id="myChart2"></canvas>
              </div>
            </div>
          </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Total Temperature</h5>
                <h3 class="card-title"><i class="tim-icons icon-chart-pie-36 text-primary"></i> TEMP : <span id ="temp"></h3>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="myChart3"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
  <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Background</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger background-color">
            <div class="badge-colors text-center">
              <span class="badge filter badge-primary active" data-color="primary"></span>
              <span class="badge filter badge-info" data-color="blue"></span>
              <span class="badge filter badge-success" data-color="green"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="adjustments-line text-center color-change">
          <span class="color-label">LIGHT MODE</span>
          <span class="badge light-badge mr-2"></span>
          <span class="badge dark-badge ml-2"></span>
          <span class="color-label">DARK MODE</span>
        </li>
      </ul>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../js/core/jquery.min.js"></script>
  <script src="../js/core/popper.min.js"></script>
  <script src="../js/core/bootstrap.min.js"></script>
  <script src="../js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');
        $full_page = $('.full-page');
        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;
        window_width = $(window).width();
        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });
        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');
          var new_color = $(this).data('color');
          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }
          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }
          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }
          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });
        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);
          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }
          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);
          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });
        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);
          if (white_color == true) {
            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {
            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);
            white_color = true;
          }
        });
        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });
        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();
    });
  </script>

<script>
     
     function showChart1(data,xlabel,id,label){      
       var ctx = document.getElementById(id).getContext('2d');
       var myChart = new Chart (ctx, {
           type: 'line',
           data: {
               labels: xlabel,
               datasets: [{
                   label: label,
                   data: data,
                   fill: false,
                   borderColor: 'rgb(0, 204, 102)',
               }]
           }
   
       });
     }
     function showChart2(data,xlabel,id,label){      
       var ctx = document.getElementById(id).getContext('2d');
       var myChart = new Chart (ctx, {
           type: 'line',
           data: {
               labels: xlabel,
               datasets: [{
                   label: label,
                   data: data,
                   fill: false,
                   borderColor: 'rgb(0, 255, 255)',
               }]
           }
   
       });
     }

     function showChart3(data,xlabel,id,label){      
       var ctx = document.getElementById(id).getContext('2d');
       var myChart = new Chart (ctx, {
           type: 'line',
           data: {
               labels: xlabel,
               datasets: [{
                   label: label,
                   data: data,
                   fill: false,
                   borderColor: 'rgb(255, 51, 153)',
               }]
           }
   
       });
     }
$(
   ()=>{
      // alert("Thank God");
        var xlabel=[];
        var data1=[];
        var data2=[];
        var data3=[];
        
      let url = "https://api.thingspeak.com/channels/1483314/feeds.json?api_key=0XNU6KDCBYBZVW0U&results=15";
      $.getJSON(url,function( data) {
            let feeds = data.feeds;
            console.log(data);
             $("#spo2").text(feeds[feeds.length-1].field2+" %");
             $("#bpm").text(feeds[feeds.length-1].field1+" BPM");
             $("#temp").text(feeds[feeds.length-1].field3+" ??? C");
             $("#lastUpdate").text(feeds[feeds.length-1].created_at);
         if(feeds[feeds.length-1].field1 > 60 && feeds[feeds.length-1].field1 < 90){
          $("#statusbpm").text("Safe");
         }else{
          $("#statusbpm1").text("Danger");
         }
         if(feeds[feeds.length-1].field2 >= 95){
          $("#statusspo2").text("Safe");
         }else{
          $("#statusspo21").text("Danger");
         }
         if(feeds[feeds.length-1].field3 > 35.4 && feeds[feeds.length-1].field3 < 37.4){
          $("#statustemp").text("Safe");
         }else{
          $("#statustemp1").text("Danger"); 
         }
         
         for (let i=0; i < feeds.length; i++)  {
           xlabel[i] = feeds[i].created_at;
           data1[i] = feeds[i].field1;
           data2[i] = feeds[i].field2;
           data3[i] = feeds[i].field3;  
         } 
    var id1 = 'myChart1';  
    var id2 = 'myChart2';
    var id3 = 'myChart3';
    var label1 = 'BPM (BPM)';
    var label2 = 'Sp02%';
    var label3 = 'Temperature';
     showChart1(data1,xlabel,id1,label1);
     showChart2(data2,xlabel,id2,label2);
     showChart3(data3,xlabel,id3,label3); 
     });     
     console.log(xlabel);    
     console.log(data1);
     console.log(data2);
     })     
 </script>

  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>
</body>
</html>
