<?php
if(! $_SESSION) {
    session_start();
}
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<body>
<?php if(! isset($_SESSION['user_id'])) {
    include ('dashboard.php');
} else {
    include('user_dashboard.php');
}
?>

<?php ?>

<?php ?>
</body>
</html>