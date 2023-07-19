<?php 
include('./header.php');
require('./config.php');
    global $pdo;
    // $data = $pdo->prepare("SELECT * FROM event ORDER BY id DESC");
    // $data->execute();
    // $events = $data->fetchAll();


    $limits=10; 
    if(isset($_GET['page'])){
        $select_page = $_GET['page'];
    }else{
        $select_page = 1;
    }
    
    $offset = ($select_page - 1) * $limits;
    
    $events = $pdo->prepare("SELECT * FROM event ORDER BY id DESC LIMIT :skip ,:max");
    $events->bindValue(':skip',$offset,PDO::PARAM_INT);
    $events->bindValue(':max',$limits,PDO::PARAM_INT);
    $events->execute();
    $totalls = $events->fetchAll();

    $total_events = $pdo->prepare("SELECT * FROM event");
    $total_events->execute();
    $total_event = $total_events->rowCount();
    
    $total_page = ceil($total_event/$limits);

?>
<style>
    .bg_white{
        font-size: 20px;
    }

</style>
<?php
    if(!empty($_SESSION['user_type'])){
        ?>
        <div class="py-4">
            <div>
                <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Total Events</div>
                <table class="table table-bordered bg_white">
                    <thead>
                        <th scope="col">Event Name</th>
                        <th scope="col">Event Image</th>
                        <th scope="col">Event Type</th>
                        <th scope="col">Total Budget</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($totalls)){
                                foreach($totalls as $event){
                                        $total_cost = $pdo->prepare('SELECT SUM(cost_amount) AS amount FROM event_cost WHERE event_id=? ORDER BY id DESC');
                                        $total_cost->execute(array(intval($event['id'])));
                                        $total = $total_cost->fetch();
                                        $text = '';
                                        $color ='';
                                        if($event['status'] == 0){
                                            $text = "Pending";
                                            $color = "primary";
                                        }else if($event['status'] == 1){
                                            $text = "Active";
                                            $color = "success";
                                        }else if($event['status'] == 2){
                                            $text = "Not Approved";
                                            $color = "danger";
                                        }
                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo $event['e_name']; ?></td>
                                        <td scope="row">
                                            <img style="width:75px;height:40px" src="../event_image/<?php echo $event['e_image']; ?>" alt="">
                                        </td>
                                        <td scope="row"><?php echo $event['e_type']; ?></td>
                                       
                                        <td scope="row" ><?php echo $total['amount']; ?></td>
                                        <td scope="row" class="bg-<?php echo $color;?> text-white"><?php echo $text; ?></td>
                                        <td scope="row">
                                            <a href="./event_approve.php?id=<?php echo $event['id'] ?>" class="btn btn-primary">Approve</a> 
                                            <a href="./not_approved.php?id=<?php echo $event['id']?>" class="btn btn-danger">Not Approve</a>
                                            <a href="./event-review.php?id=<?php echo $event['id']?>">Review</a>    
                                        </td>
                                    </tr>
                                    
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 col-12 py-3">
                <div class="d-flex justify-content-end">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if($select_page > 1){
                                ?>
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <?php }
                            
                            for ($i=1; $i <= $total_page; $i++) {
                                if($i == $select_page){
                                    $active ="active";
                                }else{
                                    $active ="";
                                }
                                ?>
                                <li class="page-item <?php echo $active ?>"><a class="page-link" href="./events.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                            <?php } 
                                if($total_page > $select_page){
                                    ?>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                <?php }
                            ?>
                            
                            
                        </ul>
                    </nav>
                </div> 
            </div>
        </div>
    <?php }else{  

    include('./log-in.php');
    
     }
?>
<?php include('../footer.php'); ?>
