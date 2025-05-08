<?php
ob_start();
require_once '../includes/header.php';
if (isset($_POST['add-invoices'])) {
    $invoiceId = $conn->real_escape_string($_POST['invoiceId']);
    $invoiceDate = $conn->real_escape_string($_POST['invoiceDate']);
    $billedByName = $conn->real_escape_string($_POST['billedByName']);
    $billedByPan = $conn->real_escape_string($_POST['billedByPan']);
    $billedByAddress = $conn->real_escape_string($_POST['billedByAddress']);
    $billedToName = $conn->real_escape_string($_POST['billedToName']);
    $billedToPan = $conn->real_escape_string($_POST['billedToPan']);
    $billedToAddress = $conn->real_escape_string($_POST['billedToAddress']);

    $conn->begin_transaction();

    try {
       
        $sql = "INSERT INTO invoices (
                    invoice_id, invoice_date, billed_by_name, billed_by_pan, billed_by_address, 
                    billed_to_client_company_name, billed_to_pan, billed_to_address
                ) VALUES (
                    '$invoiceId', '$invoiceDate', '$billedByName', '$billedByPan', '$billedByAddress',
                    '$billedToName', '$billedToPan', '$billedToAddress'
                )";

        if ($conn->query($sql) === TRUE) {
            $invoiceIdInserted = $conn->insert_id;

          
            if (!empty($_POST['items'])) {
                foreach ($_POST['items'] as $item) {
                    $taskTitle = $conn->real_escape_string($item['title']);
                    $hours = $conn->real_escape_string($item['hours']);
                    $rate = $conn->real_escape_string($item['rate']);

                    $itemSql = "INSERT INTO invoice_items (invoice_id, task_title, hours, rate) 
                                VALUES ('$invoiceIdInserted', '$taskTitle', '$hours', '$rate')";

                    if ($conn->query($itemSql) !== TRUE) {
                        throw new Exception("Error inserting invoice item: " . $conn->error);
                    }
                }
            }

            $conn->commit();

          
            header('Location: ' . BASE_URL . '/invoices/index.php');
            exit;
        } else {
            throw new Exception("Error inserting invoice: " . $conn->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>


<div class="row">
    <div class="col-12">
        <div class="page-title-box pb-3 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Add New Invoice</h4>
            <a href="./index.php" class="btn btn-primary d-flex">
                <i class="bx bx-left-arrow-alt me-1 fs-4"></i>Go Back
            </a>
        </div>
    </div>
</div>

<div class="card">
    <?php include './form.php'; ?>
</div>

<?php require_once '../includes/footer.php'; ?>