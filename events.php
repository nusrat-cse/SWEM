<?php include("./header.php"); ?>
<?php require("./config.php"); 
    global $pdo;
    $limits=4; 
    if(isset($_GET['page'])){
        $select_page = $_GET['page'];
    }else{
        $select_page = 1;
    }
    
    $offset = ($select_page - 1) * $limits;
    
    $events = $pdo->prepare("SELECT * FROM event WHERE status=:status ORDER BY priority DESC,id DESC");
    // $events->bindValue(':skip',$offset,PDO::PARAM_INT);
    // $events->bindValue(':max',$limits,PDO::PARAM_INT);
    $events->bindValue(':status',1,PDO::PARAM_INT);
    $events->execute();
    $totalls = $events->fetchAll();
    $user_type = isset($_SESSION['user_type']);
    $validite = 0;
    if(isset($_SESSION['user_id']) and $user_type == '1'){
        $validite = 1;
    }else{
        $validite = 0;;
    }
    $d_validite = 0;
    if(isset($_SESSION['user_id']) and $user_type == '2'){
        $d_validite = 1;
    }else{
        $d_validite = 0;;
    }
    
    $total_events = $pdo->prepare("SELECT * FROM event WHERE status=?");
    $total_events->execute(array(1));
    $total_event = $total_events->rowCount();
    
    $total_page = ceil($total_event/$limits);

    $event_type = $pdo->prepare('SELECT * FROM event_type');
    $event_type->execute();
    $event_types = $event_type->fetchAll();
    $types = '';
    foreach($event_types as $type){
        $types .='<option  value="'.$type['name'].'">'.$type['name'].'</option>';
    }
    
