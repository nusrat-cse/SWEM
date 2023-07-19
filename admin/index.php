<?php 

    include('./header.php');
    require('./config.php');
    global $pdo;
    $volunteer = $pdo->prepare("SELECT * FROM volunteer");
    $volunteer->execute();
    $total_volunteer = $volunteer->rowCount();

    $donar = $pdo->prepare("SELECT * FROM donor");
    $donar->execute();
    $total_donar = $donar->rowCount();

    $event_organizer = $pdo->prepare("SELECT * FROM event_organizer");
    $event_organizer->execute();
    $total_event_organizer = $event_organizer->rowCount();

    $event= $pdo->prepare("SELECT * FROM event");
    $event->execute();
    $total_event = $event->rowCount();

?>
<?php
    if(!empty($_SESSION['user_type'])){
        ?>
        <div class="row my-4" style="row-gap:20px">
            <div class="col-md-4 col-6">
                <a href="./events.php" class="btn btn-warning w-100 py-3">
                    <h3>Events</h3>
                    <b><?php echo $total_event; ?></b>
                </a>
            </div>
            <div class="col-md-4 col-6">
                <a href="./event-organizer.php" class="btn btn-warning w-100 py-3">
                    <h3>Event Organizer</h3>
                    <b><?php echo $total_event_organizer; ?></b>
                </a>
            </div>
            <div class="col-md-4 col-6">
                <a href="./volunteer.php" class="btn btn-warning w-100 py-3">
                    <h3>volunteer</h3>
                    <b><?php echo $total_volunteer; ?></b>
                </a>
            </div>
            <div class="col-md-4 col-6">
                <a href="./donar.php" class="btn btn-warning w-100 py-3">
                    <h3>Donar</h3>
                    <b><?php echo $total_donar; ?></b>
                </a>
            </div>
            
        </div>
    <?php }else{  

    include('./log-in.php');
    
     }
?>
<?php include('../footer.php'); ?>
<script>
    $('#login').on('click',()=>{
        var email = $('#email').val();
        var password = $("#password").val();
        $.ajax({
            type:"POST",
            url:"./login-check.php",
            data:{
                email:email,
                password : password
            },
            success:(response)=>{
                console.log(response)
                var data = JSON.parse(response);
                if(data['status']=='success'){
                    alert('log-in success');
                    location.replace('./index.php');  
                }else{
                    alert('please add valid information');
                }

            }
        })
    })
</script>