<?php

include "db.php";

header("Content-Type: application/json");


/* ==================================
   Get Report ID
================================== */

$id = intval($_GET["id"] ?? 0);


if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid report ID."
    ]);

    exit;
}


/* ==================================
   Check Report Exists
================================== */

$checkSql =
    "SELECT id FROM reports WHERE id = ?";

$checkStmt =
    mysqli_prepare(
        $conn,
        $checkSql
    );


if (!$checkStmt) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . mysqli_error($conn)
    ]);

    exit;
}


mysqli_stmt_bind_param(
    $checkStmt,
    "i",
    $id
);


mysqli_stmt_execute(
    $checkStmt
);


$checkResult =
    mysqli_stmt_get_result(
        $checkStmt
    );


if (!mysqli_fetch_assoc($checkResult)) {

    mysqli_stmt_close(
        $checkStmt
    );

    mysqli_close(
        $conn
    );

    echo json_encode([
        "success" => false,
        "message" => "Report not found."
    ]);

    exit;
}


mysqli_stmt_close(
    $checkStmt
);


/* ==================================
   Delete Report
================================== */

$sql =
    "DELETE FROM reports WHERE id = ?";


$stmt =
    mysqli_prepare(
        $conn,
        $sql
    );


if (!$stmt) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . mysqli_error($conn)
    ]);

    exit;
}


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


/* ==================================
   Execute Delete
================================== */

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close(
        $stmt
    );

    mysqli_close(
        $conn
    );

    echo json_encode([
        "success" => true,
        "message" => "Report deleted successfully."
    ]);

    exit;
}


/* ==================================
   Delete Error
================================== */

$error =
    mysqli_stmt_error($stmt);


mysqli_stmt_close(
    $stmt
);

mysqli_close(
    $conn
);


echo json_encode([
    "success" => false,
    "message" => "Delete failed: " . $error
]);

exit;

?>