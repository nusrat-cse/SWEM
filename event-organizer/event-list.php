<?php require('./config.php');
    session_start();
    global $pdo;
    
    if(!empty($_SESSION['user_id'])){
        $user_type = $_SESSION['user_type'];
        $events = $pdo->prepare("SELECT * FROM event WHERE e_organizer=?");
        $events->execute(array(intval($_SESSION['user_id'])));
        $all_events = $events->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="./event-list.php" class="list-group-item list-group-item-action fs-4 active">Event List</a>
                <a href="./create-event.php" class="list-group-item list-group-item-action fs-4">Create Event</a>
                <a href="./donars.php" class="list-group-item list-group-item-action fs-4">Donar List</a>
                <a href="./volunteer.php" class="list-group-item list-group-item-action fs-4">Volunteer List</a>
                <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

            </div>
            <div class="list-group py-2">
                <a href="./settings.php" class="list-group-item list-group-item-action  fs-4">Settings</a>
                <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                
            </div>
        </div>
        <div class="col-md-9 p-0">
            <div class="dashboard_profile">
                <h1>Event List</h1>
            </div>
            <div class=" px-2 py-2 " >
                <?php if(!empty($all_events)){ ?>
                    <table class="table table-bordered">
                        <thead>
                            <th scope="col">Event Name</th>
                            <th scope="col">Event Image</th>
                            <th scope="col">Event Start</th>
                            <th scope="col">Event End</th>
                            <th scope="col">Participator request</th>
                            <th scope="col">Total participator</th>
                            <th scope="col">Active Status</th>
                            <th scope="col">Event Step</th>
                            <th scope="col">Total Donation</th>
                            <th scope="col">Actions</th>
                        </thead>
                        <tbody>
                            <?php
                                
                                    foreach($all_events as $event){
                                        
                                        $donation = $pdo->prepare("SELECT SUM(donation_amount) AS donation FROM accounts WHERE event_id=?");
                                        $donation->execute(array(intval($event['id'])));
                                        $total_donation = $donation->fetch();
                                        
                                        $participator = $pdo->prepare("SELECT COUNT(id) AS participator FROM paritcipator WHERE event_id=?");
                                        $participator->execute(array(intval($event['id'])));
                                        $participator_request = $participator->fetch();
                                        $participator1 = $pdo->prepare("SELECT COUNT(id) AS a_participator FROM paritcipator WHERE status=? AND event_id=?");
                                        $participator1->execute(array(1,intval($event['id'])));
                                        $total_participator = $participator1->fetch();
                                        $status_text = '';
                                        $button_color = '';
                                        if($event['status'] == 0){
                                            $status_text = "Pending";
                                            $button_color = 'primary';
                                        }else if($event['status'] == 1){
                                            $status_text = "Active";
                                            $button_color = 'success';
                                        }else if($event['status'] == 2){
                                            $status_text = "In Active";
                                            $button_color = 'danger';
                                        }
                                        $event_step = '';
                                        if($event['event_status'] == 1){
                                            $event_step = "proposed ";
                                            
                                        }else if($event['event_status'] == 2){
                                            $event_step = "Ongoing ";
                                            
                                        }else if($event['event_status'] == 3){
                                            $event_step = "Completed ";
                                        }
                                        $select = '';
                                        if($event['priority'] == 3){
                                            $select = '<option selected value="3">Highest</option>
                                            <option  value="2">Medium</option>
                                            <option  value="1">Average</option>';
                                        }else if($event['priority'] == 2){
                                            $select ='<option  value="3">Highest</option>
                                            <option selected value="2">Medium</option>
                                            <option  value="1">Average</option>';
                                        }else if($event['priority'] == 1){
                                            $select = '<option  value="3">Highest</option>
                                            <option  value="2">Medium</option>
                                            <option selected value="1">Average</option>';
                                        }else{
                                            $select = '<option  value="3">Highest</option>
                                            <option  value="2">Medium</option>
                                            <option  value="1">Average</option>';
                                        }
                                        ?>

                                        <tr>
                                            <td scope="row"><?php echo $event['e_name']; ?></td>
                                            <td scope="row" style="text-align:center">
                                                <img style="width:75px;height:40px" src="../event_image/<?php echo $event['e_image']; ?>" alt="">
                                            </td>
                                            <td scope="row"><?php echo date('m-d-Y',strtotime($event['e_start'])) ?></td>
                                            <td scope="row"><?php echo date('m-d-Y',strtotime($event['e_end'])); ?></td>
                                            <td scope="row"><?php echo $participator_request['participator'] ?></td>
                                            <td scope="row"><?php echo $total_participator['a_participator'] ?></td>
                                            <td scope="row" class="text-<?php echo $button_color?>"><?php echo $status_text; ?></td>
                                            <td scope="row" ><?php echo $event_step; ?></td>
                                            <td scope="row"><?php echo $total_donation['donation'] ?></td>
                                            <td scope="row">
                                                <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#update<?php echo $event['id']; ?>" >Update</button> 
                                                <a href="./event-details.php?id=<?php echo $event['id'] ?>" class="btn btn-success" >Participators</a> 
                                                <a href="./event-cost.php?id=<?php echo $event['id'] ?>" class="btn btn-success" >Cost</a> 
                                                <a href="./event-donar.php?id=<?php echo $event['id'] ?>" class="btn btn-success" >Donars</a> 
                                                <a href="./event-completed.php?id=<?php echo $event['id'] ?>" class="btn btn-success" >Completed</a> 
                                                <a href="./event_delete.php?id=<?php echo $event['id'] ?>" class="btn btn-danger">Delete</a>    
                                            </td>
                                        </tr>
                                        <div class="modal" id="update<?php echo $event['id']?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="./update.php" method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update Event</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" name="event_id" class="form-control d-none"  value="<?php echo $event['id'] ?>">
                                                            <div class="form">
                                                                <label for="" class="form-label text-black">Event Name</label>
                                                                <input type="text" name="event_name" class="form-control" value="<?php echo $event['e_name'] ?>">
                                                            </div>
                                                            <div class="form">
                                                                <label for="" class="form-label text-black">Event Type</label>
                                                                <input type="text" name="event_type" class="form-control"  value="<?php echo $event['e_type'] ?>">
                                                            </div>
                                                            
                                                            <div class="form">
                                                                <label for="" class="form-label text-black">Event Loaction</label>
                                                                
                                                                <textarea type="text" name="location" class="form-control" rows="5"><?php echo $event['e_location'] ?></textarea>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form">
                                                                        <label for="" class="form-label text-black">Event start date</label>
                                                                        <input type="text" name="old_start_date" value="<?php echo $event['e_start']?>" class="d-none">
                                                                        <input type="date" name="start_date"   class="form-control" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form">
                                                                        <label for="" class="form-label text-black">Event End date</label>
                                                                        <input type="text" name="old_end_date" value="<?php echo $event['e_end']?>" class="d-none">
                                                                        <input type="date" name="end_date"  class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form">
                                                                <label for="" class="form-label text-black">Event Description</label>
                                                                <textarea type="text" name="description" class="form-control" rows="5"><?php echo $event['e_description'] ?></textarea>
                                                            </div>
                                                            <div class="form">
                                                                <label for="" class="form-label font_weight">Event Priority</label>
                                                                <select class="form-select font_weight" name="priority" id="thana">
                                                                    <option selected value="">Select priority</option>
                                                                    <?php echo $select ?>
                                                                </select>
                                                            </div>
                                                            <div class="form d-flex justify-content-center">
                                                                <button type="submit" class="w-50 btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                
                            ?>
                        </tbody>
                    </table>
                <?php }else{
                            
                            echo "<h1 class='text-center fs-4'>Please Create Event First </h1>";
                    } ?>
            </div>
        </div>
    </div>
</div>


<?php include('./footer.php'); ?>
<script >
    function updateEvent(){
        var name = $('#event_name').val();
        var type = $('#event_type').val();
        var location = $('#location').val();
        var start = $('#start_date').val();
        var end = $('#end_date').val();
        var cost = $('#cost').val();
        var description = $('#description').val();
        var e_id = $('#event_id').val();
        var model_hidden = "#update"+e_id;
        $.ajax({
            type:"POST",
            url:"./update.php",
            data:{
                name:name,
                type:type,
                location:location,
                start:start,
                end:end,
                cost:cost,
                description:description,
                e_id: e_id,
                action:"UPDATE"
            },
            success:(response)=>{
                var data = JSON.parse(response)
                console.log(data);
                if(data['status'] =='success'){
                    alert('Update successly')
                    console.log(model_hidden)
                    $("+model_hidden+").css('display','none');
                    $(model_hidden).removeClass('show');
                    location.reload('./index.php');
                }
            }
        })
    }

     function createCheck(){
        alert('Please login and try again');
    }

</script>