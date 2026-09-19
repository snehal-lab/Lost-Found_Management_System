<?php

include "db.php";

header("Content-Type: application/json; charset=UTF-8");


/* ==================================
   Check Request Method
================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);

    exit;
}


/* ==================================
   Get POST Data
================================== */

$id = intval($_POST["id"] ?? 0);

$status = trim($_POST["status"] ?? "");


/* ==================================
   Validate ID
================================== */

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid report ID."
    ]);

    exit;
}


/* ==================================
   Allowed Status
================================== */

$allowedStatuses = [
    "Pending",
    "Matched",
    "Returned",
    "Closed"
];


if (!in_array($status, $allowedStatuses, true)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid status value."
    ]);

    exit;
}


/* ==================================
   Check Database Connection
================================== */

if (!$conn) {

    echo json_encode([
        "success" => false,
        "message" => "Database connection failed."
    ]);

    exit;
}


/* ==================================
   Check Report Exists
================================== */

$checkSql = "
    SELECT id
    FROM reports
    WHERE id = ?
";


$checkStmt = mysqli_prepare(
    $conn,
    $checkSql
);


if (!$checkStmt) {

    echo json_encode([
        "success" => false,
        "message" => "Prepare error: " . mysqli_error($conn)
    ]);

    exit;
}


mysqli_stmt_bind_param(
    $checkStmt,
    "i",
    $id
);


if (!mysqli_stmt_execute($checkStmt)) {

    echo json_encode([
        "success" => false,
        "message" => "Check failed: " .
                     mysqli_stmt_error($checkStmt)
    ]);

    mysqli_stmt_close($checkStmt);
    exit;
}


$result = mysqli_stmt_get_result(
    $checkStmt
);


$report = mysqli_fetch_assoc($result);


mysqli_stmt_close($checkStmt);


if (!$report) {

    echo json_encode([
        "success" => false,
        "message" => "Report not found."
    ]);

    exit;
}


/* ==================================
   Update Status
================================== */

$updateSql = "
    UPDATE reports
    SET status = ?
    WHERE id = ?
";


$stmt = mysqli_prepare(
    $conn,
    $updateSql
);


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Update prepare error: " .
                     mysqli_error($conn)
    ]);

    exit;
}


mysqli_stmt_bind_param(
    $stmt,
    "si",
    $status,
    $id
);


/* ==================================
   Execute Update
================================== */

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "success" => true,
        "message" => "Status updated successfully.",
        "id" => $id,
        "status" => $status
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Status update failed: " .
                     mysqli_stmt_error($stmt)
    ]);

}


mysqli_stmt_close($stmt);

mysqli_close($conn);

exit;

?>