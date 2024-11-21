<?php
include('../components/admin-header.php');

// HANDLE DELETE REQUEST
if (isset($_POST['delete_account'])) {
    $delete_id = $_POST['delete_id'];

    $verify_delete = $connForAccounts->prepare("SELECT * FROM `teachers` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_account = $connForAccounts->prepare("DELETE FROM `teachers` WHERE id = ?");
        if ($delete_account->execute([$delete_id])) {
            $success_msg[] = 'Account deleted!';
        } else {
            $error_msg[] = 'Error deleting Account.';
        }
    } else {
        $warning_msg[] = 'Account already deleted!';
    }
}

// Handle adding a new teacher
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_teacher'])) {

    $image = $_POST['image'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];


        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $insert_teacher = $connForAccounts->prepare("INSERT INTO `teachers` (image, name, email, password, date_registered) VALUES (?, ?, ?, ?, NOW())");
        if ($insert_teacher->execute([$image, $name, $email, $hashed_password])) {
            $success_msg[] = 'New teacher added successfully!';
        } else {
            $error_msg[] = 'Error adding teacher. Please try again.';
        }
}

$teacher_accounts = $connForAccounts->query("SELECT * FROM `teachers`")->fetchAll(PDO::FETCH_ASSOC);

?>


<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include("../components/topbar.php"); ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <button type="button" class="btn btn-info mb-5 mt-4" data-toggle="modal" data-target="#teacherModal">
            Add New Teacher
            </button>
        </div>



        <!-- DataTable -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                                <th>Action(s)</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($teacher_accounts as $account):
                            ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><img src="../images/profile/<?php echo ($account['image']); ?>" alt="Image" style="width: 100px; height: auto;"></td>
                                    <td><?php echo ($account['name']); ?></td>
                                    <td><?php echo ($account['email']); ?></td>
                                    <td><?php echo ($account['password']); ?></td>
                                    <td><?php echo ($account['date_registered']); ?></td>
                                    <td>
                                        <form method="POST" action="" class="delete-form">
                                            <input type="hidden" name="delete_id" value="<?php echo ($account['id']); ?>">
                                            <input type="hidden" name="delete_account" value="1">
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
    </div>
    <!-- /.container-fluid -->

    <!-- Modal for Adding New Teacher -->
    <div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="teacherModalLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherModalLabel">Add New Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Form for adding new teacher -->
                    <form action="" method="post">

                        <div class="form-group">
                            <label for="image">Upload Picture</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="Upload Image" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        
                        <input type="hidden" name="add_teacher" value="1">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("../components/scripts.php"); ?>

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

</body>

</html>