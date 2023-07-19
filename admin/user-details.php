<?php require('./config.php');
    global $pdo;
    $id = $_REQUEST['id'];
    $user = $pdo->prepare("SELECT * FROM user WHERE id=?");
    $user->execute(array(intval($id)));
    $user_info = $user->fetch();

?>
<?php require('./header.php') ?>
<style>
    .volunter_text{
        text-align: center;
        padding: 20px;
        background: green;
        font-size: 40px;
        font-weight: 600;
    }
    .font_weight{
        font-weight:600;
        color:black;
    }
    .address{
        font-size:22px;
        color:black;
    }
</style>
<div class="container bg-white" style="min-height:100vh">
    <div class="form">
        <label for="" class="form-label font_weight">Founder Name</label>
        <input type="text" class="form-control font_weight" value="<?php echo $user_info['founder_name'] ?>" disabled>
    </div>
    <div class="form">
        <label for="" class="form-label font_weight">Founder User Name</label>
        <input type="text" class="form-control font_weight" name='user_name' value="<?php echo $user_info['user_name'] ?>" disabled>
    </div>
    <div class="form">
        <label for="" class="form-label font_weight">Organization Name</label>
        <input type="text" class="form-control font_weight" value="<?php echo $user_info['organization_name'] ?>" disabled>
    </div>
    <div class="form">
        <label for="" class="form-label font_weight">Email Address</label>
        <input type="text" class="form-control font_weight" value="<?php echo $user_info['email'] ?>" disabled>
    </div>
    <div class="form">
        <label for="" class="form-label font_weight">Mobile number</label>
        <input type="text" class="form-control font_weight" value="<?php echo $user_info['mobile'] ?>" disabled>
    </div>
    <div class="font_weight address">Present Address</div>
    <div class="form">
        <div class="font_weight form-control" disabled>
            <?php echo $user_info['address'] ?>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-md-6 col-12">
            <div class="form">
                <label for="" class="form-label font_weight w-100">Government Certificate for Verification *</label>
                <img src="../organizer-document/<?php echo $user_info['govt_certificate'] ?>" style="width:100%;height:250px" alt="">
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form">
                <label for="" class="form-label font_weight w-100">NID Card Photo *</label>
                <img src="../organizer-document/<?php echo $user_info['govt_certificate2'] ?>" style="width:100%;height:250px" alt="">
            </div>
        </div>
    </div>
    
    
</div>
<?php require('./footer.php') ?>

