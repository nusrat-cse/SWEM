<?php include('./header.php'); ?>
<style>
    .registration{
        height: 100vh;
        display: flex;
        color: black;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .container_text{
        font-size: 43px;
        text-align: center;
        text-transform: uppercase;
        font-weight: 700;
    }
    .update_container{
        height: 20vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #8aebc742;
        padding-bottom: 26px;
        border-radius: 10px;
    }
</style>
<div class="registration">
    <div class="container update_container">
        <div class="container_text py-4">Log In</div>
        <div class="row">
            <div class="col-md-4 col-12">
                <a href="./volunteer-log-in.php" class="btn btn-lg w-100 btn-outline-primary py-3"style=" color: white;">Volunteer Log-In</a>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4 col-12">
                <a href="./donar-log-in.php" class="btn btn-lg w-100 btn-outline-success py-3"style=" color: white;">Donar Log-In</a>
            </div>
            
        </div>
    </div>
</div>
<?php include('./footer.php'); ?>