<?php 
ob_start(); 
include("../components/parent-header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
    $teacher = $_POST['teacherName'];
    $date = $_POST['date'];
    $parent_name = $_POST['parent_name'];
    $student_name = $_POST['student_name'];

    $check_sql = "SELECT * FROM `conference_attendance` WHERE `parent_name` = ? AND `teacher_name` = ? AND `date_of_meeting` = ?";
    $stmt_check = $connForConference->prepare($check_sql);
    $stmt_check->execute([$parent_name, $teacher, $date]);
    $existing_submission = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($existing_submission) {
        echo "<script>alert('You have already registered for this schedule.');</script>";
    } else {
        $insert_sql = "INSERT INTO `conference_attendance` (`student_name`, `parent_name`, `teacher_name`, `date_of_meeting`) 
        VALUES (?, ?, ?, ?)";
        $stmt_insert = $connForConference->prepare($insert_sql);
        $stmt_insert->execute([$student_name, $parent_name, $teacher, $date]);

        // Redirect back to the conference page
        header('Location: conference.php');
        exit;
    }
}

$conference_list = $connForConference->query("SELECT * FROM `conference` WHERE status = 'Available'")->fetchAll(PDO::FETCH_ASSOC);

$parent_display = $connForAccounts->query("SELECT * FROM `parents`")->fetchAll(PDO::FETCH_ASSOC);
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addConference">
                                Schedule
                            </button>
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
                <h5 class="modal-title" id="addConferenceTitle">Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="teacherName">Teacher Name</label>
                        <input type="text" class="form-control" id="teacherName" name="teacherName" value="<?php echo($conference['teacher_name']); ?>" readonly>
                    </div>

                    <?php foreach ($parent_display as $parent): ?>
                        <div class="form-group">
                            <label for="parent_name">Parent Name</label>
                            <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?php echo($parent['name']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="student_name">Student Name</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo($parent['student_name']); ?>" readonly>
                        </div>
                    <?php endforeach; ?>

                    <div class="form-group">
                        <label for="date">Meeting Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo($conference['date_of_meeting']); ?>" readonly>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="attendance">Save changes</button>
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

<?php include("../components/scripts.php"); ?>

</body>

</html>