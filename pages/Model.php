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

$model = $pdo->query('SELECT AboutModel,Name,Photo,BodyType,Transmision,Engine,Speed,Cost FROM Manufacturer inner join Car on Car.ManufacterID = Manufacturer.ID where ManufacturerName ="'.$_GET['Manufacturer'].'" and Name="'.$_GET['Model'].'"')->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive-Up</title>
    <link rel="stylesheet" href="/pages/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="content">
        <?php require_once "./components/header.php" ?>
            <div class="container">
                <div class="flex__model">
                    <img class = "image__model" src=<?php echo '"'.$model[0]['Photo'].'"'?> alt="">
                    <div class="block__model">
                        <div class="name__model"><?php echo $model[0]['Name']?></div>
                        <div class="model__description"><?php echo $model[0]['AboutModel']?></div>
                        <div class="name__model">Parameters</div>
                        <div class="param__model">
                            <div class="param__key__value">
                                <div class="parameter__name">Body type</div>
                                <div class="parameter__value"><?php echo $model[0]['BodyType']?></div>
                            </div>
                            <div class="param__key__value">
                                <div class="parameter__name">Transmision</div>
                                <div class="parameter__value"><?php echo $model[0]['Transmision']?></div>
                            </div>
                            <div class="param__key__value">
                                <div class="parameter__name">Engine</div>
                                <div class="parameter__value"><?php echo $model[0]['Engine'].' H/P'?></div>
                            </div>
                            <div class="param__key__value">
                                <div class="parameter__name">Sec for 60m/p</div>
                                <div class="parameter__value"><?php echo $model[0]['Speed'].' sec.'?></div>
                            </div>
                            <div class="param__key__value">
                                <div class="parameter__name">Cost</div>
                                <div class="parameter__value"><?php echo $model[0]['Cost'].'$'?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "./components/footer.php" ?>
    </div>
</body>
</html>