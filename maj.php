<?php
include_once 'bdd/bdd.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />

    <!------ Include the above in your HEAD tag ---------->
</head>
<body id="LoginForm">
    <div class="container">
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h2>Admin Login</h2>
                    <p>Please enter your id and password</p>
                </div>
                <form action="script/traitementConnexion.php" method="POST" id="Login">

                    <div class="form-group">


                        <input type="text" name="id" class="form-control"  placeholder="Id" required>

                    </div>

                    <div class="form-group">

                        <input type="password" name="password" class="form-control"  placeholder="Password" required>

                    </div>
                    <div class="forgot">
                        <a href="#">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>

                </form>
            </div>
        </div>
    </div>
    </div>


</body>

</html>