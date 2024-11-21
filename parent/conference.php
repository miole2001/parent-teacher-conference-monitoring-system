<?php 
    ob_start(); 
    
    include("../components/parent-header.php"); 

    // Handle the form submission for adding a new conference
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
        $teacher = $_POST['teacherName'];
        $title = $_POST['title'];
        $date = $_POST['date'];
        $parent_name = $_POST['parent_name'];
        $student_name = $_POST['student_name'];
        $year_level = $_POST['year-level'];

        $insert_sql = "INSERT INTO `conference_attendance` (`meeting_title`, `student_name`, `parent_name`, `teacher_name`, `date_of_meeting`, `year_level`) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $connForConference->prepare($insert_sql);
        $stmt_insert->execute([$title, $student_name, $parent_name, $teacher, $date, $year_level]);

        header('Location: conference.php');
        exit;

    }

    $conference_list = $connForConference->query("SELECT * FROM `conference`")->fetchAll(PDO::FETCH_ASSOC);

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
                        <div class="card-body">
                            <h2 class="card-title text-uppercase text-center"><?php echo($conference['meeting_title']); ?></h2>
                            <p class="card-text">Teacher/Instructor: <?php echo($conference['teacher_name']); ?></p>
                            <p class="card-text">Year Level: <?php echo($conference['year_level']); ?></p>
                            <p class="card-text">Date: <?php echo date("M j, Y", strtotime($conference['date_of_meeting'])); ?></p>
                            <p class="card-text">Time: <?php echo date("g:i A", strtotime($conference['time_meeting_starts'])); ?></p>
                            <p class="card-text">Status: <?php echo($conference['status']); ?></p>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addConference">
                                Attend
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
                        <label for="title">Meeting Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo($conference['meeting_title']); ?>" readonly>
                    </div>

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

                    <div class="form-group">
                        <label for="year-level">Year Level</label>
                        <input type="text" class="form-control" id="year-level" name="year-level" value="<?php echo($conference['year_level']); ?>" readonly>
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