<?php require_once '../includes/header.php'; ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box pb-2 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Holidays</h4>
            <a href="./create.php" class="btn btn-primary">Add Holiday</a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <?php
        $sql = "SELECT * FROM holidays";
        $query = mysqli_query($conn, $sql);
            $holidays = mysqli_fetch_all($query, MYSQLI_ASSOC);
        ?>
            <table class="table table-striped" id="employeeTable">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($holidays as $key => $row) {
                    ?>
                        <tr>
                            <td><?php echo  $key + 1 ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['date'] ?></td>
                            <td><?php echo $row['description'] ?></td>
                            <td><?php echo $row['type'] ?></td>
                            <td>
                                <a href='./edit.php?id=<?php echo $row['id'] ?>' class="btn btn-success btn-sm"><i class="bx bx-edit fs-5"></i></a>
                                <button class="btn btn-danger btn-sm delete-btn" data-table-name="holidays" data-id="<?php echo $row['id'] ?>"><i class="bx bx-trash fs-5"></i></button>
                            </td>
                        <?php  } ?>
                </tbody>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100],
            "autoWidth": false
        });
    });
</script>
<?php require_once '../includes/footer.php'; ?>