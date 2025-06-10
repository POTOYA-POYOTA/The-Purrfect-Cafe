<?php

// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the homepage (index.php)
header("Location: index.php");
exit();

?>
