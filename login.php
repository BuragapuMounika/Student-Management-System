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
                    <span><a href="index.php" class="btn btn-success" style="float: left;">HOME</a></span>
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
    $password = $_POST['password']; // Do not escape this since we will use password_verify()

    // Fetch user from the database
    $qry = "SELECT * FROM admin WHERE username='$user'";
    $run = mysqli_query($conn, $qry);

    if (!$run) {
        die("SQL Error: " . mysqli_error($conn)); // Debugging SQL errors
    }


    $qry = "SELECT * FROM admin WHERE username='$user'";
echo "SQL Query: " . $qry . "<br>"; // Debugging line

$run = mysqli_query($conn, $qry);
if (!$run) {
    die("SQL Error: " . mysqli_error($conn));
}


    $row = mysqli_num_rows($run);
    if ($row > 0) {
        $data = mysqli_fetch_assoc($run);
        $db_password = $data['password']; // Stored password (hashed or plain text)

        // Check if the password is hashed (if it starts with "$2y$", it is hashed)
        if (password_needs_rehash($db_password, PASSWORD_DEFAULT)) {
            // Password is plain text, directly compare
            if ($password == $db_password) {
                // Update the password to hashed version
                $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE admin SET password='$new_hashed_password' WHERE id=".$data['id']);
                
                $_SESSION['uid'] = $data['id'];
                header('location:admin/admindash.php');
            } else {
                echo "<script>alert('Invalid password.'); window.open('login.php', '_self');</script>";
            }
        } else {
            // Password is already hashed, verify using password_verify()
            if (password_verify($password, $db_password)) {
                $_SESSION['uid'] = $data['id'];
                header('location:admin/admindash.php');
            } else {
                echo "<script>alert('Invalid password.'); window.open('login.php', '_self');</script>";
            }
        }
    } else {
        echo "<script>alert('No user found.'); window.open('login.php', '_self');</script>";
    }
}
?>

<?php include('footer.php') ?>
