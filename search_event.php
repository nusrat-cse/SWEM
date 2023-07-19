<?php require('./config.php');
    session_start();
    global $pdo;
    $validite = 0;
    $user_type = isset($_SESSION['user_type']);
    if(isset($_SESSION['user_id']) and $user_type == '1'){
        $validite = 1;
    }else{
        $validite = 0;;
    }
    $d_validite = 0;
    if(isset($_SESSION['user_id']) and $user_type == '2'){
        $d_validite = 1;
    }else{
        $d_validite = 0;;
    }
    if($_POST['action'] == "search"){
        $query = "
            SELECT * FROM event WHERE   
         ";
         
        if(isset($_POST['search'])){
            $search = $_POST['search'];
            $query .="
                (e_name LIKE '%".$search."%'
                OR e_type LIKE '%".$search."%'
                OR e_location LIKE '%".$search."%'
                OR e_description LIKE '%".$search."%')
                
            ";
            

        }
        $query .= "
            AND status=1 ORDER By id DESC
            ";
        
        $event = $pdo->prepare($query);
        $event->execute();
        $events = $event->fetchAll();
        $row = $event->rowCount();
        echo json_encode(['total'=>$row,'events'=>$events]);
       
    }