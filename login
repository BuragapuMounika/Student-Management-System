
// krishnashree generated code

<?php session_start();?>

<?php include('header.php') ?>
            <div class="jumbotron text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>
                                <span><a href="index.php" class="btn btn-success " style="float: left;">HOME</a></span>
                            ADMIN LOGIN
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 jumbotron">
                            <form action="login.php" method="post">
                              <div class="form-group">
                                  Username:<input type="text" class="form-control" name="user" placeholder=" Enter Username" required>
                              </div>
                            <div class="form-group">
                                  Password:<input type="password" class="form-control" name="password" placeholder="Enter Passoword" required>
                            </div>
                              <div class="form-group">
                                  <input type="submit" name="login" value="LOGIN" class="btn btn-success btn-block text-center" > 
                              </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
    include ('dbcon.php');

    if (isset($_POST['login'])) {

        $user = $_POST['user'];
        $password = $_POST['password'];
        $qry = "SELECT * FROM admin WHERE username='$user' AND password='$password'";
        
        $run  = mysqli_query($conn, $qry);

       $row = mysqli_num_rows($run);

        if($row > 0) {
         $data = mysqli_fetch_assoc($run);
                    $id= $data['id'];
                    $_SESSION['uid'] = $id;
                    header('location:admin/admindash.php');

           
        } else {
      ?>             
    <script>
        alert('username or passoword invalid');
        window.open('login.php','_self');
    </script>
    <?php
                   
                }

}
?>

<?php include('footer.php') ?>

// chatgpt generated code

<?php 
session_start();
include ('dbcon.php');
?>

<?php include('header.php') ?>
<div class="jumbotron text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>
                    <span><a href="index.php" class="btn btn-success " style="float: left;">HOME</a></span>
                    ADMIN LOGIN
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 jumbotron">
                <form action="login.php" method="post">
                    <div class="form-group">
                        Username:<input type="text" class="form-control" name="user" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        Password:<input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="LOGIN" class="btn btn-success btn-block text-center"> 
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Use a prepared statement to prevent SQL injection
    $qry = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $qry);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $user, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("SQL Error: " . mysqli_error($conn));  // Debugging line
        }

        $row = mysqli_num_rows($result);

        if ($row > 0) {
            $data = mysqli_fetch_assoc($result);
            $_SESSION['uid'] = $data['id'];
            header('location:admin/admindash.php');
        } else {
            ?>
            <script>
                alert('Username or password invalid');
                window.open('login.php', '_self');
            </script>
            <?php
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Prepared Statement Error: " . mysqli_error($conn));  // Debugging
    }
}
?>

<?php include('footer.php') ?>
