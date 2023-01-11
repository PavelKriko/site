<?php 

class GET_HANDLER{
    function HANDLE_GET(){
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

        if (key($_GET) == ''){
            require './pages/Main.php';
        }
        if(isset($_GET['Manufacturer']) && !empty($_GET['Manufacturer']) ){
            $query = $pdo->query('SELECT * FROM Manufacturer WHERE ManufacturerName = ' .'"'.$_GET['Manufacturer'].'"' )->fetchAll(PDO::FETCH_ASSOC);
            
                if(!empty($query)){
                
                if (isset($_GET['Model']) && !empty($_GET['Model']) && count($_GET)==2){
                    $query_model = $pdo->query('SELECT * FROM Car WHERE Name = ' .'"'.$_GET['Model'].'"' )->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($query_model)){
                        require './pages/Model.php';
                    }
                    else{
                        require './404.php';
                    }   
                }
                if (count($_GET)==1){
                    require './pages/Manufacter.php';
                }
                if(count($_GET)>=3){
                    require './404.php';
                }
            }
            else{
                require './404.php';
            }
        }
        if(!array_key_exists('Manufacturer',$_GET)&&!array_key_exists('Manufacturer',$_GET) && count($_GET)>=1){
            require './404.php';
        }
        }
}

?>
