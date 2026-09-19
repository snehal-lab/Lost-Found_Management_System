<?php

include "db.php";

header("Content-Type: application/json");

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid report ID."
    ]);

    exit;
}


$sql = "SELECT
            id,
            item_name,
            description,
            category,
            location,
            report_date,
            person_name,
            phone,
            type,
            status,
            created_at
        FROM reports
        WHERE id = ?";


$stmt = mysqli_prepare($conn, $sql);


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


if (!mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "success" => false,
        "message" => mysqli_stmt_error($stmt)
    ]);

    exit;
}


$result = mysqli_stmt_get_result($stmt);

$report = mysqli_fetch_assoc($result);


if (!$report) {

    echo json_encode([
        "success" => false,
        "message" => "Report not found."
    ]);

    exit;
}


echo json_encode([
    "success" => true,
    "data" => $report
]);


mysqli_stmt_close($stmt);
mysqli_close($conn);

?>