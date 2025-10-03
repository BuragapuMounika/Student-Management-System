<?php require_once('../include/Session.php'); ?>
<?php require_once('../include/Functions.php'); ?>
<?php echo AdminAreaAccess(); ?>

<?php include('../header.php'); ?>
<?php include('admin.header.php'); ?>

<div class="container jumbotron">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">INSERT STUDENT DETAIL</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    Roll No.: <input type="text" class="form-control" name="roll" placeholder="Enter Roll No." required>
                </div>
                <div class="form-group">
                    Full Name: <input type="text" class="form-control" name="fullname" placeholder="Enter Full Name" required>
                </div>
                <div class="form-group">
                    City: <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                </div>
                <div class="form-group">
                    Parent Phone No.: <input type="text" class="form-control" name="pphone" placeholder="Enter Parent Phone No." required>
                </div>
                <div class="form-group">
                    Year: 
                    <select class="form-control" name="standard" required>
                        <option value="">Select Year</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
						<option value="4">Year 4</option>
                    </select>
                </div>
                <div class="form-group">
                    Image: <input type="file" class="form-control" name="simg" required>
                </div>
                <button type="submit" name="submit" class="btn btn-success btn-lg">INSERT</button>
            </form>
        </div>
    </div>
</div>

<?php include('../footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    if (!empty($_POST['roll']) && !empty($_POST['fullname']) && !empty($_POST['standard']) && isset($_FILES['simg']['name'])) {
        include('../dbcon.php');

        $roll = mysqli_real_escape_string($conn, $_POST['roll']);
        $name = mysqli_real_escape_string($conn, $_POST['fullname']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $pphone = mysqli_real_escape_string($conn, $_POST['pphone']);
        $standard = mysqli_real_escape_string($conn, $_POST['standard']);

        // Handling Image Upload
        $imageName = $_FILES['simg']['name'];
        $imageTmpName = $_FILES['simg']['tmp_name'];

        if (!empty($imageName)) {
            $targetDirectory = '../images/' . $imageName;
            move_uploaded_file($imageTmpName, $targetDirectory);
 
            $sql = "INSERT INTO `student` (`rollno`, `name`, `city`, `pcontact`, `standard`, `image`) VALUES ('$roll', '$name', '$city', '$pphone', '$standard', '$imageName')";

            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>Student Added Successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Please upload an image.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Please fill in all required fields.</div>";
    }
}
?>
