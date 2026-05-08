<?php
session_start();      // Mulai session
session_destroy();    // Hancurkan semua session
header("Location: index.php");  // Redirect ke login SIPUKM
exit;
