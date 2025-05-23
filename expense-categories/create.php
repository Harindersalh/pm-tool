<?php 
ob_start();
require_once '../includes/header.php';
$user_values = userProfile();

if($user_values['role'] && ($user_values['role'] !== 'hr' && $user_values['role'] !== 'admin'))
{
    $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/pm-tool';
    $_SESSION['toast'] = "Access denied. Employees only.";
    header("Location: " . $redirectUrl); 
    exit();
}
if (isset($_POST['add_expense_categories'])) {
    $name = $_POST['name'];
    $insertquery = "INSERT INTO expense_categories (name) 
    VALUES ('$name')";
if (mysqli_query($conn, $insertquery)) {
header('Location: ' . BASE_URL . '/expense-categories/index.php');
} else {
$errorMessage = mysqli_error($conn);
}
}
$user_values = userProfile();
    
if($user_values['role'] && ($user_values['role'] !== 'hr' && $user_values['role'] !== 'admin'))
{
    $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/test/pm-tool';
    $_SESSION['toast'] = "Access denied. Employees only.";
    header("Location: " . $redirectUrl); 
    exit();
};
    ?>
    <div class="row">
    <div class="col-12">
        <div class="page-title-box  pb-3 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Add New Expense Category</h4>
            <a href="./index.php" class="btn btn-primary d-flex"><i class="bx bx-left-arrow-alt me-1 fs-4"></i>Go Back</a>
        </div>
    </div>
</div>
<?php include './form.php' ?>

<?php require_once '../includes/footer.php'; ?>