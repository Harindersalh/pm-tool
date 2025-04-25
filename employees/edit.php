<?php
ob_start();
require_once '../includes/header.php';

if (isset($_POST['edit-employee'])) {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $doj = $_POST['doj'];
    $gender = $_POST['gender'];
    $phoneno = $_POST['phoneno'];
    $address = $_POST['address'];
    $jobt = $_POST['jobt'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $password = $_POST['password'];
    $passwordUpdate = '';

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $passwordUpdate = ", password = '$hashedPassword'";
    };

    $sql = "UPDATE users SET 
                name = '$name', 
                email = '$email', 
                date_of_birth = '$dob', 
                date_of_joining = '$doj', 
                gender = '$gender', 
                phone_number = '$phoneno', 
                address = '$address', 
                job_title = '$jobt', 
                role = '$role', 
                status = '$status'
              
            WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);
    header('Location: ' . BASE_URL . '/employees/index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlquery = "SELECT * FROM users WHERE id={$id} ";
    $result = mysqli_query($conn, $sqlquery);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box pb-3 d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Employee </h4>
                        <a href="./index.php" class="btn btn-primary d-flex"><i class="bx bx-left-arrow-alt me-1 fs-4"></i>Go Back</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <?php
                include 'form.php';
                ?>
            </div>

<?php }
    }
} ?>
<?php require_once '../includes/footer.php'; ?>