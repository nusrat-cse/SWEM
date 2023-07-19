<?php include('./header.php');
    require('./config.php');
    global $pdo;
    $data = $pdo->prepare("SELECT * FROM volunteer WHERE user_type=? ORDER BY volunteer_id");
    $data->execute(array(1));
    $participators = $data->fetchAll();
?>
<style>
    .bg_white{
        background: #04040669;
        color: white;
        font-size: 20px;
    }
</style>
<div class="py-4">
    <div>
        <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Total Volunteer</div>
        <table class="table table-bordered bg_white">
            <thead>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>


            </thead>
            <tbody>
                <?php
                    if(!empty($participators)){
                        foreach($participators as $user){
                                $text = '';
                                $color ='';
                                if($user['account_status'] == 0){
                                    $text = "Pending";
                                    $color = "primary";
                                }else if($user['account_status'] == 1){
                                    $text = "Active";
                                    $color = "success";
                                }else if($user['account_status'] == 2){
                                    $text = "In-Active";
                                    $color = "warning";
                                }
                            ?>
                            <tr>
                                <td scope="row"><?php echo $user['user_name']; ?></td>
                                <td scope="row">
                                    <?php echo $user['email']; ?>
                                </td>
                                <td scope="row"><?php echo $user['mobile']; ?></td>
                                <td scope="row" class="text-<?php echo $color; ?>"><?php echo $text; ?></td>
                                <td scope="row">
                                    <?php if($user['account_status'] == 0){
                                        ?>
                                        <a href="./approve.php?id=<?php echo $user['volunteer_id'] ?>&type=<?php echo $user['user_type']?>" class="btn btn-primary">Approve</a> 
                                    <?php }else{ ?>
                                        <a href="./active.php?id=<?php echo $user['volunteer_id'] ?>&type=<?php echo $user['user_type']?>" class="btn btn-primary">Active</a> 
                                    <?php } ?>
                                    <a href="./in-active.php?id=<?php echo $user['volunteer_id']?>&type=<?php echo $user['user_type']?>" class="btn btn-danger">Suspand</a> 
                                    <a href="./delete.php?id=<?php echo $user['volunteer_id']?>&type=<?php echo $user['user_type']?>" class="btn btn-danger">Delete</a>   
                                </td>
                            </tr>
                            
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('../footer.php'); ?>
