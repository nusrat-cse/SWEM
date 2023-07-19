

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
      $('#noticationSection').on('click',()=>
        {
          var user_id = "<?php echo $_SESSION['user_id']; ?>";
          var user_type = "<?php echo $_SESSION['user_type']; ?>";
          $.ajax({
            type:'POST',
            url:'notification-status-chage.php',
            data:{
              user:user_id,
              type:user_type
            },
            success:(res)=>{
              console.log(res);
            }
            
          })
        }
      );
      function notification(notification_id){
        var id = notification_id;
        $.ajax({
          type:'POST',
          url:'notification-event-show.php',
          data:{
            id:id
          },
          success:(res)=>{
            console.log(res)
          }
        })
      }
    </script>
  </body>
</html>