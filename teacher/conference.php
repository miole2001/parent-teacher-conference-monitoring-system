<?php 
    ob_start(); 
    
    include("../components/teacher-header.php"); 

    // Handle the form submission for adding a new conference
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_conference'])) {
        $image = $_FILES['image']['name'];
        $teacherName = $_POST['teacherName'];
        $date = $_POST['date'];
        $time_in = $_POST['time_in'];
        $time_out = $_POST['time_out'];

        $insert_sql = "INSERT INTO `conference` (`image`, `teacher_name`, `date_of_meeting`, `available_time_in`, `available_time_out`, `status`) 
        VALUES (?, ?, ?, ?, ?, 'Available')";
        $stmt_insert = $connForConference->prepare($insert_sql);
        $stmt_insert->execute([$image, $teacherName, $date, $time_in, $time_out]);

        header('Location: conference.php');
        exit;

    }

    // Handle the form submission for updating an existing conference
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_conference'])) {
        $teacherName = $_POST['teacherName'];
        $date = $_POST['date'];
        $time_in = $_POST['time_in'];
        $time_out = $_POST['time_out'];
        $status = $_POST['status'];
        $conference_id = $_POST['conference_id'];

        $update_sql = "UPDATE `conference` SET `teacher_name` = ?, `date_of_meeting` = ?, `available_time_in` = ?, `available_time_out` = ?, `status` = ? WHERE `id` = ?";
        $stmt_update = $connForConference->prepare($update_sql);
        $stmt_update->execute([$teacherName, $date, $time_in, $time_out, $status, $conference_id]);

        // Redirect to the conferences page after update
        header('Location: conference.php');
        exit;
    }

    // Handle deletion of conference
    if (isset($_GET['delete_conference'])) {
        $conference_id = $_GET['delete_conference'];

        // Prepare SQL query to delete the conference
        $delete_sql = "DELETE FROM `conference` WHERE `id` = ?";
        $stmt_delete = $connForConference->prepare($delete_sql);
        $stmt_delete->execute([$conference_id]);

        // Redirect to the conference page after deletion
        header('Location: conference.php');
        exit;
    }

    $teacher_display = $connForAccounts->query("SELECT * FROM `teachers`")->fetchAll(PDO::FETCH_ASSOC);

    $conference_list = $connForConference->query("SELECT * FROM `conference`")->fetchAll(PDO::FETCH_ASSOC);

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
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addConference">
            Add New Conference
            </button>
        </div>

        <div class="row">
            <?php foreach ($conference_list as $conference): ?>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo "../images/profile/" . $conference['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title text-uppercase text-center"><?php echo($conference['teacher_name']); ?></h2>
                            <p class="card-text">Vacant Date: <?php echo date("M j, Y", strtotime($conference['date_of_meeting'])); ?></p>
                            <p class="card-text">Vacant Start Time: <?php echo date("g:i A", strtotime($conference['available_time_in'])); ?></p>
                            <p class="card-text">Vacant Until: <?php echo date("g:i A", strtotime($conference['available_time_out'])); ?></p>
                            <p class="card-text">Status: <?php echo($conference['status']); ?></p>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editConference<?php echo $conference['id']; ?>">
                                Edit Information
                            </button>
                            <!-- Delete conference Button -->
                            <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo($conference['id']); ?>">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- edit conference Modal -->
                <div class="modal fade" id="editConference<?php echo $conference['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editConferenceLabel<?php echo $conference['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog d-flex align-items-center" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editConferenceLabel<?php echo $conference['id']; ?>">Edit Schedule</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <img class="card-img-top" src="<?php echo "../images/profile/" . $conference['image']; ?>" alt="Card image cap">
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="conference_id" value="<?php echo ($conference['id']); ?>">

                                    <div class="form-group">
                                        <label for="teacherName">Teacher Name</label>
                                        <input type="text" class="form-control" id="teacherName" name="teacherName" value="<?php echo ($conference['teacher_name']); ?>" >
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Meeting Date</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo ($conference['date_of_meeting']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="time_in">Meeting Time</label>
                                        <input type="time" class="form-control" id="time_in" name="time_in" value="<?php echo ($conference['available_time_in']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="time_out">Meeting Time</label>
                                        <input type="time" class="form-control" id="time_out" name="time_out" value="<?php echo ($conference['available_time_out']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="Occupied" <?php echo ($conference['status'] === 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
                                            <option value="Available" <?php echo ($conference['status'] === 'Available') ? 'selected' : ''; ?>>Available</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="edit_conference">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            <?php endforeach; ?>
        </div>
    </div>
    <!-- /.container-fluid -->


<!-- add conference Modal -->
<div class="modal fade" id="addConference" tabindex="-1" role="dialog" aria-labelledby="addConferenceTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addConferenceTitle">Add New Coference</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="teacherName">Teacher Name</label>
                        <input type="text" class="form-control" id="teacherName" name="teacherName" value="<?php echo ($teacher_display[0]['name']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="teacherName">Teacher Name</label>
                        <input type="text" class="form-control" id="teacherName" name="teacherName" required>
                    </div>

                    <div class="form-group">
                        <label for="date">Vacant Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="time_in">Vacant Time Start</label>
                        <input type="time" class="form-control" id="time_in" name="time_in" required>
                    </div>

                    <div class="form-group">
                        <label for="time_out">Vacant Time End</label>
                        <input type="time" class="form-control" id="time_out" name="time_out" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_conference">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- edit conference Modal -->
<div class="modal fade" id="editConference" tabindex="-1" role="dialog" aria-labelledby="editConferenceLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editConferenceLabel">Edit Conference</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="conference_id" value="<?php echo ($conference['id']); ?>">

                    <div class="form-group">
                        <label for="teacherName">Teacher Name</label>
                        <input type="text" class="form-control" id="teacherName" name="teacherName" value="<?php echo ($conference['teacher_name']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="title">Meeting Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo ($conference['meeting_title']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="date">Meeting Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo ($conference['date_of_meeting']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="time">Meeting Time</label>
                        <input type="time" class="form-control" id="time" name="time" value="<?php echo ($conference['time_meeting_starts']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="year-level">Year Level</label>
                        <input type="text" class="form-control" id="year-level" name="year-level" value="<?php echo ($conference['year_level']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="ongoing" <?php echo ($conference['status'] === 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                            <option value="completed" <?php echo ($conference['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo ($conference['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="edit_conference">Save changes</button>
                </div>
            </form>
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

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const conferenceId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "conference.php?delete_conference=" + conferenceId;
                }
            });
        });
    });
</script>

<?php include("../components/scripts.php"); ?>

</body>

</html>