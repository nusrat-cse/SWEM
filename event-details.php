<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $id = $_REQUEST['id'];
    $event = $pdo->prepare('SELECT * FROM event WHERE id=? LIMIT 1');
    $event->execute(array($id));
    $evt = $event->fetch();
    $event_creator = $pdo->prepare('SELECT * FROM event_organizer WHERE organizer_id=? LIMIT 1');
    $event_creator->execute(array(intval($evt['e_organizer'])));
    $creator = $event_creator->fetch();
    $user_type = isset($_SESSION['user_type']);
    $valid_donar = 0;
    if(isset($_SESSION['user_id'])){
        if($_SESSION['user_type'] == '2'){
            $valid_donar= 1;
        }else{
            $valid_donar= 2;
        }
        
    }else{
        $valid_donar = 0;
    }
    
    $donation = $pdo->prepare("SELECT SUM(donation_amount) AS donation FROM accounts WHERE event_id=?");
    $donation->execute(array(intval($id)));
    $total_donation = $donation->fetch();

    
    $cost = $pdo->prepare("SELECT * FROM event_cost WHERE event_id=?");
    $cost->execute(array(intval($id)));
    $all_cost = $cost->fetchAll();

    $event_cost = $pdo->prepare("SELECT SUM(cost_amount) AS total_donation FROM event_cost WHERE event_id=?");
    $event_cost->execute(array(intval($id)));
    $total_cost = $event_cost->fetch();

    $participator = $pdo->prepare("SELECT * FROM participator WHERE status=? AND event_id=?");
    $participator->execute(array(1,intval($id)));
    $total_participator = $participator->rowCount();

    
