<section class="event_section d-flex justify-content-center">
    <div class="container row justify-content-center" style="row-gap:7px">
        <div class="col-md-12">
            <div class="text-center py-3" style="font-size: 30px;font-weight: 800;font-family: serif;">Completed Events</div>
        </div>
        <?php foreach($close_totalls as $event){
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
                            <button class="px-2 py-1 btn btn-outline-danger"  style="width:100%">Completed</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-12 justify-content-end d-flex">
            <div>
                <a href="./close-event.php" style="letter-spacing: 4px;">More..</a>
            </div>
            
        </div>
    </div>
    
              
</section>