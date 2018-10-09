<?php
ob_start();
$dir = empty($dir) || !isset($dir) ? "" : $dir;
$disable = empty($disable) || !isset($disable) ? TRUE : FALSE;
$color = empty($color) || !isset($color) ? "red": $color;
$active_dir = empty($active_dir) || !isset($active_dir) ? "admin" :$active_dir ; 
$active_sub_dir = empty($active_sub_dir) || !isset($active_sub_dir) ? "index" :$active_sub_dir ; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ace Water Spa Reservation</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    
    <!-- Bootstrap Core Css -->
    <link href="<?php echo $dir; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    
   
    <link rel="stylesheet" type="text/css" href="<?php echo $dir; ?>assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $dir; ?>assets/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $dir; ?>assets/fontawesome-5.1.1-web/css/all.min.css">
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $dir; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />    
    
    <!-- Bootstrap Select Css -->
    <link href="<?php echo $dir; ?>plugins/bootstrap-select/css/select-bootstrap.min.css" rel="stylesheet" />
    <!--WaitMe Css-->
    <link href="<?php echo $dir; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
    <!-- Waves Effect Css -->
    <link href="<?php echo $dir; ?>plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?php echo $dir; ?>plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo $dir; ?>plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">
    <!-- Morris Chart Css-->
    <link href="<?php echo $dir; ?>plugins/morrisjs/morris.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="<?php echo $dir; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Custom Css -->
     <link href="<?php echo $dir; ?>assets/css/style.min.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $dir; ?>assets/css/themes/all-themes.css" rel="stylesheet" />
    

    <script src="<?php echo $dir; ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $dir; ?>plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo $dir; ?>plugins/sweetalert/New/sweetalert2.min.js"></script>
    <link href="<?php echo $dir; ?>plugins/sweetalert/New/sweetalert2.min.css" rel="stylesheet" />
    
    <script src="<?php echo $dir; ?>assets/js/admin.js"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="<?php echo $dir; ?>plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?php echo $dir; ?>plugins/jquery-validation/additional-methods.js"></script>
    <!-- SweetAlert Plugin Js -->
    <!-- Sweetalert Css -->
    
    
    <script src="<?php echo $dir; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $dir; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap4.min.js"></script>
    <!-- Wait Me Plugin Js -->
    <script src="<?php echo $dir; ?>plugins/waitme/waitMe.js"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo $dir; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <script src="<?php echo $dir; ?>assets/js/pages/ui/tooltips-popovers.js"></script>
    

</head>
<body class="theme-<?php echo $color; ?>">
<!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-<?php echo $color;?>">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->
     <!-- #END# Page Loader -->
     <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a> -->
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo $active_dir !== "admin" ? "../" : ""; ?>index.php">Ace Water Spa | Reservation System</a>
            </div>
        </div>
    </nav>    