<!DOCTYPE html>
<html lang="en">
<head>
    <title>School Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="container-wraper">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="header-image"></div>
        </div>
        <div class="col-sm-4 col-md-4 col-md-offset-4">
            <center>
                <div class='schoollogo'></div>
            </center>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="alert alert-dismissible alert-danger alert-form-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <span class="text-alert">All data should be corrected please check the red and enter correct data.</span>
                    </div>
                    <form class="login100-form validate-form" method="post">
                        <div class="form-group" data-validate="Please choose school">
                            <select class="form-control schoolname" name="schoolname" placeholder="Choose your school">
                                <option>Choose a school</option>
                            </select>
                            <span class="text-danger error-schoolname"></span>
                        </div>
                        <div class="form-group" data-validate="Valid email is required: example@gmail.com">
                            <input class="form-control email" type="text" name="email" placeholder="Email Address">
                            <span class="text-danger error-email"></span>
                        </div>

                        <div class="form-group" data-validate="Password is required">
                            <input class="form-control password" type="password" name="pass" placeholder="Password">
                            <span class="text-danger error-password"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-primary login100-form-btn" type="submit">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="assets/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="assets/bootstrap/js/popper.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="assets/daterangepicker/moment.min.js"></script>
<!--===============================================================================================-->
<script src="assets/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/login.js"></script>
</body>
</html>