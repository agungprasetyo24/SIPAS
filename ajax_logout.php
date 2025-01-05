<?php
session_start();
session_destroy();

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['success' => true]);
exit();
