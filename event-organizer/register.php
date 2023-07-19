<?php include('header.php'); ?>
<div class="row d-flex justify-content-center form-container">
    <div class="col-md-6 col-12 rg-background">
        <div class="p-2 sign-text">Sign Up</div>
        <form action="#" method="post">
            <div class="form">
                <label for="" class="form-label">User name</label>
                <input type="text" class="form-control" placeholder="user name">
            </div>
            <div class="form">
                <label for="" class="form-label">Email Address</label>
                <input type="text" class="form-control" placeholder="email address">
            </div>
            <div class="form">
                <label for="" class="form-label">Mobile number</label>
                <input type="number" class="form-control" placeholder="mobile number">
            </div>
            <div class="form">
                <label for="" class="form-label">User type</label>
                <select class="form-select">
                    <option selected>Select user type</option>
                    <option value="1">Participator</option>
                    <option value="2">Donar</option>
                    <option value="3">Event Organizer</option>
                </select>
            </div>
            <div class="form">
                <label for="" class="form-label">password</label>
                <input type="password" class="form-control" placeholder="password">
            </div>
            <div class="form">
                <label for="" class="form-label">Confirm password</label>
                <input type="password" class="form-control" placeholder="confirm password">
            </div>
            <div class="form d-flex justify-content-center">
                <button type="submit" class="w-50 btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php include('footer.php') ?>