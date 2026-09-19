<?php

include "db.php";

header("Content-Type: application/json");


/* ==================================
   Get Search / Filter Values
================================== */

$keyword = trim($_GET["keyword"] ?? "");
$category = trim($_GET["category"] ?? "");
$type = trim($_GET["type"] ?? "");
$status = trim($_GET["status"] ?? "");


/* ==================================
   Base Query
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
            status,
            created_at
        FROM reports
        WHERE 1=1";


$params = [];

$types = "";


/* ==================================
   Keyword Search
================================== */

if ($keyword !== "") {

    $sql .= "
        AND (
            item_name LIKE ?
            OR description LIKE ?
            OR location LIKE ?
            OR person_name LIKE ?
        )
    ";

    $searchKeyword = "%" . $keyword . "%";

    $params[] = $searchKeyword;
    $params[] = $searchKeyword;
    $params[] = $searchKeyword;
    $params[] = $searchKeyword;

    $types .= "ssss";
}


/* ==================================
   Category Filter
================================== */

if ($category !== "") {

    $sql .= " AND category = ?";

    $params[] = $category;

    $types .= "s";
}


/* ==================================
   Type Filter
================================== */

if ($type !== "") {

    $sql .= " AND type = ?";

    $params[] = $type;

    $types .= "s";
}


/* ==================================
   Status Filter
================================== */

if ($status !== "") {

    $sql .= " AND status = ?";

    $params[] = $status;

    $types .= "s";
}


/* ==================================
   Order
================================== */

$sql .= " ORDER BY id DESC";


/* ==================================
   Prepare
================================== */

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


/* ==================================
   Bind Parameters
================================== */

if (!empty($params)) {

    mysqli_stmt_bind_param(
        $stmt,
        $types,
        ...$params
    );
}


/* ==================================
   Execute
================================== */

if (!mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "success" => false,
        "message" => mysqli_stmt_error($stmt)
    ]);

    exit;
}


/* ==================================
   Get Results
================================== */

$result = mysqli_stmt_get_result($stmt);

$reports = [];


while ($row = mysqli_fetch_assoc($result)) {

    $reports[] = $row;

}


/* ==================================
   Return JSON
================================== */

echo json_encode([
    "success" => true,
    "data" => $reports,
    "count" => count($reports)
]);


mysqli_stmt_close($stmt);

mysqli_close($conn);

?>