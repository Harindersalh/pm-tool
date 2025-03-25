<?php
$clients = mysqli_query($conn, "SELECT * FROM `clients`");
$team_leaders = mysqli_query($conn, "SELECT * FROM `users` WHERE `role`='team leader' ");
$employees = mysqli_query($conn, "SELECT * FROM `users` WHERE `role`='employee' ");
?>
<div class="card">
    <form method="POST" name="project-form" id="project-form" class="p-3" enctype="multipart/form-data">
        <input type="hidden" name="project_id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required minlength="2"
                        value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="client">Client<span class="text-danger">*</span></label>
                    <select id="client" class="form-select" name="client" required>
                        <option value="" selected disabled>Select Client</option>
                        <?php
                        $selectedClientId = isset($existingClientId) ? $existingClientId : (isset($row['client_id']) ? $row['client_id'] : null);
                        while ($client = mysqli_fetch_assoc($clients)) {
                            $selected = ($client['id'] == $selectedClientId) ? 'selected' : '';
                            echo '<option value="' . $client['id'] . '" ' . $selected . '>' . $client['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="team_leader">Team Leader</label>
                    <select id="team_leader" class="form-select" name="team_leader">
                        <option value="" selected disabled>Select team leader</option>
                        <?php
                        $selectedTeamLeaderId = isset($row['team_leader_id']) ? $row['team_leader_id'] : null;
                        while ($team_leader = mysqli_fetch_assoc($team_leaders)) {
                            $selected = ($team_leader['id'] == $selectedTeamLeaderId) ? 'selected' : '';
                            echo '<option value="' . $team_leader['id'] . '" ' . $selected . '>' . $team_leader['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="employees">Assign Employees <span class="text-danger">*</span></label>
                    <select id="employees" class="form-select" name="employees[]" multiple required>
                        <?php
                        $selectedEmployees = isset($existingEmployeeIds) ? $existingEmployeeIds : [];
                        while ($employee = mysqli_fetch_assoc($employees)) {
                            $selected = in_array($employee['id'], $selectedEmployees) ? 'selected' : '';
                            echo '<option value="' . $employee['id'] . '" ' . $selected . '>' . $employee['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label for="type">Type<span class="text-danger">*</span></label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="hourly" <?php echo isset($row['type']) && $row['type'] == 'hourly' ? 'selected' : ''; ?>>Hourly</option>
                            <option value="fixed" <?php echo isset($row['type']) && $row['type'] == 'fixed' ? 'selected' : ''; ?>>Fixed</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="hourly_rate_container" style="display: none;">
                        <label for="hourly_rate">Hourly Rate<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="hourly_rate" name="hourly_rate"
                            value="<?php echo isset($row['hourly_rate']) ? $row['hourly_rate'] : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="currencycode">Currency Code<span class="text-danger">*</span></label>
                        <select class="form-select" id="currency-code" name="currencycode" required>
                            <option value="" selected disabled>Select Currency Code</option>
                            <option value="INR" <?php echo isset($row['currency_code']) && $row['currency_code'] == 'INR' ? 'selected' : ''; ?>>INR</option>
                            <option value="USD" <?php echo isset($row['currency_code']) && $row['currency_code'] == 'USD' ? 'selected' : ''; ?>>USD</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label>Start Date<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="start_date" id="start_date" required autocomplete="off"
                            value="<?php echo isset($row['start_date']) ? $row['start_date'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Due Date</label>
                        <input type="text" class="form-control" name="due_date" id="due_date" autocomplete="off"
                            value="<?php echo isset($row['due_date']) ? $row['due_date'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="status">Status<span class="text-danger">*</span></label>
                    <select class="form-select" id="project-status" name="status" required>
                        <option value="" selected disabled>Select Status</option>
                        <option value="Planned" <?php echo isset($row['status']) && $row['status'] == 'planned' ? 'selected' : ''; ?>>Planned</option>
                        <option value="In Progress" <?php echo isset($row['status']) && $row['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Completed" <?php echo isset($row['status']) && $row['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="On Hold" <?php echo isset($row['status']) && $row['status'] == 'on_hold' ? 'selected' : ''; ?>>On Hold</option>
                        <option value="Cancelled" <?php echo isset($row['status']) && $row['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label for="description">Description<span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" id="description" required><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea>
            </div>
        </div>
        <div class="mb-3">
            <label for="project_documents">Upload Files</label>
            <input type="file" class="form-control" id="project_documents" name="project_documents[]" multiple
                accept="image/*, .doc, .docx, .txt, .pdf, .mp4, .avi, .mov">
            <small class="text-muted">Allowed file types: Images, DOC, TXT, PDF, Videos</small>
        </div>
        <?php if (isset($id) && !empty($id)): ?>
            <?php
            $filesQuery = mysqli_query($conn, "SELECT * FROM project_documents WHERE project_id = '$id'");

            if (mysqli_num_rows($filesQuery) > 0) {
                echo "<h5>Uploaded Files:</h5><ul>";
                while ($file = mysqli_fetch_assoc($filesQuery)) {
                    $fileId = $file['id'];
                    $filePath = $file['file_path'];
                    echo "<li>
                    <a href='$filePath' target='_blank'>" . basename($filePath) . "</a>
                    <a href='#' class='btn btn-sm btn-danger ms-2 m-1 delete-file' data-id='$fileId'>Delete</a>
                  </li>";
                }
                echo "</ul>";
            }
            ?>
        <?php endif; ?>
        <input type="hidden" name="project_id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <button type="submit" class="btn btn-primary" name=<?php echo isset($row['id']) ? 'edit_project' : 'add_project'; ?>>
            <?php echo isset($row['id']) ? 'Update' : 'Submit'; ?>
        </button>
    </form>
</div>
<script>
    $(document).ready(function() {
        function toggleHourlyRate() {
            if ($('#type').val() === 'hourly') {
                $('#hourly_rate_container').show();
                $('#hourly_rate').prop('required', true);
            } else {
                $('#hourly_rate_container').hide();
                $('#hourly_rate').prop('required', false);
            }
        }

        toggleHourlyRate();

        $('#type').change(function() {
            toggleHourlyRate();
        });

        $("#start_date, #due_date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#due_date').on('change', function() {
            var startDate = new Date($('#start_date').val());
            var dueDate = new Date($(this).val());

            if (dueDate < startDate) {
                alert("Due Date cannot be earlier than Start Date.");
                $(this).val('');
            }
        });

        $('#team_leader, #client, #project-status, #type, #currency-code').select2();
        $('#description').summernote();

        $('#project-form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                client: {
                    required: true
                },
                employees: {
                    required: true
                },
                type: {
                    required: true
                },
                currencycode: {
                    required: true
                },
                start_date: {
                    required: true,
                    date: true
                },
                due_date: {
                    date: true,
                    greaterThanOrEqual: "#start_date"
                },
                status: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                due_date: {
                    greaterThanOrEqual: "Due Date cannot be before Start Date."
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("form-select")) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#employees').select2({
            placeholder: "Select Employees",
            allowClear: true
        });

        jQuery.validator.addMethod("greaterThanOrEqual", function(value, element, param) {
            var startDate = $(param).val();
            return !startDate || !value || new Date(value) >= new Date(startDate);
        }, "Due Date must be greater than or equal to Start Date.");

        $(".delete-file").click(function(e) {
            e.preventDefault();
            let fileId = $(this).data("id");
            let fileItem = $(this).closest("li");

            if (confirm("Are you sure you want to delete this file?")) {
                $.ajax({
                    url: "delete_file.php",
                    type: "POST",
                    data: {
                        file_id: fileId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            fileItem.remove();
                            alert("File deleted successfully!");
                        } else {
                            alert("Failed to delete the file.");
                        }
                    },
                    error: function() {
                        alert("Error occurred while deleting the file.");
                    }
                });
            }
        });
    });
</script>