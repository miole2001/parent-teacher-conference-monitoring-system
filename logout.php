<?php
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];

    $verify_admin = $connForAccounts->prepare("SELECT email FROM `admin` WHERE id = ?");
    $verify_admin->execute([$user_id]);
    
    if ($verify_admin->rowCount() > 0) {
        $admin = $verify_admin->fetch(PDO::FETCH_ASSOC);
        $email = $admin['email'];
        $user_type = 'admin';

        // Log admin logout
        $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
        $log_stmt->execute([$email, $user_type]);

    } else {
        // Check teachers table
        $verify_teacher = $connForAccounts->prepare("SELECT email FROM `teachers` WHERE id = ?");
        $verify_teacher->execute([$user_id]);
        
        if ($verify_teacher->rowCount() > 0) {
            $teacher = $verify_teacher->fetch(PDO::FETCH_ASSOC);
            $email = $teacher['email'];
            $user_type = 'teacher';

            // Log teacher logout
            $log_stmt = $connForLogs->prepare("INSERT INTO teacher_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
            $log_stmt->execute([$email, $user_type]);

        } else {
            // Check parents table
            $verify_parent = $connForAccounts->prepare("SELECT email FROM `parents` WHERE id = ?");
            $verify_parent->execute([$user_id]);

            if ($verify_parent->rowCount() > 0) {
                $parent = $verify_parent->fetch(PDO::FETCH_ASSOC);
                $email = $parent['email'];
                $user_type = 'parent';

                // Log parent logout
                $log_stmt = $connForLogs->prepare("INSERT INTO parent_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
                $log_stmt->execute([$email, $user_type]);
            }
        }
    }
}

// Clear the cookie
setcookie('user_id', '', time() - 1, '/');

// Redirect to login page
header('Location: login.php');
exit();

?>
