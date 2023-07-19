<?php 
    require('../config.php');
    global $pdo;
    session_start();
    $event_type = $pdo->prepare('SELECT * FROM event_type');
    $event_type->execute();
    $event_types = $event_type->fetchAll();
    $types = '';
    foreach($event_types as $type){
        $types .='<option  value="'.$type['name'].'">'.$type['name'].'</option>';
    }
?>
<?php

    $error_array = array();
    if($_SERVER['REQUEST_METHOD']== "POST"){
        if(!empty($_SESSION['user_id'])){
            $success = "";
            $name = $_POST['event_name'];
            $type = $_POST['event_type'];
            $organizer =$_SESSION['user_id'];
            $location = $_POST['location'];
            $start = $_POST['start_date'];
            $end = $_POST['end_date'];
            $volunteer = $_POST['volunteer'];
            $description = $_POST['description'];
            $image_name = $_FILES['event_image']['name'];
            $image_tmp = $_FILES['event_image']['tmp_name'];
            $image_dir = "../event_image/";
            $valid = 0;
            if(empty($volunteer)){
                array_push($error_array,'Please add voluntter number');
            }
            if(empty($name)){
                array_push($error_array,"Please add name");
                $valid = 1;
            }
            if(empty($image_name)){
                array_push($error_array,"Please add image");
                $valid = 1;
            }
            if(empty($_POST['priority'])){
                $priority = 1;
            }else{
                $priority = $_POST['priority'];
            }
            $image_check =array('jpg','png','jpeg');
            $image_extension = pathinfo($image_name, PATHINFO_EXTENSION); 
            $img_ex_ls = strtolower($image_extension);
            
            if(!in_array($img_ex_ls,$image_check)){
                array_push($error_array,"Please jpg,png or jpeg extension image add");
                $valid = 1;
            }
            if(empty($description)){
                array_push($error_array,"Please add event description");
                $valid = 1;
            }
            
            if(empty($end)){
                array_push($error_array,"Please add event end");
                $valid = 1;
            }
            if(empty($start)){
                array_push($error_array,"Please add event start");
                $valid = 1;
            }
            if(empty($type)){
                array_push($error_array,"Please add event type");
                $valid = 1;
            }
            if(empty($location)){
                array_push($error_array,"Please add event location");
                $valid = 1;
            }
            $check = $pdo->prepare("SELECT * FROM event WHERE e_name=?");
            $check->execute(array($name));
            $check_result = $check->rowCount();
            if($check_result >= 1){
                array_push($error_array," event name already created");
                $valid = 1;
            }
            if($valid == 0){
                $img_new_name = uniqid("IMG-").".".$img_ex_ls;
                $image_path = $image_dir.$img_new_name;
                
                $event_add = $pdo->prepare("INSERT INTO event (total_volunteer,priority,e_name,e_type,e_organizer,e_location,e_image,e_description,e_start,e_end) VALUES(?,?,?,?,?,?,?,?,?,?)");
                $result = $event_add->execute(array($volunteer,$priority,$name,$type,$organizer,$location,$img_new_name,$description,$start,$end));
                if($result){
                    move_uploaded_file($image_tmp,$image_path);
                    $success=" event upload success";
                    ?>
                        <script>
                            alert('Event Create successly');
                            location.replace('./index.php');
                        </script>
                    <?php
                }  
            }
        }else{
            array_push($error_array,"Please Log-in and try again ");
        }
    }
    ?>

<?php include('./header.php'); ?>
<style>
    .dashboard_link{
        height: 200px;
        background: #af5c9d;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: white;
        border-radius: 12px;
        box-shadow: 1px 6px 2px 2px #1e1b1da8;
    }
    .dashboard_link:hover{
        background:pink;
        color:black
    }
    .dashboard_link .text{
        font-size: 25px;
        padding-bottom: 28px;
    }
    .dashboard_link .number{
        font-size: 25px;
        font-family: sans-serif;
        font-weight: 700;
    }
    .gap{
        column-gap: 11%;
        justify-content: center;
        row-gap: 2%;
    }
    .dashboard_profile{
        margin-left: 5px;
        height: 176px;
        background: gainsboro;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: sans-serif;
    }
    .dashboard_profile h1{
        font-size: 64px;
        text-align: center;
    }
    .list-group-item:hover{
        z-index: 2;
        color: white;
        background-color: #0d6efd;
        border-color: 0d6efd;
    }
    .form-container_event{
        min-height: 100vh;
        align-items: center;
        border-radius: 12px;
        background-image: url(./public/image/home-bg.jpg);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>
<div class="px-3 bg-white" style="min-height:100vh">
        <div class="row">
            <div class="col-md-3 left_sidebar">
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}else{echo 'user name';}  ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./index.php" class="list-group-item list-group-item-action  fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./event-list.php" class="list-group-item list-group-item-action fs-4">Event List</a>
                    <a href="./create-event.php" class="list-group-item list-group-item-action fs-4 active">Create Event</a>
                    <a href="./donars.php" class="list-group-item list-group-item-action fs-4">Donar List</a>
                <a href="./volunteer.php" class="list-group-item list-group-item-action fs-4">Volunteer List</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Create New Event</h1>
                </div>
                <div class=" px-2 py-2 " >
                    <div class="row d-flex justify-content-center form-container_event">
                        <div class="col-md-6 col-12 rg-background">
                            <?php 
                                if(!empty($error_array)){
                                    foreach($error_array as $error){
                                    ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Opps!</strong> <?php echo $error;?> .
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php }}
                            
                            ?>
                            <?php 
                                if(!empty($success)){
                                    
                                    ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Hurray!</strong> <?php echo $success;?> .
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php }
                            
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                                <div class="form">
                                    <label for="" class="form-label">Event Name</label>
                                    <input type="text" name="event_name" class="form-control" placeholder="event name">
                                </div>
                                <div class="form">
                                    <label for="" class="form-label">Event Type</label>
                                    <select class="form-select font_weight" name="event_type">
                                        <option selected value="">Select Event</option>
                                        <?php echo $types; ?>
                                    </select>
                                </div>
                                <div class="form">
                                    <label for="" class="form-label">Event Location</label>
                                    <textarea type="text" name="location" class="form-control" placeholder="event location" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form">
                                            <label for="" class="form-label">Event start date</label>
                                            <input type="date" name="start_date" min="<?php echo date('Y-m-d'); ?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form">
                                            <label for="" class="form-label">Event End date</label>
                                            <input type="date" name="end_date" min="<?php echo date('Y-m-d'); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form">
                                    <label for="" class="form-label">Event Image</label>
                                    <input type="file" name="event_image" class="form-control" placeholder="event image">
                                </div>
                                <div class="form">
                                    <label for="" class="form-label">Event Description</label>
                                    <textarea type="text" name="description" class="form-control" placeholder="Description" rows="5"></textarea>
                                </div>
                                <div class="form">
                                    <label for="" class="form-label">Total Volunteer</label>
                                    <input type="number" name="volunteer" class="form-control" placeholder="Join total volunteer">
                                </div>
                                <div class="form">
                                    <label for="" class="form-label font_weight">Event Priority</label>
                                    <select class="form-select font_weight" name="priority">
                                        <option selected value="">Select priority</option>
                                        <option  value="3">Highest</option>
                                        <option  value="2">Medium</option>
                                        <option  value="1">Average</option>
                                    </select>
                                </div>
                                <div class="form d-flex justify-content-center">
                                    <button type="submit" class="w-50 btn btn-primary">save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php'); ?>
