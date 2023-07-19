<?php 
include('./header.php');
require('./config.php');
    global $pdo;
    // $data = $pdo->prepare("SELECT * FROM event ORDER BY id DESC");
    // $data->execute();
    // $events = $data->fetchAll();
    $event_id = $_REQUEST['id'];
    $review = $pdo->prepare("SELECT event_review.*,volunteer.user_name AS user_name FROM event_review JOIN volunteer ON volunteer.volunteer_id = event_review.by_id WHERE event_id=?");
    $review->execute(array(intval($event_id)));
    $reviews = $review->fetchAll();

    $donor_review = $pdo->prepare("SELECT event_review.*,donor.user_name AS user_name FROM event_review JOIN donor ON donor.donor_id = event_review.by_id WHERE event_id=?");
    $donor_review->execute(array(intval($event_id)));
    $donor_reviews = $donor_review->fetchAll();
?>
<style>
    .bg_white{
        font-size: 20px;
    }

</style>
<div style="background:#257c34cc;color:white">
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
                    <?php foreach($reviews as $rev){
                        $status ='';
                        $link = '';
                        if($rev['review_status'] == 1){
                            $status = 'Active';
                            $link = '<a href="review-status-chage.php?id='.$rev['id'].'&status=0">Suspand</a>';
                        }else{
                            $status = 'Suspand';
                            $link = '<a href="review-status-chage.php?id='.$rev['id'].'&status=1">Approved</a>';
                        }
                        ?>
                    <tr>
                        <td><?php echo $rev['user_name'];?></td>
                        <td><?php echo $rev['review_text'];?></td>
                        <td><?php echo $rev['review'];?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                            <?php echo $link; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php foreach($donor_reviews as $rev){
                        $status ='';
                        $link = '';
                        if($rev['review_status'] == 1){
                            $status = 'Active';
                            $link = '<a href="review-status-chage.php?id='.$rev['id'].'&status=0">Suspand</a>';
                        }else{
                            $status = 'Suspand';
                            $link = '<a href="review-status-chage.php?id='.$rev['id'].'&status=1">Approved</a>';
                        }
                        ?>
                    <tr>
                        <td><?php echo $rev['user_name'];?></td>
                        <td><?php echo $rev['review_text'];?></td>
                        <td><?php echo $rev['review'];?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                            <?php echo $link; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('../footer.php'); ?>