<?php 
require_once "./system/DB.php";
$username = 'root';
$password = '';
$db = 'drive-up';
$host = 'drive-up';

$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

$dsn = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8;';

try {
    DB::getInstance()->connect($dsn, $username, $password, $opt);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}


$pdo = DB::getInstance()->get_pdo();

$query = $pdo->query('SELECT ManufacturerName FROM Manufacturer')->fetchAll(PDO::FETCH_ASSOC);

$list = array();

foreach($query as $value){
    $leter = mb_substr($value['ManufacturerName'], 0, 1);
    if(!array_key_exists($leter,$list)){
        $list[$leter] = array();
        array_push($list[$leter], $value['ManufacturerName']);
    }
    else{
        array_push($list[$leter], $value['ManufacturerName']);
    }
}

ksort($list);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/pages/style.css">
    <title>Drive up</title>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <?php require_once "./components/header.php" ?>
            <div class="main__block">
                <div class="title">
                    <span class="top">Welcome to Drive-Up!</span>
                    <span class="bot">Here you can find any car!</span>
                </div>
                <a href="" class="button_search">Search</a>
                <img src="../assets/Main_car.png" alt="Car" class="main__image">
            </div>
            <div class="maker">
                <div class="container">
                    <div class="maker__body">
                        <div class="maker__title">Manufacturers:</div>
                        <span class="line"></span>
                        <?php
                            $htmlcode = '';
                            foreach(array_keys($list) as $leter){
                                $htmlcode .='<div class="category">';
                                $htmlcode .='<span class="letter">'.$leter.'</span>';
                                $htmlcode .='<ul class="list">';
                                foreach($list[$leter] as $name){
                                    $htmlcode .= '<li>';
                                    $htmlcode .= '<a href="'.'/?Manufacturer='.$name.'">'.$name.'</a>';
                                    $htmlcode .= '</li>';
                                }
                                $htmlcode .= '</ul>';
                                $htmlcode .= '</div>';
                            }
                            echo $htmlcode;
                         ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "./components/footer.php" ?>
    </div>
</body>
</html>