?>
<style>
    
    .home{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('./public/image/home-bg.jpg') no-repeat;
        background-size: cover;
        background-position: center;
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
<!-- home section starts  -->


<section class="event_section d-flex justify-content-center">
    <div class="container row justify-content-center"  style="row-gap:7px">
        <div class="col-md-12 d-flex justify-content-center" style="height:min-content">
            <div class="text-center py-3 d-flex" style="font-size: 30px;font-weight: 800;font-family: serif;">
                <select class="form-select font_weight" name="event_type" style="width: 130px;" id="eventType">
                    <option selected value="">Event type</option>
                    <?php echo $types; ?>
                </select>
                <input type="text" class="form-control" id="search_value" placeholder="search....">
                <button class="btn btn-primary text-white" id="search_button">search</button>
            </div>
            
        </div>
        <div class="col-md-12">
            <div class="row" id="events">
                <?php foreach($totalls as $event){
                    $event_cost = $pdo->prepare("SELECT SUM(cost_amount) AS total_donation FROM event_cost WHERE event_id=?");
                    $event_cost->execute(array(intval($event['id'])));
                    $total_cost = $event_cost->fetch();
        
                    $donation = $pdo->prepare("SELECT SUM(donation_amount) AS donation FROM accounts WHERE event_id=?");
                    $donation->execute(array(intval($event['id'])));
                    $total_donation = $donation->fetch();
                ?>
            
                <div  class="col-md-4 col-lg-3 col-12">
                    <div class="event-card bg-white px-3 py-2 text-white rounded">
                        <div>
                            <div>
                                <img style="width:100%;height:250px" src="./event_image/<?php echo $event['e_image']; ?>" alt="">
                            </div>
                            <div class="py-2">
                                <a class="event_card_link" href="./event-details.php?id=<?php echo $event['id'] ?>">
                                    <div class="text-center card_title">
                                        <?php echo $event['e_name']; ?>
                                    </div>
                                    
                                </a>
                            </div>
                            <div class="py-2">
                                <div class="card_description text-black">
                                    <?php echo $event['e_description']; ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between py-3">
                                <?php if($validite == 1){
                                    ?>
                                        <button class="px-2 py-1 btn btn-outline-primary" style="width:45%" data-bs-toggle="modal" data-bs-target="#volunteer<?php echo $event['id'] ?>">volunteer</button>
                                <?php }else{ ?>
                                        <button class="px-2 py-1 btn btn-outline-primary" onclick="volunteer(<?php echo $event['id'] ?>)" style="width:45%">volunteer</button>
                                    <?php } ?>
                                
                                <?php if($d_validite == 1){
                                    if(intval($total_cost['total_donation']) >= intval($total_donation['donation'])){
                                        ?>
                                        <button class="px-2 py-1 btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#donate<?php echo $event['id'] ?>"  style="width:45%">Donate</button>
                                    <?php }else{ ?>
                                        <button class="px-2 py-1 btn btn-outline-danger"  style="width:45%">Finish</button>
                                    <?php } }else{ ?>
                                        <button class="px-2 py-1 btn btn-outline-primary" onclick="donate(<?php echo $event['id'] ?>)" style="width:45%">Donate</button>
                                    <?php } ?>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="volunteer<?php echo $event['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-black" id="staticBackdropLabel">Are you sure ? <br> Click participate now button</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="./volunteer_request.php" method="post">
                                                <input type="text" value="<?php echo $event['id'] ?>" class="d-none" name="event_id">
                                                <button type="submit" class="btn btn-lg btn-primary w-100">Participate Now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end volunteer modal -->
                            <!--donate Modal -->
                            <div class="modal" id="donate<?php echo $event['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-black" id="staticBackdropLabel">Please Donate this event</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <div class="row" style="column-gap:12%">
                                                    <a class="col-md-3 btn py-2 click_button" data-amount="500" data-id="donate_value<?php echo $event['id']?>">
                                                        500 <span> ৳</span>
                                                    </a>
                                                    <a class="col-md-3 btn py-2 click_button" data-amount="1000" data-id="donate_value<?php echo $event['id']?>" >
                                                        1000 <span> ৳</span>
                                                    </a>
                                                    <a class="col-md-3 btn py-2 click_button" data-amount="1500" data-id="donate_value<?php echo $event['id']?>" >
                                                        1500 <span> ৳</span>
                                                    </a>
                                                    <a class="col-md-3 btn py-2 click_button" data-amount="2000" data-id="donate_value<?php echo $event['id']?>" >
                                                        2000 <span> ৳</span>
                                                    </a>
                                                    <a class="col-md-3 btn py-2 click_button" data-amount="5000" data-id="donate_value<?php echo $event['id']?>">
                                                        5000 <span> ৳</span>
                                                    </a>
                                                    <a class="col-md-3 btn py-2 click_button" data-amount="10000" data-id="donate_value<?php echo $event['id']?>">
                                                        10000 <span> ৳</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <form action="./payment/checkout_hosted.php" method="post">
                                                <div class="donate_form">
                                                    <input type="text" value="<?php echo $event['id']; ?>" id="event_id" name="event_id" class="d-none">
                                                    <div class="form">
                                                        <label for="" class="form-label text-black">Donation Amount</label>
                                                        <input type="text" class="form-control text-black" name="amount" id="donate_value<?php echo $event['id']?>" palaceholer="500">
                                                    </div>
                                                    <div class="form d-flex justify-content-center">
                                                        <button class="btn btn-lg  btn-primary w-50"  type="submit">Donate Now</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end donate modal -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
              
</section>

<?php include('footer.php') ?>
<script>
    $('#eventType').on('change',()=>{
        var type = $("#eventType").val()
        console.log(type)
        $('#search_value').val(type)
    })
    $("#search_button").on('click',()=>{
        var search = $('#search_value').val();
        var action = "search";
        $.ajax({
            type:"POST",
            url:"./search_event.php",
            data:{
                search : search,
                action:action
            },
            success:(response)=>{
                $('#events').empty()
                var data = JSON.parse(response)
                if(data['total'] > 0){
                    var value ='';
                    data['events'].forEach(event => {
                        value += '<div class="col-md-4 col-lg-3 col-12">'+
                                        '<div class="event-card bg-white px-3 py-2 text-white rounded">'+
                                            '<div>'+
                                                '<div>'+
                                                    '<img style="width:100%;height:250px" src="./event_image/'+event['e_image']+'" alt="">'+
                                                '</div>'+
                                                '<div class="py-2">'+
                                                    '<a class="event_card_link" href="./event-details.php?id=<?php echo $event['id'] ?>">'+
                                                        '<div class="text-center card_title">'+event['e_name']+'</div>'+
                                                        
                                                    '</a>'+
                                                '</div>'+
                                                '<div class="py-2">'+
                                                    '<div class="card_description text-black">'+event['e_description']+'</div>'+
                                                '</div>'+
                                                '<div class="d-flex justify-content-between py-3">'+
                                                    <?php if($validite == 1){
                                                        ?>
                                                            '<button class="px-2 py-1 btn btn-outline-primary" style="width:45%" data-bs-toggle="modal" data-bs-target="#volunteer'+event['id']+'">volunteer</button>'+
                                                    <?php }else{ ?>
                                                            '<button class="px-2 py-1 btn btn-outline-primary" onclick="volunteer('+event['id'] +')" style="width:45%">volunteer</button>'+
                                                        <?php } ?>
                                                    
                                                    <?php if($d_validite == 1){
                                                        ?>
                                                            '<button class="px-2 py-1 btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#donate'+event['id']+'"  style="width:45%">Donate</button>'+
                                                    <?php }else{ ?>
                                                            '<button class="px-2 py-1 btn btn-outline-primary" onclick="donate('+ event['id'] +')" style="width:45%">Donate</button>'+
                                                        <?php } ?>
                                                '</div>'+
                                                '<div class="modal fade" id="volunteer'+event['id'] +'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">'+
                                                    '<div class="modal-dialog">'+
                                                        '<div class="modal-content">'+
                                                            '<div class="modal-header">'+
                                                                '<h5 class="modal-title text-black" id="staticBackdropLabel">Are you sure ? <br> Click participatore Now button</h5>'+
                                                                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'+
                                                            '</div>'+
                                                            '<div class="modal-body">'+
                                                                '<form action="./volunteer_request.php" method="post">'+
                                                                    '<input type="text" value="'+event['id'] +'" class="d-none" name="event_id">'+
                                                                   '<button type="submit" class="btn btn-lg btn-primary w-100">Participate Now</button>'+
                                                                '</form>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div class="modal fade" id="donate'+event['id'] +'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">'+
                                                    '<div class="modal-dialog">'+
                                                        '<div class="modal-content">'+
                                                            '<div class="modal-header">'+
                                                                '<h5 class="modal-title text-black" id="staticBackdropLabel">Please Donate this event</h5>'+
                                                                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'+
                                                           '</div>'+
                                                            '<div class="modal-body">'+
                                                                '<div>'+
                                                                    '<div class="row" style="column-gap:12%">'+
                                                                        '<a class="col-md-3 btn py-2 click_button" onclick="donateAmount(500,'+event['id']+')">500 <span> ৳</span></a>'+
                                                                        '<a class="col-md-3 btn py-2 click_button" onclick="donateAmount(1000,'+event['id']+')">1000 <span> ৳</span></a>'+
                                                                        '<a class="col-md-3 btn py-2 click_button" onclick="donateAmount(1500,'+event['id']+')">1500 <span> ৳</span></a>'+
                                                                        '<a class="col-md-3 btn py-2 click_button" onclick="donateAmount(2000,'+event['id']+')">2000 <span> ৳</span></a>'+
                                                                        '<a class="col-md-3 btn py-2 click_button" onclick="donateAmount(5000,'+event['id']+')">5000 <span> ৳</span></a>'+
                                                                        '<a class="col-md-3 btn py-2 click_button" onclick="donateAmount(10000,'+event['id']+')">10000 <span> ৳</span></a>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<form action="./payment/checkout_hosted.php" method="post">'+
                                                                '<div class="donate_form">'+
                                                                    ' <input type="text" value="'+event['id']+'" id="event_id" name="event_id" class="d-none">'+
                                                                    '<div class="form">'+
                                                                        '<label for="" class="form-label text-black">Donation Amount</label>'+
                                                                        '<input type="text" class="form-control text-black" name="amount" id="donate_value'+event['id']+'" palaceholer="500">'+
                                                                    '</div>'+
                                                                    '<div class="form d-flex justify-content-center">'+
                                                                        '<button class="btn btn-lg  btn-primary w-50"  type="submit">Donate Now</button>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '</form>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                                
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                            
                    });
                    
                    $('#events').html(value)
                }else{
                    var no_data = "<h1 class='d-flex justify-content-center' style='height: 80vh !important;align-items: center;'>No Data</h1>";
                    $('#events').html(no_data)
                }
                
                // $('#events').html(response)
            }
        })
    })
    function donateAmount(amount,id){
        var show_id = "#donate_value"+id;
        $(show_id).val(amount)
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
        function buttonColorChange(){
        all_buttons.forEach((button)=>{
            button.classList.remove('click_active');
        })
    }
    }

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
