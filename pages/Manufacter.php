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

$query = $pdo->query('SELECT * FROM Manufacturer where ManufacturerName = "'.$_GET['Manufacturer'].'"')->fetchAll(PDO::FETCH_ASSOC);
$models = $pdo->query('SELECT Car.id,Name,Photo,BodyType,Transmision,Engine,Speed,Cost FROM Manufacturer inner join Car on Car.ManufacterID = Manufacturer.ID 
where ManufacturerName = "'.$_GET['Manufacturer'].'"')->fetchAll(PDO::FETCH_ASSOC);

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
            <div class="container">
                <div class="manufacter__body">
                    <div class="manufacter__name">
                        <div class="name"><?php echo $query[0]['ManufacturerName']?></div>
                        <div class="logo_manufacter"><img src=<?php echo '"'.$query[0]['Logo'].'"' ?> alt=""></div>
                    </div>
                    <div class="manufacter__about">
                        <div class="about">About</div>
                        <div class="about__manufacter"><?php echo $query[0]['Description']?></div>
                    </div>
                    <div class="manufacter__models">
                        <?php if(count($models)){
                            echo '<div class="models">Models</div>';
                        } ?>
                        
                        <ul class="list__models">
                            <?php foreach($models as $model){
                                echo '<li>
                                <div class="model__name"><a class = "model__link" href ="/?Manufacturer='.$query[0]['ManufacturerName'].'&Model='.$model['Name'].'">'.$model['Name'].'</a></div>
                                <div class="model__about">
                                    <div class="model__image"><img src="'.$model['Photo'].'" alt=""></div>
                                    <div class="model__params">
                                        <div class="params">
                                            <div class="param__name">Body type</div>
                                            <div class="param__value">'.$model['BodyType'].'</div>
                                        </div>
                                        <div class="params">
                                            <div class="param__name">Transmision</div>
                                            <div class="param__value">'.$model['Transmision'].'</div>
                                        </div>
                                        <div class="params">
                                            <div class="param__name">Engine</div>
                                            <div class="param__value">'.$model['Engine'].' H/P </div>
                                        </div>
                                        <div class="params">
                                            <div class="param__name">Time to 60 ml/h</div>
                                            <div class="param__value">'.$model['Speed'].' sec.</div>
                                        </div>
                                        <div class="params">
                                            <div class="param__name">Cost</div>
                                            <div class="param__value">'.$model['Cost'].'$</div>
                                        </div>
                                    </div>
                                </div>
                            </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "./components/footer.php" ?>
    </div>
</body>
</html>