<?php include('./header.php');
    require('./config.php');
    global $pdo;
    $data = $pdo->prepare("SELECT * FROM user ORDER BY id");
    $data->execute();
    $participators = $data->fetchAll();
?>
<div class="py-4">
    <div>
        <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Total Participators</div>
        <table class="table table-bordered">
            <thead>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile Number</th>

            </thead>
            <tbody>
                <?php
                    if(!empty($participators)){
                        foreach($participators as $user){
                            ?>
                            <tr>
                                <td scope="row"><?php echo $user['user_name']; ?></td>
                                <td scope="row">
                                    <?php echo $user['email']; ?>
                                </td>
                                <td scope="row"><?php echo $user['mobile']; ?></td>
                                
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
