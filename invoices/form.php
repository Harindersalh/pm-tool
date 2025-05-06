<form method="post" name="invoices_form" id="invoices_form" enctype="multipart/form-data">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between gap-4 flex-wrap mb-4">

                <div class="flex-fill" style="max-width: 300px;">
                    <label for="invoiceId" class="form-label">Invoice ID</label>
                    <input type="text" class="form-control" id="invoiceId" name="invoiceId"
                        value="<?= isset($invoice['invoice_id']) ? htmlspecialchars($invoice['invoice_id']) : '' ?>">
                </div>

                <div class="flex-fill" style="max-width: 300px;">
                    <label for="invoiceDate" class="form-label">Invoice Date</label>
                    <input type="text" class="form-control" id="invoiceDate" name="invoiceDate"
                        value="<?= isset($invoice['invoice_date']) ? htmlspecialchars($invoice['invoice_date']) : '' ?>" outocomplete="off">
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-md-6 pe-md-3 mb-3">
                    <h6 class="mb-2">Billed To</h6>
                    <div class="mb-3">
                        <label for="billedToName" class="form-label">Client/Company Name</label>
                        <input type="text" class="form-control" id="billedToName" name="billedToName"
                            value="<?= isset($invoice['billed_to_client_company_name']) ? htmlspecialchars($invoice['billed_to_client_company_name']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="billedToPan" class="form-label">PAN Code</label>
                        <input type="text" class="form-control" id="billedToPan" name="billedToPan"
                            value="<?= isset($invoice['billed_to_pan']) ? htmlspecialchars($invoice['billed_to_pan']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="billedToAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="billedToAddress" name="billedToAddress"
                            rows="2"><?= isset($invoice['billed_to_address']) ? htmlspecialchars($invoice['billed_to_address']) : '' ?></textarea>
                    </div>
                </div>


                <div class="col-md-6 ps-md-3 mb-3">
                    <h6 class="mb-2">Billed By</h6>
                    <div class="mb-3">
                        <label for="billedByName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="billedByName" name="billedByName"
                            value="<?= isset($invoice['billed_by_name']) ? htmlspecialchars($invoice['billed_by_name']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="billedByPan" class="form-label">PAN Code</label>
                        <input type="text" class="form-control" id="billedByPan" name="billedByPan"
                            value="<?= isset($invoice['billed_by_pan']) ? htmlspecialchars($invoice['billed_by_pan']) : '' ?>">
                    </div>
                    <div class="">
                        <label for="billedByAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="billedByAddress" name="billedByAddress"
                            rows="2"><?= isset($invoice['billed_by_address']) ? htmlspecialchars($invoice['billed_by_address']) : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div id="invoiceItemsContainer">
                <h6 class="mb-2">Invoice Tasks</h6>
            </div>
            <button type="button" id="addItemBtn"  name="add_task"class="btn btn-danger">Add Task</button>
        </div>

        <div class="col-md-6 ps-md-3 mb-3">
            <input type="hidden" name="invoices_id" value="<?= isset($invoice['id']) ? $invoice['id'] : '' ?>">
            <button type="submit" class="btn btn-primary"
                name="<?= isset($invoice['id']) ? 'edit-invoices' : 'add-invoices'; ?>">
                <?= isset($row['id']) ? 'Update' : 'Submit'; ?>
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {

        $("#invoiceDate").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $("#invoices_form").validate({
            rules: {
                invoiceId: {
                    required: true,
                    minlength: 1
                },
                invoiceDate: {
                    required: true,
                    dateISO: true
                },
                billedToName: {
                    required: true,
                    minlength: 2
                },
                billedToPan: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                billedToAddress: {
                    required: true,
                    minlength: 10
                },
                billedByName: {
                    required: true,
                    minlength: 2
                },
                billedByPan: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                billedByAddress: {
                    required: true,
                    minlength: 10
                },
                'items[title][]': {
                    required: true,
                    minlength: 2
                },
                'items[hours][]': {
                    required: true,
                    
                },
                'items[rate][]': {
                    required: true,
                    number: true,
                    min: 0
                }
            },
            messages: {
                invoiceId: {
                    required: "Please enter the invoice ID",
                    minlength: "Invoice ID should have at least 1 character"
                },
                invoiceDate: {
                    required: "Please select the invoice date",
                    dateISO: "Please enter a valid date (YYYY-MM-DD)"
                },
                billedToName: {
                    required: "Please enter the client/company name",
                    minlength: "Client/company name must be at least 2 characters"
                },
                billedToPan: {
                    required: "Please enter the PAN Code",
                    minlength: "PAN Code must be 10 characters",
                    maxlength: "PAN Code must be 10 characters"
                },
                billedToAddress: {
                    required: "Please enter the address",
                    minlength: "Address must be at least 10 characters"
                },
                billedByName: {
                    required: "Please enter the name",
                    minlength: "Name must be at least 2 characters"
                },
                billedByPan: {
                    required: "Please enter the PAN Code",
                    minlength: "PAN Code must be 10 characters",
                    maxlength: "PAN Code must be 10 characters"
                },
                billedByAddress: {
                    required: "Please enter the address",
                    minlength: "Address must be at least 10 characters"
                },
                'items[title][]': {
                    required: "Please enter the task title",
                    minlength: "Task title must be at least 2 characters"
                },
                'items[hours][]': {
                    required: "Please enter the hours",
                   
                   
                },
                'items[rate][]': {
                    required: "Please enter the rate",
                    number: "Please enter a valid number",
                    min: "Rate must be greater than or equal to 0"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        const existingTasks = <?= json_encode($invoice['invoice_items'] ?? []) ?>;
        let itemCount = 0;

        function renderTask(count, task = {}) {
            const isFirst = count === 1;
            const title = task.task_title || '';
            const hours = task.hours !== undefined ? task.hours : '';
            const rate = task.rate !== undefined ? task.rate : '';
            const id = task.id || '';

            return `
             <input type="hidden" name="items[${count}][id]" value="${id}">
                <div class="row g-3 mb-3 invoice-item" data-index="${count}">
                  <div class="col-md-4">
                    <label class="form-label">Task Title</label>
                    <input type="text" class="form-control" name="items[${count}][title]" value="${title}" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Hours</label>
                    <input type="number" step="0.1" class="form-control" name="items[${count}][hours]" value="${hours}" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Rate</label>
                    <input type="number" step="0.01" class="form-control" name="items[${count}][rate]" value="${rate}" required>
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    ${isFirst ? '' : '<button type="button" class="btn btn-outline-danger remove-item">Remove</button>'}
                  </div>
                </div>
            `;
        }

        if (existingTasks.length > 0) {
            $('#invoiceItemsContainer').empty();
            existingTasks.forEach((task, index) => {
                itemCount = index + 1;
                $('#invoiceItemsContainer').append(renderTask(itemCount, task));
            });
        } else {
            itemCount = 1;
            $('#invoiceItemsContainer').append(renderTask(itemCount));
        }

        $('#addItemBtn').click(function () {
            itemCount++;
            $('#invoiceItemsContainer').append(renderTask(itemCount));
        });

        $('#invoiceItemsContainer').on('click', '.remove-item', function () {
            $(this).closest('.invoice-item').remove();
        });
    });
</script>