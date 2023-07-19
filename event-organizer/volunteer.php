<?php require('./config.php');
    session_start();
    global $pdo;
    
    if(!empty($_SESSION['user_id'])){
        $user_type = $_SESSION['user_type'];
        $events = $pdo->prepare("SELECT event.*,volunteer.user_name as user_name FROM event JOIN volunteer ON volunteer.volunteer_id=event.e_organizer WHERE event.e_organizer=?");
        $events->execute(array(intval($_SESSION['user_id'])));
        $all_events = $events->fetchAll(PDO::FETCH_ASSOC);
    }
    $result = $pdo->prepare("SELECT * FROM skill");
    $result->execute();
    $skills = $result->fetchAll();
    $skill_list ='';
    foreach($skills as $skill){
        $skill_list .='<option value="'.$skill['id'].'">'.$skill['name'].'</option>';
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
        flex-direction: column;
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
                <a href="./event-list.php" class="list-group-item list-group-item-action fs-4">Event List</a>
                <a href="./create-event.php" class="list-group-item list-group-item-action fs-4">Create Event</a>
                <a href="./donars.php" class="list-group-item list-group-item-action fs-4">Donar List</a>
                <a href="./volunteer.php" class="list-group-item list-group-item-action fs-4 active">Volunteer List</a>
                <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

            </div>
            <div class="list-group py-2">
                <a href="./settings.php" class="list-group-item list-group-item-action  fs-4">Settings</a>
                <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                
            </div>
        </div>
        <div class="col-md-9 p-0">
            <div class="dashboard_profile">
                <h1>Volunteer List</h1>
                <div class="row w-100 d-flex justify-content-center">
                    <div class="col-md-3 col-12">
                        <select id="search" class="form-control">
                            <option value="">select  type of skills </option>
                            <?php echo  $skill_list; ?>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class=" px-2 py-2 " >
                <table class="table table-bordered">
                    <thead>
                        <th scope="col">User Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Skills</th>
                        
                    </thead>
                    <tbody id="volunteers">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include('./footer.php'); ?>
<script >
    var null_type = 0;
    
    $('#search').on('change',()=>{
        null_type = 1;
        var type = $('#search').val();
        $('#volunteers').empty();
        $.ajax({
            type:"POST",
            url:'search-volunteers.php',
            data:{
                type:type
            },
            success:(response)=>{
                $('#volunteers').append(response)
            }
        })
    })
    if(null_type == 0){
        $.ajax({
            type:"POST",
            url:'search-volunteers.php',
            data:{
                type:''
            },
            success:(response)=>{
                $('#volunteers').append(response)
            }
        })
    }
    


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