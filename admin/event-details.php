<?php 
include('./header.php');
require('./config.php');
    global $pdo;
    // $data = $pdo->prepare("SELECT * FROM event ORDER BY id DESC");
    // $data->execute();
    // $events = $data->fetchAll();
    $event_id = $_REQUEST['id'];
    $event = $pdo->prepare("SELECT event.*,event_organizer.* fROM event JOIN event_organizer ON event_organizer.organizer_id = event.e_organizer  WHERE id=? LIMIT 1");
    $event->execute(array(intval($event_id)));
    $evt = $event->fetch();

    $event_donor =$pdo->prepare('SELECT donate.*,donar.* FROM donate JOIN donar ON donar.donar_id=donate.user_id WHERE event_id=?');
    $event_donor->execute(array(intval($event_id)));
    $event_donors = $event_donor->fetchAll();


    $event_volunteer = $pdo->prepare("SELECT volunteer.* FROM paritcipator JOIN volunteer ON volunteer.volunteer_id = paritcipator.user_id WHERE paritcipator.event_id=? AND paritcipator.status=?");
    $event_volunteer->execute(array(intval($event_id),1));
    $event_volunteers = $event_volunteer->fetchAll();
?>
<style>
    .bg_white{
        font-size: 20px;
    }

</style>
<div style="background:#257c34cc;color:white">
    <div class="row">
        <div class="col-md-6">
            <div class='d-flex'>
                <img src="../event_image/<?php echo $evt['e_image'];?>" style="height:300px;width:300px" alt="">
                <div style='margin-left:10px'>
                    <div>
                        <b>Event Title: </b>
                        <p><?php echo $evt['e_name'];?></p>
                    </div>
                    <div>
                        <b>Event Organizer by: </b>
                        <p><?php echo $evt['user_name'];?></p>
                    </div>
                    <div>
                        <b>Event Status : </b>
                        <p><?php echo $evt['status'];?></p>
                    </div>
                </div>
            </div>
            <div>
                <b>Description : </b>
                <p><?php echo $evt['e_description'];?></p>
            </div>
            <div>
                <b>Event Status : </b>
                <p><?php echo $evt['status'];?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div>Location</div>
            <div class="event_location"><?php echo $evt['e_location'];?></div>
        </div>
        <div class="col-md-6">
            <h3 class="text-center">Event Volunteers List</h3>
            <div>
                <table class="table table-bordered bg_white">
                    <thead>
                        <th scope="col">volunteer name</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Email Address</th>
                    </thead>
                    <tbody>
                        <?php foreach($event_volunteers as $volunteer){ ?>
                            <tr>
                                <td scope="row"><?php  echo $volunteer['user_name'] ?></td>
                                <td scope="row"><?php  echo $volunteer['mobile'] ?></td>
                                <td scope="row"><?php  echo $volunteer['email'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="text-center">Event Donor List</h3>
            <div>
                <table class="table table-bordered bg_white">
                    <thead>
                        <th scope="col">Donor name</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Amount</th>
                    </thead>
                    <tbody>
                        <?php foreach($event_donors as $donor){ ?>
                            <tr>
                                <td scope="row"><?php echo $donor['user_name'] ?></td>
                                <td scope="row"><?php echo $donor['mobile'] ?></td>
                                <td scope="row"><?php echo $donor['email'] ?></td>
                                <td scope="row"><?php echo $donor['amount'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <h1 class="text-center">Event Reviews</h1>
        <div>
            <table class="table table-bordered bg_white">
                <thead>
                    <th scope="col">Review By</th>
                    <th scope="col">message</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row"></td>
                        <td scope="row"></td>
                        <td scope="row"></td>
                        <td scope="row"></td>
                        <td scope="row"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('../footer.php'); ?>