?>
<style>
    .details_text{
        font-size: 45px;
        font-weight: 700;
        font-family: serif;
        background: #ededed;
    }
    .google_map iframe{
        width:100%;
        height:300px
    }
    .location_text{
        text-align: center;
        font-size: 48px;
        background: gainsboro;
        padding: 13px 0px;
        margin-bottom: 12px;
    }
    .details_left{
        background: ghostwhite;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }
    .reaminder{
        font-size: 20px;
        font-weight: 700;
    }
    .remainderTime{
        background: pink;
        border-radius: 6px;
        padding: 7px 10px;
    }
    .donation{
        background: aliceblue;
        margin: 19px 0px;
        padding: 24px 9px;
        border-radius: 10px;
    }
    .donate_text{
        text-align: center;
        font-size: 40px;
        font-family: sans-serif;
    }
    .total_V{
        background: #bfc9d3;
        border-radius: 10px;
        width: 40%;
        height: 166px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .total_d{
        background: #bfc9d3;
        border-radius: 10px;
        width: 40%;
        height: 166px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .click_button{
        font-size:20px
    }
    .click_button:hover,.click_active{
        background: yellowgreen;
    }
    .warinig{
        text-align: center;
        font-size: 21px;
        color: red;
        background: #ff00001c;
    }
    .review_rating{
        color: orange;
        display: flex;
        gap: 15px;
        font-size: 23px;
        color:#b9b9b9;
        font-weight: 800;
    }
    .rating_active{
        color:orange
    }
</style>
<div class="container">
    <div class="py-4 text-black text-center details_text">Event Details</div>
    <div class="row">
        <div class="col-md-6 col-12">
            <div>
                <img style="width:100%;height:500px" src="./event_image/<?php echo $evt['e_image'] ?>" alt="">
            </div>

        </div>
        <div class="col-md-6 col-12">
            <div class="details_left px-2 py-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column justify-center">
                        <div ><span style="font-size:20px">Event Start date : </span> <span class="reaminder"> <?php echo date('d-M-Y h:i',strtotime($evt['e_start'])); ?></span></div>
                        <div class="text-center reaminder">TO</div>
                        <div ><span style="font-size:20px">Event End date :</span> <span class="reaminder"> <?php echo date('d-M-Y h:i',strtotime($evt['e_end'])); ?></span></div>
                    </div>
                    <div class="reaminder">
                        <div class="text-center">Time Left</div>
                        <div id="remainderTime" class="remainderTime"></div>
                    </div>
                </div>
                <div>
                    <div style="font-size:20px">Title : <?php echo $evt['e_name'];?></div>
                    <div style="font-size:20px;display: flex;align-items: center;">Organizer By : <?php echo $creator['user_name'];?> <span style="margin-left:20px"> <i class="fas fa-award" style="font-size: 91px;"></i></span></div>
                </div>
                <div>
                    <div style="font-size:20px">Description </div>
                    <div style="font-size:17px"><?php echo $evt['e_description']; ?></div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="donation">
        <div class="donate_text">Donate</div>
        <div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-around">
                    <div class="total_V">
                        <div style="font-size: 22px;">Total Volunteers</div> 
                        <div style="font-size: 40px;font-weight: 600;"><?php echo $total_participator ?></div>                           
                    </div>
                    <div class="total_d justify-content-evenly">
                        <div>
                            <div style="font-size: 15px;">Donations</div>
                            <div style="font-size: 17px;font-weight: 600;"><?php echo $total_donation['donation'] ?> <span>TK</span></div>
                        </div>
                        <div>
                            <div style="font-size: 15px;" class="text-center">Budget</div>
                            <div style="font-size: 17px;font-weight: 600;"><?php echo $total_cost['total_donation'] ?> <span>TK</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="donate_section">
                        
                        <div>
                            <div class="row" style="column-gap:12%">
                                <a  class="col-md-3 btn py-2 click_button" data-amount="500">
                                    500 <span> ৳</span>
                                </a>
                                <a  class="col-md-3 btn py-2 click_button" data-amount="1000">
                                    1000 <span> ৳</span>
                                </a>
                                <a  class="col-md-3 btn py-2 click_button" data-amount="1500">
                                    1500 <span> ৳</span>
                                </a>
                                <a  class="col-md-3 btn py-2 click_button" data-amount="2000">
                                    2000 <span> ৳</span>
                                </a>
                                <a  class="col-md-3 btn py-2 click_button" data-amount="5000">
                                    5000 <span> ৳</span>
                                </a>
                                <a  class="col-md-3 btn py-2 click_button" data-amount="10000">
                                    10000 <span> ৳</span>
                                </a>
                            </div>
                        </div>
                        <?php if($valid_donar == 1){ ?>
                            <form action="./payment/checkout_hosted.php" method="post">
                                <div class="donate_form">
                                    <input type="text" value="<?php echo $evt['id']; ?>" id="event_id" name="event_id" class="d-none">
                                    <div class="form">
                                        <label for="" class="form-label text-black">Donation Amount</label>
                                        <input type="text" class="form-control text-black" id="donate_value" name="amount" palaceholer="500">
                                    </div>
                                    <div class="form d-flex justify-content-center">
                                        <?php if(intval($total_cost['total_donation']) >= intval($total_donation['donation'])){ ?>
                                        <button class="btn btn-lg  btn-primary w-50" type="submit">Donate</button>
                                        <?php }else{ ?>
                                            <button class="btn btn-lg  btn-success w-50"  type="button">Total donation budget filled up</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        <?php }else if($valid_donar == 2){
                            ?>
                            <div class="warinig"> Only Donar user, Donate this Event</div>
                            
                        <?php }else{
                            ?>
                            <div class="warinig"> Please Log-in and Donate this Event</div>
                       <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['user_type'])== '2'){
        ?>
        <div class="event_cost">
            <div class="location_text">Event Cost Details</div>
            <div class="row justify-content-center bg_white m-0">
                <div class="col-md-6">
                <table class="table table-bordered">
                    <thead>
                        <th scope="col" class="font_size">Cost Title</th>
                        <th scope="col" class="font_size"> Amount</th>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($all_cost)){
                                foreach($all_cost as $cost){
                                    ?>
                                        <tr>
                                            <td scope="row" class="font_size"><?php echo $cost['cost_text']; ?></td>
                                            <td scope="row" class="font_size" style="text-align:center"><?php echo $cost['cost_amount']; ?></td>
                                        </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="location">
        <div class="location_text">Event Location</div>
        <div class="google_map bg_white">
            <?php echo $evt['e_location']; ?>
        </div>
    </div>
    
    <div class="bg_white my-2 px-3">
        <h1 class="text-center">Reviews</h1>
        <div class="d-flex justify-content-between" style="border-bottom: 1px solid;padding-bottom: 6px;">
            <div class="review_left">
                <div class='d-flex' style="font-size:1.5rem">
                    <?php 
                        $count_ratings = $pdo->prepare('SELECT AVG(review) AS reviews  FROM event_review 
                        WHERE event_id=?');
                        $count_ratings->execute(array($evt['id']));
                        $totals = $count_ratings->fetch(PDO::FETCH_ASSOC);
                        // $review_sum = $totals->sum('review');
                        $review_rate =  round($totals['reviews']);
                        $review_rate_false = 5 - $review_rate;
                    ?>
                    <div class="review_details" style='color:orange'>
                        <?php for ($i=0; $i < $review_rate; $i++) { ?>
                            <i class="fas fa-star"></i>
                        <?php } if($review_rate_false > 0){
                            for ($i=0; $i < $review_rate_false ; $i++) { 
                                ?>
                                <i class="far fa-star"></i>
                                <?php } } ?>

                    </div>
                    <div class="mx-2">
                        <?php echo $review_rate?> out of 5
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal -->
         <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <form action="" method="post">
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
                    </form>
                    
                    
                </div>
                <input type="text" id="user_id" class="d-none" value='<?php if(isset($_SESSION['user_id'])){echo $_SESSION['user_id'];}else{ echo -1;} ?>'>
                <input type="number" id="event_id" class="d-none" value='<?php echo $evt['id'];?>'>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary w-50" id="rating_post">POST</button>
                </div>
                </div>
            </div>
        </div>                       
        <div class="total_details">
            <?php
                $rent_ratings = $pdo->prepare('SELECT  event_review.review_text AS review_text,event_review.review AS review, event_review.created_at AS created_at, volunteer.user_name AS userName FROM event_review 
                JOIN event ON event.id = event_review.event_id 
                JOIN volunteer on volunteer.volunteer_id = event_review.by_id 
                WHERE event_id=? AND review_status=?');
                
                $rent_ratings->execute(array($evt['id'],1));
                $totals = $rent_ratings->fetchAll(PDO::FETCH_ASSOC);

                $donor_rent_ratings = $pdo->prepare('SELECT  event_review.review_text AS review_text,event_review.review AS review, event_review.created_at AS created_at, donor.user_name AS userName FROM event_review 
                JOIN event ON event.id = event_review.event_id 
                JOIN donor on donor.donor_id = event_review.by_id 
                WHERE event_id=? AND review_status=?');
                
                $donor_rent_ratings->execute(array($evt['id'],1));
                $donor_totals = $donor_rent_ratings->fetchAll(PDO::FETCH_ASSOC);

                if($totals){
                    foreach ($totals as $review) {
                        $rating_true = $review['review'];
                        $rating_false = 5 - $rating_true;
                        ?>
                        
                        <div class="py-2" style="border-bottom:1px solid">
                            <div>
                                <span>By </span>
                                <span style="font-weight: bold;color: blue;"><?php echo $review['userName'] ;?> </span>
                            </div>
                            <div><?php echo $review['review_text']; ?></div>
                            <div class="review_details" style='color:orange'>
                                <?php for ($i=0; $i <$rating_true ; $i++) { 
                                    ?>
                                    <i class="fas fa-star"></i>
                                <?php } 
                                    if($rating_false > 0){
                                        for ($i=0; $i <$rating_false ; $i++) { 
                                            ?>
                                            <i class="far fa-star"></i>
                                        <?php } 
                                    }
                                
                                ?>

                                
                            </div>
                            <div style="font-size:0.8rem">
                                <span><?php $date = date_create($review['created_at']); echo date_format($date, 'd M Y') ?> </span>
                            </div>
                        </div>
                <?php }} ?>

                <?php if($donor_totals){
                    foreach ($donor_totals as $review) {
                        $rating_true = $review['review'];
                        $rating_false = 5 - $rating_true;
                        ?>
                        
                        <div class="py-2" style="border-bottom:1px solid">
                            <div>
                                <span>By </span>
                                <span style="font-weight: bold;color: blue;"><?php echo $review['userName'] ;?> </span>
                            </div>
                            <div><?php echo $review['review_text']; ?></div>
                            <div class="review_details" style='color:orange'>
                                <?php for ($i=0; $i <$rating_true ; $i++) { 
                                    ?>
                                    <i class="fas fa-star"></i>
                                <?php } 
                                    if($rating_false > 0){
                                        for ($i=0; $i <$rating_false ; $i++) { 
                                            ?>
                                            <i class="far fa-star"></i>
                                        <?php } 
                                    }
                                
                                ?>

                                
                            </div>
                            <div style="font-size:0.8rem">
                                <span><?php $date = date_create($review['created_at']); echo date_format($date, 'd M Y') ?> </span>
                            </div>
                        </div>
                <?php } }?>
                <?php if(empty($totals) and empty($donor_totals)){
                    ?>
                    <div class="py-2" style="border-bottom:1px solid">
                        <h3 class="text-center py-3 text-dark">No reviews</h3>
                    </div>
                <?php } ?>
            
            
        </div>
    </div>
</div>
<?php include('./footer.php'); ?>
<script>
    var end_date = "<?php echo $evt['e_end'] ?>";
    var countDownDate = new Date(end_date).getTime();
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        $("#remainderTime").text(days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ");
        if (distance < 0) {
            clearInterval(x);
            $("#remainderTime").text("Close");
        }
        
    }, 1000);

    var all_buttons = document.querySelectorAll('.click_button');
    var value_change = 0;
    all_buttons.forEach((button)=>{
        button.addEventListener('click',function(){
            $('#donate_value').val($(this).attr('data-amount'));
            buttonColorChange()
            $(this).addClass('click_active');
        })
    })
    function buttonColorChange(){
        all_buttons.forEach((button)=>{
            button.classList.remove('click_active');
        })
    }
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
        var user_id = $('#user_id').val()
        var review_text = $('#review_text').val();
        var action = 'post'
        console.log(event_id)
        console.log(user_id)
        console.log(review_text)
        console.log(rating)
        if(parseInt(user_id) > 0){
            $.ajax({
                type:'POST',
                url:'./event_rating.php',
                data:{
                    event_id:event_id,
                    user_id:user_id,
                    rating:rating,
                    review_text:review_text,
                    action:action
                },
                success:(response)=>{
                    if(response == 'Success'){
                        location.reload();
                    }else{
                        alert('Some thing worng');
                    }
                }
            });
        }else{
            alert('Please Login and try again')
        }
    })

    $('#submit_donate').on('click',()=>{
        var event_id = $("#event_id").val();
        var donate_amount = $('#donate_value').val();
        $.ajax({
            type:"POST",
            url:'./event-donate.php',
            data:{
                event:event_id,
                amount:donate_amount,
                action:"donate"
            },
            success:(response)=>{
                var data = JSON.parse(response)
                if(data['status'] =='success'){
                    alert("your donation successly");
                    location.reload()
                }else{
                    alert("opps! some errors");
                }
                
            }
        })
    })


</script>