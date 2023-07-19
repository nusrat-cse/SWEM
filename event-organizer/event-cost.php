<?php require('./config.php');
    global $pdo;
    session_start();


    if($_SERVER['REQUEST_METHOD']== "POST"){
        $text = $_REQUEST['cost_title'];
        $amount =$_REQUEST['cost_amount'];
        $id = $_REQUEST['event_id'];
        $checkValue = 0;
        if(empty($text)){
            echo "<script> alert('please add cost title') </script>";
            echo "<script>location.replace('./event-cost.php?id=".$id."') </script>";
            $checkValue = 1;
        }
        if(empty($amount)){
            echo "<script> alert('please add cost amount') </script>";
            echo "<script>location.replace('./event-cost.php?id=".$id."') </script>";
            $checkValue = 1;
        }

        if($checkValue == 0){
            $cost_add = $pdo->prepare("INSERT INTO event_cost (event_id,cost_text,cost_amount) VALUES(?,?,?)");
            $result =$cost_add->execute(array($id,$text,$amount));
            if($result){
                ?>
                <script>
                    alert('Event Cost Created Successfully');
                    location.replace('./event-cost.php?id=<?php echo $id;?>')
                </script>
            <?php }
        }
    }




    $event_id = $_REQUEST['id'];
    $cost = $pdo->prepare('SELECT * FROM event_cost WHERE event_id=? ORDER BY id DESC');
    $cost->execute(array(intval($event_id)));
    $cost_list = $cost->fetchAll();
    $total_cost = $pdo->prepare('SELECT SUM(cost_amount) AS amount FROM event_cost WHERE event_id=? ORDER BY id DESC');
    $total_cost->execute(array(intval($event_id)));
    $total = $total_cost->fetch();
?>

<?php include('./header.php'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-end py-3">   
        <div><button data-bs-toggle="modal" data-bs-target="#eventCost"  class="btn btn-primary">Create Event Cost</button></div>
    </div>
    <div>
        <div class="text-center" style="font-size: 45px; font-weight: 800;background: gainsboro;">Event Total Costs</div>
        <table class="table table-bordered" style=" color: white;">
            <thead>
                <th scope="col">Cost Name</th>
                <th scope="col">Cost Amount</th>
                <th scope="col">Actions</th>
            </thead>
            <tbody>
                <?php if(isset($cost_list)){
                    foreach($cost_list as $cost){
                        ?>
                        <tr>
                            <td scope="row"><?php echo $cost['cost_text'] ?></td>
                            <td scope="row"><?php echo $cost['cost_amount'] ?></td>
                            <td scope="row">
                                <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#eventCostUpdate<?php echo $cost['id'] ?>">Update</button> 
                                <a href="./cost-delete.php?id=<?php echo $cost['id'] ?>&event_id=<?php echo $event_id?>" class="btn btn-danger" >Delete</a> 
                            </td>
                        </tr>
                        <div class="modal" id="eventCostUpdate<?php echo $cost['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Create Event Cost</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="./cost_update.php" method="post">
                                        <div class="modal-body">
                                            <input type="text" name="event_id" class="form-control d-none"  value="<?php echo $event_id ?>">
                                            <input type="text" name="cost_id" class="form-control d-none"  value="<?php echo $cost['id'] ?>">
                                            <div class="form">
                                                <label for="" class="form-label text-black">Cost Title</label>
                                                <input type="text" name="cost_title" class="form-control" value="<?php echo $cost['cost_text'] ?>">
                                            </div>
                                            <div class="form">
                                                <label for="" class="form-label text-black">Cost Amount</label>
                                                <input type="number" name="cost_amount" value="<?php echo $cost['cost_amount'] ?>" class="form-control" >
                                            </div>
                                            <div class="form d-flex justify-content-center">
                                                <button type="submit" class="w-50 btn btn-primary">Add Event Cost</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php }

                } ?>
                <tr>
                    <td scope="row" class="fw-bold">Total cost</td>
                    <td scope="row" class="fw-bold"><?php echo $total['amount'] ?></td>
                    <td scope="row">
                       
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<div class="modal" id="eventCost" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Event Cost</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="modal-body">
                    <input type="text" name="event_id" class="form-control d-none"  value="<?php echo $event_id ?>">
                    <div class="form">
                        <label for="" class="form-label text-black">Cost Title</label>
                        <input type="text" name="cost_title" class="form-control">
                    </div>
                    <div class="form">
                        <label for="" class="form-label text-black">Cost Amount</label>
                        <input type="number" name="cost_amount" class="form-control" >
                    </div>
                    <div class="form d-flex justify-content-center">
                        <button type="submit" class="w-50 btn btn-primary">add Event Cost</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('./footer.php'); ?>


