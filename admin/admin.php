<?php 

    include("../components/admin-header.php"); 


    $parent_accounts = $connForAccounts->query("SELECT * FROM `parents`")->fetchAll(PDO::FETCH_ASSOC);

    // Fetch the number of teachers
    $query = "SELECT COUNT(*) AS teachers_count FROM `teachers`";
    $run_query = $connForAccounts->prepare($query);
    $run_query->execute();
    $teachers_count = $run_query->fetch(PDO::FETCH_ASSOC)['teachers_count'];

    // Fetch the number of parents
    $query = "SELECT COUNT(*) AS parents_count FROM `parents`";
    $run_query = $connForAccounts->prepare($query);
    $run_query->execute();
    $parents_count = $run_query->fetch(PDO::FETCH_ASSOC)['parents_count'];

    // Fetch the number of conferences
    $query = "SELECT COUNT(*) AS conference_count FROM `conference`";
    $run_query = $connForConference->prepare($query);
    $run_query->execute();
    $conference_count = $run_query->fetch(PDO::FETCH_ASSOC)['conference_count'];


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

        <!-- Content Row -->
        <div class="row">

            <!-- Total number of teachers -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Teachers
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $teachers_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total number of parents -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Parents
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $parents_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total number of conferences -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Conferences
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $conference_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <th>Child Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Child Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($parent_accounts as $account):
                            ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><img src="../images/profile/<?php echo ($account['image']); ?>" alt="Image" style="width: 100px; height: auto;"></td>
                                    <td><?php echo ($account['name']); ?></td>
                                    <td><?php echo ($account['student_name']); ?></td>
                                    <td><?php echo ($account['email']); ?></td>
                                    <td><?php echo ($account['password']); ?></td>
                                    <td><?php echo ($account['date_registered']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

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
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
        
    });
</script>
</body>

</html>