<?php 
ob_start();
require_once './includes/header.php';
require_once './includes/db.php';
$userProfile = userProfile();
$notifications = getNotifications($userProfile);

if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $notificationId = intval($_GET['mark_read']);

    // Optional: Check ownership if needed
    $stmt = $conn->prepare("UPDATE notifications SET read_status = 1 WHERE id = ?");
    $stmt->bind_param("i", $notificationId);
    $stmt->execute();
    $stmt->close();

    if (isset($_GET['redirect_to'])) {
        $redirectUrl = urldecode($_GET['redirect_to']);
        header("Location: $redirectUrl");
        exit;
    }
}

?>

<!-- STYLING -->
<style>
    .unread-notification {
        background-color: #eaf3ff !important;
    }

    .unread-notification td:first-child {
        font-weight: 400;
        color: rgba(21, 21, 21, 0.79);
        font-size: 1rem;
    }

    .new-badge {
        background-color: #0d6efd;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 6px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 2px 8px;
        font-size: 0.75rem;
    }
</style>

<!-- HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box pb-3 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Notifications</h4>
            <span class="badge bg-info fs-6"><?php echo count($notifications); ?> Total</span>
        </div>
    </div>
</div>

<!-- NOTIFICATION TABLE -->
<div class="card">
    <div class="card-body">
        <div class="container">
            <table class="table table-sm" id="notificationTable">
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Date And Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notifications as $noti): ?>
                        <tr class="<?php echo $noti['read_status'] == 0 ? 'unread-notification' : ''; ?>">
                            <td>
                                <?php echo htmlspecialchars($noti['message']); ?>
                                <?php if ($noti['read_status'] == 0): ?>
                                    <span class="new-badge">NEW</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($noti['created_at']); ?></td>
                            <td>
                                <?php
                                $link = $noti['link'] ?? '#';

                                if ($userProfile['role'] === 'employee' && strpos($noti['message'], 'assigned to a new project') !== false) {
                                    $link = BASE_URL . '/projects/index.php';
                                } elseif (strpos($noti['message'], 'milestone') !== false) {
                                    // Example: if notification is about milestone, link to milestone details
                                    $milestoneId = $noti['milestone_id'] ?? null; // make sure this column exists in your notifications table
                                    if ($milestoneId) {
                                        $link = BASE_URL . '/milestones/edit.php?id=' . intval($milestoneId);
                                    }
                                } else {
                                    if (strpos($link, 'http') === 0) {
                                        // full URL
                                    } elseif (strpos($link, '/') === 0) {
                                        $link = BASE_URL . $link;
                                    } else {
                                        $link = BASE_URL . '/' . $link;
                                    }
                                }
                                ?>

                                <?php if (!empty($link) && $link !== '#'): ?>
                                    <a href="?mark_read=<?php echo $noti['id']; ?>&redirect_to=<?php echo urlencode($link); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                <?php else: ?>
                                    <span class="text-muted">No link</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DATATABLE -->
<script>
    $(document).ready(function() {
        $('#notificationTable').DataTable({
            paging: true,
            ordering: true,
            info: true,
            lengthMenu: [10, 25, 50, 100],
            autoWidth: false,
            order: [
                [1, "desc"]
            ]
        });
    });
</script>

<?php require_once './includes/footer.php'; 
ob_end_flush();
?>