<?php
ob_start();
require_once '../includes/header.php';
if (isset($_POST['edit-holiday'])) {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $recurring = isset($_POST['recurring']) && $_POST['recurring'] == 1 ? 1 : 0;
    $sql = "UPDATE holidays SET name = '$name', date = '$date', description = '$description', type = '$type', recurring = '$recurring' WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);
    header('Location: ' . BASE_URL . './holidays/index.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlquery = "SELECT * FROM holidays WHERE id={$id} ";
    $result = mysqli_query($conn, $sqlquery);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box pb-2 d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Holiday </h4>
                        <a href="./index.php" class="btn btn-primary">Go back</a>
                    </div>
                </div>
            </div>
<?php }
    }
} ?>
<?php require_once '../includes/footer.php'; ?>