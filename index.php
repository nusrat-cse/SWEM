<?php include("./header.php"); ?>
<?php require("./config.php"); 
    global $pdo;
    $limits=5; 
    if(isset($_GET['page'])){
        $select_page = $_GET['page'];
    }else{
        $select_page = 1;
    }
    
    $offset = ($select_page - 1) * $limits;
    
    $events = $pdo->prepare("SELECT * FROM event WHERE status=:status AND event_status=:event_status ORDER BY  priority DESC, id DESC LIMIT :skip ,:max");
    $events->bindValue(':skip',$offset,PDO::PARAM_INT);
    $events->bindValue(':max',$limits,PDO::PARAM_INT);
    $events->bindValue(':status',1,PDO::PARAM_INT);
    $events->bindValue(':event_status',1,PDO::PARAM_INT);
    $events->execute();
    $totalls = $events->fetchAll();
    foreach($totalls as $event){
        $event_paritcipator = $pdo->prepare("SELECT COUNT(id) AS total_paritcipator FROM participator WHERE event_id=? AND status=?");
        $event_paritcipator->execute(array(intval($event['id']),1));
        $total_paritcipator = $event_paritcipator->fetch();
        if($event['total_volunteer'] <= $total_paritcipator['total_paritcipator']){
            $update_status = $pdo->prepare("UPDATE event SET event_status=? WHERE id=?");
            $update_status->execute(array(2,intval($event['id'])));
        }

        // $event_cost = $pdo->prepare("SELECT SUM(cost_amount) AS total_donation FROM event_cost WHERE event_id=?");
        // $event_cost->execute(array(intval($event['id'])));
        // $total_cost = $event_cost->fetch();

        // $donation = $pdo->prepare("SELECT SUM(amount) AS donation FROM donate WHERE event_id=?");
        // $donation->execute(array(intval($event['id'])));
        // $total_donation = $donation->fetch();
        // if($total_cost <= $total_donation){
        //     $update_status = $pdo->prepare("UPDATE event SET event_status=? WHERE id=?");
        //     $update_status->execute(array(3,intval($event['id'])));
        // }
    }
    $user_type = isset($_SESSION['user_type']);
    $validite = 0;
    if(isset($_SESSION['user_id']) and $user_type == '1'){
        $validite = 1;
    }else{
        $validite = 0;;
    }
    if(isset($_SESSION['user_id']) and $user_type == '2'){
        $validite = 1;
    }else{
        $validite = 0;;
    }
    // proposed event
    $proposed_total_events = $pdo->prepare("SELECT * FROM event WHERE status=? AND event_status=?");
    $proposed_total_events->execute(array(1,1));
    $proposed_total_event = $proposed_total_events->rowCount();
    $proposed_total_page = ceil($proposed_total_event/$limits);
    // ongoing events
    $ongoing_events = $pdo->prepare("SELECT * FROM event WHERE status=:status AND event_status=:event_status ORDER BY  priority DESC, id DESC LIMIT :skip ,:max");
    $ongoing_events->bindValue(':skip',$offset,PDO::PARAM_INT);
    $ongoing_events->bindValue(':max',$limits,PDO::PARAM_INT);
    $ongoing_events->bindValue(':status',1,PDO::PARAM_INT);
    $ongoing_events->bindValue(':event_status',2,PDO::PARAM_INT);
    $ongoing_events->execute();
    $onging_totalls = $ongoing_events->fetchAll();

    $ongoing_total_events = $pdo->prepare("SELECT * FROM event WHERE status=? AND event_status=?");
    $ongoing_total_events->execute(array(1,2));
    $ongoing_total_event = $ongoing_total_events->rowCount();
    $ongoing_total_page = ceil($ongoing_total_event/$limits);
    
    // close events
    $close_events = $pdo->prepare("SELECT * FROM event WHERE status=:status AND event_status=:event_status ORDER BY priority DESC,id DESC LIMIT 4");
    $close_events->bindValue(':status',1,PDO::PARAM_INT);
    $close_events->bindValue(':event_status',3,PDO::PARAM_INT);
    $close_events->execute();
    $close_totalls = $close_events->fetchAll();
