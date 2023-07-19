<?php require('./config.php');
    global $pdo;
    if($_POST['district']){
        $distict_id = $_POST['district'];
        $upazila = $pdo->prepare("SELECT * FROM upazilas WHERE district_id=?");
        $upazila->execute(array(intval($distict_id)));
        $all_upazila = $upazila->fetchAll();
        echo json_encode(['upazila'=>$all_upazila]);
    }
    
?>