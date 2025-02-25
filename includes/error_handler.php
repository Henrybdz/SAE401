<?php
function handleError($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }

    $error = [
        'error' => true,
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ];

    if (!headers_sent()) {
        header('Content-Type: application/json');
        http_response_code(500);
    }

    echo json_encode($error);
    exit(1);
}

function handleException($e) {
    $error = [
        'error' => true,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ];

    if (!headers_sent()) {
        header('Content-Type: application/json');
        http_response_code(500);
    }

    echo json_encode($error);
    exit(1);
}

// Set error and exception handlers
set_error_handler("handleError");
set_exception_handler("handleException");

// Ensure errors are reported
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