?>
<!-- home section starts  -->
<style>
    .home{
        min-height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .content{
        color:white
    }
    .content h1{
        font-weight: 800;
        font-variant: small-caps;
        font-size: 3rem;
    }
    .content p{
        font-size:1.4rem
    }
    .explode{
        height: 3.5rem;
        width: 15rem;
        background: none;
        outline: none;
        border: .2rem solid var(--green);
        color: var(--green);
        font-size: 2rem;
        margin: 1rem 0;
        cursor: pointer;
        overflow: hidden;
        z-index: 0;
        position: relative;
    }
    .explode::before{
        clip-path: polygon(0 0, 0 0, 0 0);
    }

    .explode:hover:before{
        clip-path: polygon(0 0, 0 100%, 100% 0);
    }

    .explode::after{
        clip-path: polygon(100% 100%, 100% 100%, 100% 100%);
    }

    .explode:hover:after{
        clip-path: polygon(100% 0%, 0% 100%, 100% 100%);
    }

    .explode:hover{
        color:#fff;
    }
    .project{
        background:#333;
        min-height: 100vh;
    }
    .heading {
        text-align: center;
        font-size: 4rem;
        color: #555;
        padding: 1rem;
        padding-top: 7rem;
    }

    .project .heading{
        color:#fff;
    }

    .project .box-container{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding:2rem 0;
        width: 90%;
        margin:0 auto;
    }

    .project .box-container .box{
        flex: 1 1 30rem;
        height: 22rem;
        box-shadow: 0 .3rem .5rem #000;
        overflow: hidden;
        position: relative;
        margin:1rem;
    }

    .project .box-container .box img{
        height:100%;
        width:100%;
        object-fit: cover;
    }

    .project .box-container .box .icons{
        height:100%;
        width:100%;
        position: absolute;
        top:100%; left: 0;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        background:linear-gradient(transparent, rgba(0,0,0,.7));
        transform: scale(0);
    }

    .project .box-container .box:hover .icons{
        top:0;
        transform: scale(1);
    }

    .project .box-container .box .icons a{
        font-size: 3rem;
        color:#fff;
        margin:3rem 0;
        text-shadow: 0 .3rem .5rem #000;
        transform: translateY(13rem);
        transition-delay: calc(.2s * var(--i));
    }

    .project .box-container .box:hover .icons a{
        transform: translateY(0rem);
    }
    .click_button{
        font-size:20px
    }
    .click_button:hover,.click_active{
        background: yellowgreen;
    }
</style>
<section class="home" id="home">

    <div class="content">
        <h1>better nature</h1>
        <h1> better tomorrow</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore,<br> earum ea dolores commodi iste sed
            nobis. Ab, quidem. Eum, delectus?</p>
        <a href="./index.php" class="explode btn btn-outline-danger">explore.</a>

    </div>

</section>

<!-- home section ends -->
<?php include('./proposed.php') ?>
 <!-- project section starts  -->
<!-- home section ends -->
<?php include('./ongoing.php') ?>
 <!-- project section starts  -->
<section class="project" id="project">

    <h1 class="heading"> <i class="fas fa-quote-left"></i> our projects <i class="fas fa-quote-right"></i> </h1>

    <div class="box-container">

        <div class="box">
            <img src="./public/image/img1.jpg" alt="">
            <div class="icons">
                <a style="--i:1;" href="#" class="fas fa-heart"></a>
                <a style="--i:2;" href="#" class="fas fa-share"></a>
                <a style="--i:3;" href="#" class="fas fa-comment"></a>
            </div>
        </div>

        <div class="box">
            <img src="./public/image/img2.jpg" alt="">
            <div class="icons">
                <a style="--i:1;" href="#" class="fas fa-heart"></a>
                <a style="--i:2;" href="#" class="fas fa-share"></a>
                <a style="--i:3;" href="#" class="fas fa-comment"></a>
            </div>
        </div>

        <div class="box">
            <img src="./public/image/img3.jpg" alt="">
            <div class="icons">
                <a style="--i:1;" href="#" class="fas fa-heart"></a>
                <a style="--i:2;" href="#" class="fas fa-share"></a>
                <a style="--i:3;" href="#" class="fas fa-comment"></a>
            </div>
        </div>

        <div class="box">
            <img src="./public/image/img4.jpg" alt="">
            <div class="icons">
                <a style="--i:1;" href="#" class="fas fa-heart"></a>
                <a style="--i:2;" href="#" class="fas fa-share"></a>
                <a style="--i:3;" href="#" class="fas fa-comment"></a>
            </div>
        </div>

        <div class="box">
            <img src="./public/image/img5.jpg" alt="">
            <div class="icons">
                <a style="--i:1;" href="#" class="fas fa-heart"></a>
                <a style="--i:2;" href="#" class="fas fa-share"></a>
                <a style="--i:3;" href="#" class="fas fa-comment"></a>
            </div>
        </div>

        <div class="box">
            <img src="./public/image/img6.jpg" alt="">
            <div class="icons">
                <a style="--i:1;" href="#" class="fas fa-heart"></a>
                <a style="--i:2;" href="#" class="fas fa-share"></a>
                <a style="--i:3;" href="#" class="fas fa-comment"></a>
            </div>
        </div>

    </div>

</section>


<?php include('./complete.php')?>
<!-- project section ends -->
<?php include('footer.php') ?>
<script>
    function volunteer(event_id){
        alert('Please login first and try again');
    }
    function donate(event_id){
        alert('Please login first and try again');
    }
    var all_buttons = document.querySelectorAll('.click_button');
    var value_change = 0;
    all_buttons.forEach((button)=>{
        button.addEventListener('click',function(){
            var donateamount_id = $(this).attr('data-id');
            var currect_id = "#"+donateamount_id;
            $(currect_id).val($(this).attr('data-amount'));
            buttonColorChange()
            $(this).addClass('click_active');
        })
    })

    function submit_donate(id){
        var event_id = id;
        var donate_amount_id = "#donate_value"+event_id;
        var donate_amount = $(donate_amount_id).val();
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
    }
    function buttonColorChange(){
        all_buttons.forEach((button)=>{
            button.classList.remove('click_active');
        })
    }
    
</script>
