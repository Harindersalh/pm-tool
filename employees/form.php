<form method="POST" name="employee-form" id="employee-form" class="p-3" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name">Name</label> <span class="text-danger">*</span>
                <input type="text" class="form-control" name="name" required minlength="2"
                    value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email">Email</label> <span class="text-danger">*</span>
                <input type="email" class="form-control" name="email"
                    value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="phoneno">Phone Number</label> <span class="text-danger">*</span>
                <input type="number" class="form-control" name="phoneno"
                    value="<?php echo isset($row['phone_number']) ? $row['phone_number'] : ''; ?>"
                    required pattern="\d{10}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="gender">Gender</label>
                <select class="form-select" name="gender" required>
                    <option value="Male" <?php echo (isset($row['gender']) && $row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($row['gender']) && $row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="address">Address</label> <span class="text-danger">*</span>
                <textarea class="form-control" name="address" id="address" required><?php echo isset($row['address']) ? $row['address'] : ''; ?></textarea>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="role">Role</label>
                <select class="form-select" name="role" required>
                    <option value="employee" <?php echo (isset($row['role']) && $row['role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
                    <option value="Admin" <?php echo (isset($row['role']) && $row['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="team leader" <?php echo (isset($row['role']) && $row['role'] == 'team leader') ? 'selected' : ''; ?>>Team Leader</option>
                    <option value="HR" <?php echo (isset($row['role']) && $row['role'] == 'HR') ? 'selected' : ''; ?>>HR</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="jobt">Job Title</label>
                <select class="form-select" name="jobt">
                    <option value="" disabled selected>Select a Job Title</option>
                    <option value="phpdeveloper" <?php echo (isset($row['job_title']) && $row['job_title'] == 'phpdeveloper') ? 'selected' : ''; ?>>PHP Developer</option>
                    <option value="frontendd" <?php echo (isset($row['job_title']) && $row['job_title'] == 'frontendd') ? 'selected' : ''; ?>>Frontend Developer</option>
                </select>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <label for="dob">Date Of Birth <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="dob" id="dob"
                    value="<?php echo isset($row['date_of_birth']) ? $row['date_of_birth'] : ''; ?>" required autocomplete="off">
            </div>

        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label>Date Of Joining</label> <span class="text-danger">*</span>
                <input type="text" class="form-control" name="doj" id="doj"
                    value="<?php echo isset($row['date_of_joining']) ? $row['date_of_joining'] : ''; ?>" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="status">Status</label>
                <select class="form-select" name="status" required>
                    <option value="Active" <?php echo (isset($row['status']) && $row['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo (isset($row['status']) && $row['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
        </div>
        <?php
        $isEdit = isset($_GET['id']);
        ?>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="password">Password
                    <?php if (!$isEdit): ?>
                        <span class="text-danger">*</span>
                    <?php endif; ?>
                </label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
    </div>

    <input type="hidden" name="employee_id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">

    <button type="submit" class="btn btn-primary" name="<?php echo isset($row['id']) ? 'edit-employee' : 'add_employee'; ?>">
        <?php echo isset($row['id']) ? 'Update' : 'Submit'; ?>
    </button>
</form>

<script>
    $(document).ready(function() {
        $("#dob, #doj").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('select[name="role"], select[name="jobt"], select[name="gender"], select[name="status"]').select2({
            width: '100%'
        });

        var isEditMode = $("input[name='employee_id']").val() !== "";

        $('#employee-form').validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                phoneno: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                address: "required",
                dob: "required",
                doj: "required",
                jobt: {
                    required: function() {
                        return $('select[name="role"]').val() === 'employee';
                    }
                },
                password: {
                    <?php if (!isset($row['id'])) { ?>
                        required: true,
                    <?php } ?>
                    minlength: 6
                }
            },
            messages: {
                name: "Please enter employee name",
                email: "Please enter a valid email address",
                phoneno: {
                    required: "Please enter a 10-digit phone number",
                    minlength: "Phone number must be exactly 10 digits",
                    maxlength: "Phone number must be exactly 10 digits",
                    digits: "Phone number can only contain digits"
                },
                address: "Please enter an address.",
                dob: "Please enter Date Of Birth",
                doj: "Please enter Date Of Joining",
                jobt: "Please select a Job Title (Required for Employees)",
                password: {
                    required: "Please enter a password with at least 6 characters",
                    minlength: "Password must be at least 6 characters"
                }
            },
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");

                if (element.hasClass("form-select")) {
                    error.insertAfter(element.next('.select2'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
                if ($(element).hasClass("form-select")) {
                    $(element).next('.select2').find('.select2-selection').addClass('is-invalid');
                }
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
                if ($(element).hasClass("form-select")) {
                    $(element).next('.select2').find('.select2-selection').removeClass('is-invalid');
                }
            }
        });

        $('select[name="role"]').change(function() {
            if ($(this).val() === 'employee') {
                $('select[name="jobt"]').attr('required', true);
            } else {
                $('select[name="jobt"]').removeAttr('required');
            }
        }).trigger('change');
    });
</script>