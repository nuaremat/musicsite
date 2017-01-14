<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

//    include('src/databaseFunctions.php');
//
//    try {
//        $db = myDBConnect();
//    } catch (Exception $e) {
//        // variabel som används för att skriva ut errormeddelande på sidan
//        $error = 'Error connecting to DB: ' . $e->getMessage();
//    }

?>
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <link href="style/stilmall.css" rel="stylesheet" type="text/css" />

    <?php if(isset($accordion)) : ?>
        <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.css" />
    <?php endif; ?>

    <?php if(isset($slimbox)) : ?>
        <link rel="stylesheet" href="slimbox-2.05/css/slimbox2.css" />
    <?php endif; ?>

    <title><?php echo($title); ?></title>

</head>

<body>

    <header>My MusicSite</header>

    <div id="wrapper">

        <div id="main">