<?php

include "db.php";

header("Content-Type: application/json");


/* ==================================
   Get Current Report ID
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
   Get Current Report
================================== */

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
            status
        FROM reports
        WHERE id = ?";


$stmt = mysqli_prepare(
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


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);


$currentReport =
    mysqli_fetch_assoc($result);


mysqli_stmt_close($stmt);


if (!$currentReport) {

    echo json_encode([
        "success" => false,
        "message" => "Report not found."
    ]);

    exit;
}


/* ==================================
   Determine Opposite Type
================================== */

$oppositeType =
    ($currentReport["type"] === "Lost")
    ? "Found"
    : "Lost";


/* ==================================
   Search Values
================================== */

$category =
    $currentReport["category"];

$itemName =
    trim($currentReport["item_name"]);

$location =
    trim($currentReport["location"]);


/*
   Search using:
   - Opposite Lost/Found type
   - Same category
   - Similar item name OR location
   - Pending status
   - Exclude current report
*/

$itemSearch =
    "%" . $itemName . "%";

$locationSearch =
    "%" . $location . "%";


/* ==================================
   Find Possible Matches
================================== */

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
            status
        FROM reports
        WHERE type = ?
        AND category = ?
        AND status = 'Pending'
        AND id != ?
        AND (
            item_name LIKE ?
            OR location LIKE ?
        )
        ORDER BY id DESC";


$stmt2 = mysqli_prepare(
    $conn,
    $sql
);


if (!$stmt2) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . mysqli_error($conn)
    ]);

    exit;
}


mysqli_stmt_bind_param(
    $stmt2,
    "ssiss",
    $oppositeType,
    $category,
    $id,
    $itemSearch,
    $locationSearch
);


mysqli_stmt_execute(
    $stmt2
);


$result2 =
    mysqli_stmt_get_result(
        $stmt2
    );


$matches = [];


while (
    $row = mysqli_fetch_assoc($result2)
) {

    $matches[] = $row;

}


mysqli_stmt_close($stmt2);

mysqli_close($conn);


/* ==================================
   Return Matches
================================== */

echo json_encode([
    "success" => true,
    "current_report" => $currentReport,
    "matches" => $matches,
    "count" => count($matches)
]);

?>