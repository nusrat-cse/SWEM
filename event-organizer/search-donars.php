<?php 
    require('./config.php');
    global $pdo;
    $data = $_POST['type'];
    if($data ==''){
        $result = $pdo->prepare("SELECT * FROM donor");
        $result->execute();
        $donars = $result->fetchAll();
        $donat = '';
        foreach ($donars as $user) {
                
            $donat .='<tr>   
                        <td scope="row">'.$user['user_name'].'</td>
                        <td scope="row">'.$user['email'].'</td>
                        <td scope="row">'.$user['mobile'].'</td>
                    </tr>';
        }
        echo $donat;
    }
?>