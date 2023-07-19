<section class="event_section d-flex justify-content-center">
    <div class="container row justify-content-center" style="row-gap:7px">
        <div class="col-md-12">
            <div class="text-center py-3" style="font-size: 30px;font-weight: 800;font-family: serif;">proposed Events</div>
        </div>
        <?php foreach($totalls as $event){

            if($event['event_status'] == 1){
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
                                if($user_type == 1){ ?>
                                    <button class="px-2 py-1 btn btn-outline-primary" style="width:100%" data-bs-toggle="modal" data-bs-target="#volunteer<?php echo $event['id'] ?>">volunteer</button>
                                <?php }?>
                            <?php }else{ ?>
                                <button class="px-2 py-1 btn btn-outline-primary" onclick="volunteer(<?php echo $event['id'] ?>)" style="width:45%">volunteer</button>
                                <button class="px-2 py-1 btn btn-outline-primary" onclick="donate(<?php echo $event['id'] ?>)" style="width:45%">Donate</button>
                            <?php } ?>
                        </div>
                        <!-- volunteer Modal -->
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
                                            <button type="submit" class="btn btn-lg btn-primary w-100">Praticipate Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end volunteer modal -->
                        
                    </div>
                </div>
            </div>
        <?php }} ?>
        <div class="col-md-12 col-12 py-3">
            <div class="d-flex justify-content-end">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if($select_page > 1){
                            ?>
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <?php }
                        
                         for ($i=1; $i <= $proposed_total_page; $i++) {
                            if($i == $select_page){
                                $active ="active";
                            }else{
                                $active ="";
                            }
                            ?>
                            <li class="page-item <?php echo $active ?>"><a class="page-link" href="./index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php } 
                            if($proposed_total_page > $select_page){
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