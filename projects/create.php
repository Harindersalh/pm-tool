<?php
ob_start();
require_once '../includes/header.php';
$plugins = ['datepicker', 'select2'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $startdate = date('Y-m-d', strtotime($_POST['start_date']));
    $duedate = !empty($_POST['due_date']) ? date('Y-m-d', strtotime($_POST['due_date'])) : NULL;
    $currencycode = $_POST['currencycode'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $hourly_rate = ($type === 'hourly' && isset($_POST['hourly_rate'])) ? $_POST['hourly_rate'] : NULL;
    $description = $_POST['description'];
    $client = $_POST['client'];
    $team_leader = $_POST['team_leader'] ?? NULL;
    $employees = $_POST['employees'];

    if (!empty($duedate) && $duedate < $startdate) {
        echo "<script>alert('Due Date cannot be earlier than Start Date.'); window.history.back();</script>";
        exit();
    }
    $sql = "INSERT INTO projects (name, start_date, due_date, currency_code, status, type, hourly_rate, description, client_id, team_leader_id) 
            VALUES ('$name', '$startdate', '$duedate', '$currencycode', '$status', '$type', '$hourly_rate', '$description', '$client', " . ($team_leader ? "'$team_leader'" : "NULL") . ")";
    if (mysqli_query($conn, $sql)) {
        $project_id = mysqli_insert_id($conn);

        foreach ($employees as $employee_id) {
            $assignEmployee = "INSERT INTO employee_projects (employee_id, project_id, assigned_date) 
                               VALUES ('$employee_id', '$project_id', NOW())";
            mysqli_query($conn, $assignEmployee);
        }

        if (!empty($_FILES['project_documents']['name'][0])) {
            $targetDir = "uploads/projects/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            foreach ($_FILES['project_documents']['name'] as $key => $fileName) {
                $fileTmp = $_FILES['project_documents']['tmp_name'][$key];
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = time() . "_" . uniqid() . "." . $fileExt;
                $filePath = $targetDir . $newFileName;

                if (move_uploaded_file($fileTmp, $filePath)) {
                    $insertFile = "INSERT INTO project_documents (project_id, file_path) VALUES ('$project_id', '$filePath')";
                    mysqli_query($conn, $insertFile);
                }
            }
        }

        header('Location: ' . BASE_URL . './projects/index.php');
        exit();
    } else {
        echo "Error creating project: " . mysqli_error($conn);
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box pb-3 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Create Project</h4>
            <a href="./index.php" class="btn btn-primary d-flex"><i class="bx bx-left-arrow-alt me-1 fs-4"></i>Go Back</a>
        </div>
    </div>
</div>

<?php include './form.php'; ?>

<?php require_once '../includes/footer.php'; ?>