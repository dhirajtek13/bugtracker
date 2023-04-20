<?php include_once './db/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./libraries/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="./css/bt.css" >
    
    <script src="./libraries/js/jquery-3.6.4.min.js"  crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./libraries/DataTables/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="./libraries/DataTables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./libraries/DataTables/dataTables.fixedHeader.min.js"></script>

    
    <script src="./libraries/js/sweetalert.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <title><?php echo SITE_NAME ; ?></title>
</head>
<body>

<?php include_once 'navbar.php'; ?>