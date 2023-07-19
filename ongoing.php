<section class="event_section d-flex justify-content-center">
    <div class="container row justify-content-center" style="row-gap:7px">
        <div class="col-md-12">
            <div class="text-center py-3" style="font-size: 30px;font-weight: 800;font-family: serif;">Ongoing Events</div>
        </div>
        <?php foreach($onging_totalls as $event){
            $event_cost = $pdo->prepare("SELECT SUM(cost_amount) AS total_donation FROM event_cost WHERE event_id=?");
            $event_cost->execute(array(intval($event['id'])));
            $total_cost = $event_cost->fetch();

            $donation = $pdo->prepare("SELECT SUM(donation_amount) AS donation FROM accounts WHERE event_id=?");
            $donation->execute(array(intval($event['id'])));
            $total_donation = $donation->fetch();
            if($event['event_status'] == 2){
            ?>
        
            <div class="col-md-4 col-lg-3 col-12">
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
                        <div class="d-flex justify-content-between">
                            <?php if($validite == 1){ 
                                $user_type = 0;
                                $user_type = intval($_SESSION['user_type']);
                                if($user_type == 2){  
                                    if($total_cost >= $total_donation){?> 
                                        <button class="px-2 py-1 btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#donate<?php echo $event['id'] ?>"  style="width:100%">Donate</button>
                                <?php }else{ ?>
                                    <button class="px-2 py-1 btn btn-outline-success"  style="width:100%">Donate</button>
                               <?php } } ?> 
                            <?php }else{ ?>
                                <button class="px-2 py-1 btn btn-outline-primary" onclick="volunteer(<?php echo $event['id'] ?>)" style="width:45%">volunteer</button>
                                <button class="px-2 py-1 btn btn-outline-primary" onclick="donate(<?php echo $event['id'] ?>)" style="width:45%">Donate</button>
                            <?php } ?>
                        </div>
                        
                        <!--donate Modal -->
                        <div class="modal fade" id="donate<?php echo $event['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                <input type="text" value="<?php echo $event['id']; ?>" name="event_id" id="event_id" class="d-none">
                                                <div class="form">
                                                    <label for="" class="form-label text-black">Donation Amount</label>
                                                    <input type="text" class="form-control text-black" id="donate_value<?php echo $event['id']?>" name="amount" palaceholer="500">
                                                </div>
                                                <div class="form d-flex justify-content-center">
                                                    <button class="btn btn-lg  btn-primary w-50" type="submit">Donate Now</button>
                                                    <!-- <button class="btn btn-lg  btn-primary w-50" onclick="submit_donate(<?php echo $event['id']?>)" type="button">Donate Now</button> -->
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
        <?php } } ?>
        <div class="col-md-12 col-12 py-3">
            <div class="d-flex justify-content-end">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if($select_page > 1){
                            ?>
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <?php }
                        
                         for ($i=1; $i <= $ongoing_total_page; $i++) {
                            if($i == $select_page){
                                $active ="active";
                            }else{
                                $active ="";
                            }
                            ?>
                            <li class="page-item <?php echo $active ?>"><a class="page-link" href="./index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php } 
                            if($ongoing_total_page > $select_page){
                                ?>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            <?php }
                        ?>
                        
                        
                    </ul>
                </nav>
            </div> 
            
        </div>
    </div>
    
              
</section>