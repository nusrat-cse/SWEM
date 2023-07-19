<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = $_SESSION['user_type'];
    if($user_type == '1'){
        $result = $pdo->prepare("SELECT paritcipator.status AS e_status,event.* FROM paritcipator JOIN event ON event.id=paritcipator.event_id WHERE paritcipator.user_id=? AND paritcipator.status=?");
        $result->execute(array(intval($_SESSION['user_id']),1));
        $myparticipate= $result->fetchAll();
    }
    if($user_type == '2'){
        $donate = $pdo->prepare("SELECT accounts.donation_amount AS amount,event.*,event.id AS event_id FROM accounts JOIN event ON event.id = accounts.donor_id WHERE accounts.donor_id=?");
        $donate->execute(array(intval($_SESSION['user_id'])));
        $total_donate = $donate->fetchAll();
    }
?>
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
    .rating_active{
        color:orange
    }
</style>
<?php if($user_type == '1'){
    ?>
    <div class="px-3 bg-white" style="min-height:100vh">
        <div class="row">
            <div class="col-md-3 left_sidebar " >
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php echo $_SESSION['user_name'] ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./dashboard.php" class="list-group-item list-group-item-action fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./request-events.php" class="list-group-item list-group-item-action fs-4">Requested Events</a>
                    <a href="./confirmed-events.php" class="list-group-item list-group-item-action fs-4">Confirmed Events</a>
                    <a href="./complete-events.php" class="active list-group-item list-group-item-action fs-4">Completed Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1> Event Review</h1>
                </div>
                <div class="px-2 py-2">
                   <!-- Modal -->
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-6 col-12 border-1 p-3" style="background: gainsboro;">
                                <div class="w-100">
                                    <div class="py-4">
                                        <input type="text" class="w-100 form-control" id="review_text" placeholder="write your experience">
                                    </div>
                                    <div>
                                        <header style="margin-bottom:5px">How was your experience ?</header>
                                        <div class="review_rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <input type="number" id="event_id" class="d-none" value='<?php echo $_REQUEST['event'];?>'>
                                <div class="modal-footer justify-content-center pt-4">
                                    <button type="button" class="btn btn-primary w-50 rating_post" id="rating_post">POST</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<?php if($user_type == '2'){ ?>
    <div class="px-3 bg-white" style="min-height:100vh">
        <div class="row">
            <div class="col-md-3 left_sidebar">
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php echo $_SESSION['user_name'] ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./dashboard.php" class="list-group-item list-group-item-action fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./donate-events.php" class="list-group-item list-group-item-action active fs-4">Donated Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1> Event Review</h1>
                </div>
                <div class="px-2 py-2">
                <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-6 col-12 border-1 p-3" style="background: gainsboro;">
                                <div class="w-100">
                                    <div class="py-4">
                                        <input type="text" class="w-100 form-control" id="review_text" placeholder="write your experience">
                                    </div>
                                    <div>
                                        <header style="margin-bottom:5px">How was your experience ?</header>
                                        <div class="review_rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <input type="number" id="event_id" class="d-none" value='<?php echo $_REQUEST['event'];?>'>
                                <div class="modal-footer justify-content-center pt-4">
                                    <button type="button" class="btn btn-primary w-50 rating_post" id="rating_post">POST</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('./footer.php');?>
<script>
    var ratings = document.querySelectorAll('.review_rating i');
    var rating_rate = 0;
    ratings.forEach((rating,index1)=>{
        rating.addEventListener('click',()=>{
            rating_rate = index1+1
            ratings.forEach((rating,index2)=>{
                index1 >= index2 ? rating.classList.add('rating_active') : rating.classList.remove('rating_active')
            })
        })
    });
    $('#rating_post').on('click',()=>{
        var rating = rating_rate;
        var event_id = $('#event_id').val()
        var review_text = $('#review_text').val();
        var action = 'post'
        console.log(event_id)
        console.log(review_text)
        console.log(rating)
        if(parseInt(event_id) > 0){
            $.ajax({
                type:'POST',
                url:'./event_rating.php',
                data:{
                    event_id:event_id,
                    rating:rating,
                    review_text:review_text,
                    action:action
                },
                success:(response)=>{
                    if(response == 'Success'){
                        const user_type = "<?php echo $_SESSION['user_type']; ?>"
                        if(user_type == '1'){
                            window.location.href = "./complete-events.php";
                        }else if(user_type == '2'){
                            window.location.href = "./donate-events.php";
                        }
                        
                    }else{
                        alert('Some thing worng');
                    }
                }
            });
        }else{
            alert('Please Login and try again')
        }
    })
    
</script>