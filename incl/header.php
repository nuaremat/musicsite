<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
?>
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <link href="style/stilmall.css" rel="stylesheet" type="text/css" />

    <?php if(isset($accordion)) { ?>
        <!-- 20150914 1.11.1 -> 1.11.4 
            20161019 1.11.4 -> 1.12.1 -->
        <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.css" />
    <?php } ?>

    <?php if(isset($slimbox)) { ?>
        <!-- 20150914 2 -> 2.05 -->
        <link rel="stylesheet" href="slimbox-2.05/css/slimbox2.css" />
    <?php } ?>

    <title><?php echo($title); ?></title>

</head>

<body>

    <header>My MusicSite</header>

    <div id="wrapper">

        <div id="main">