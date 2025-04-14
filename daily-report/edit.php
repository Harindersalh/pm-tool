<?php
ob_start();
require_once '../includes/header.php';
if (isset($_GET['id']) && ($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "Invalid ID";
    exit;
}
$sql = "SELECT ps.*, p.name AS project_name, p.description AS project_description 
        FROM project_status ps
        JOIN projects p ON ps.project_id = p.id
        WHERE ps.id = $id";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    $project = mysqli_fetch_assoc($query);
?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box pb-3 d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Daily Report</h4>
                <a href="./index.php" class="btn btn-primary d-flex">
                    <i class="bx bx-left-arrow-alt me-1 fs-4"></i> Go Back
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name">Project Name: <?php echo htmlspecialchars($project['project_name']); ?></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description"><?php echo htmlspecialchars(strip_tags($project['project_description'])); ?></label>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php
} else {
    echo "Daily Report not found.";
}
?>
<div class="card">
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="chargable_hours">Spend Hours</label>
                        <select id="chargable_hours" class="form-select" name="chargable_hours" required>
                            <option value="" disabled>Select Chargable Hours</option>
                            <?php
                            $numbers = range(0, 24);
                            foreach ($numbers as $number) {?>
                                <option value="<?php echo $number; ?>" <?php echo (isset($project['chargable_hours']) && $project['chargable_hours'] == $number) ? 'selected' : ''; ?>>
                                    <?php echo $number; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="non_chargable_hours">Non-Chargable Hours</label>
                        <select id="non_chargable_hours" class="form-select" name="non_chargable_hours" required>
                            <option value="" disabled>Select Non-Chargable Hours</option>
                            <?php
                            $numbers = range(0, 24);
                            foreach ($numbers as $number) { ?>
                                <option value="<?php echo $number; ?>" <?php echo (isset($project['non_chargable_hours']) && $project['non_chargable_hours'] == $number) ? 'selected' : ''; ?>>
                                    <?php echo $number; ?>
                                </option>
                            <?php  } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="update">Update</label>
                        <textarea class="form-control" name="update" id="update" required><?php echo isset($project['update']) ? htmlspecialchars($project['update']) : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="project_status">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        $('#update').summernote();
        $('#non_chargable_hours, #chargable_hours').select2();
    });
</script>
<?php
if (isset($_POST['project_status'])) {
    $chargable_hours =  $_POST['chargable_hours'];
    $non_chargable_hours =  $_POST['non_chargable_hours'];
    $update = $_POST['update'];
    $update_sql = "UPDATE project_status 
                   SET chargable_hours = '$chargable_hours', 
                       non_chargable_hours = '$non_chargable_hours', 
                       `update` = '$update' 
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {
        header('Location: ' . BASE_URL . './daily-report/index.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error updating project status: " . mysqli_error($conn) . "</div>";
    }
}
require_once '../includes/footer.php';
?>