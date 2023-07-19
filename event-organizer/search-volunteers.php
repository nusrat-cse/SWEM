<?php 
    require('./config.php');
    global $pdo;
    $data = $_POST['type'];
    if($data ==''){
        $result = $pdo->prepare("SELECT * FROM volunteer");
        $result->execute();
        $volunteer = $result->fetchAll();
        $skills = '';
        foreach ($volunteer as $user) {
                $id = $user['volunteer_id'];
                $type ='';
                if($id){
                    $result = $pdo->prepare("SELECT skill.name AS skill FROM volunteer_skill JOIN skill ON skill.id = volunteer_skill.skill_id WHERE volunteer_id=?");
                    $result->execute(array(intval($id)));
                    $event_type = $result->fetchAll();
                    $skills = '';
                    foreach($event_type as $skill){
                        $skills .= $skill['skill'].' ' ;
                    }
                    
                }else{
                    $type =  'Null';
                }
                
            $skills .='<tr>   
                        <td scope="row">'.$user['user_name'].'</td>
                        <td scope="row">'.$user['email'].'</td>
                        <td scope="row">'.$user['mobile'].'</td>
                        <td scope="row">'.$skills.'</td>
                    </tr>';
        }
        echo $skills;
    }else{
        $result = $pdo->prepare("SELECT * FROM volunteer WHERE skill=?");
        $result->execute(array(intval($data)));
        $volunteer = $result->fetchAll();
        $skills = '';
        foreach ($volunteer as $user) {
            $id = $user['skill'];
            $type ='';
            if($id){
                $result = $pdo->prepare("SELECT * FROM skill WHERE id=?");
                $result->execute(array(intval($id)));
                $event_type = $result->fetch();
                if($event_type){
                    $type =  $event_type['name'];
                }else{
                    $type =  'Null';
                }
            }else{
                $type =  'Null';
            }
            
        $skills .='<tr>   
                    <td scope="row">'.$user['user_name'].'</td>
                    <td scope="row">'.$user['email'].'</td>
                    <td scope="row">'.$user['mobile'].'</td>
                    <td scope="row">'.$type.'</td>
                </tr>';
    }
    echo $skills;

    }
    
?>