<?php 
    include('../components/admin-header.php'); 

    // HANDLE DELETE REQUEST
    if (isset($_POST['delete_logs'])) {
        $delete_id = $_POST['delete_id'];
        
        $verify_delete = $connForLogs->prepare("SELECT * FROM `admin_logs` WHERE id = ?");
        $verify_delete->execute([$delete_id]);
        
        if ($verify_delete->rowCount() > 0) {
            $delete_logs = $connForLogs->prepare("DELETE FROM `admin_logs` WHERE id = ?");
            if ($delete_logs->execute([$delete_id])) {
                $success_msg[] = 'Log deleted!';
            } else {
                $error_msg[] = 'Error deleting log.';
            }
        } else {
            $warning_msg[] = 'Log already deleted!';
        }
    }
        
    // FETCH ALL DATA OF ADMIN LOGS
    $admin_logs = $connForLogs->query("SELECT * FROM `admin_logs`")->fetchAll(PDO::FETCH_ASSOC);


?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($admin_logs as $logs):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo ($logs['email']); ?></td>
                                <td><?php echo ($logs['activity_type']); ?></td>
                                <td><?php echo ($logs['timestamp']); ?></td>
                                <td>
                                    <form method="POST" action="" class="delete-form">
                                        <input type="hidden" name="delete_id" value="<?php echo ($logs['id']); ?>">
                                        <input type="hidden" name="delete_logs" value="1">
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    // Delete confirmation
    $('.delete-btn').on('click', function() {
        const form = $(this).closest('.delete-form');
        const reviewId = form.find('input[name="delete_id"]').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Deleting log ID: " + reviewId); // Debug log
                form.submit(); // Submit the form if confirmed
            }
        });
    });
</script>

<?php include('../components/footer.php'); ?>
<?php include('../components/scripts.php'); ?>
