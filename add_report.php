<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../frontend/add.html?error=" . urlencode("Invalid request."));
    exit;
}

$type = trim($_POST["type"] ?? "");
$item_name = trim($_POST["item_name"] ?? "");
$description = trim($_POST["description"] ?? "");
$category = trim($_POST["category"] ?? "");
$location = trim($_POST["location"] ?? "");
$report_date = trim($_POST["report_date"] ?? "");
$person_name = trim($_POST["person_name"] ?? "");
$phone = trim($_POST["phone"] ?? "");


/* -------------------------------
   Required Field Validation
-------------------------------- */

if (
    $type === "" ||
    $item_name === "" ||
    $category === "" ||
    $location === "" ||
    $report_date === "" ||
    $person_name === "" ||
    $phone === ""
) {
    header(
        "Location: ../frontend/add.html?error=" .
        urlencode("Please fill all required fields.")
    );
    exit;
}


/* -------------------------------
   Type Validation
-------------------------------- */

if (!in_array($type, ["Lost", "Found"], true)) {

    header(
        "Location: ../frontend/add.html?error=" .
        urlencode("Invalid report type.")
    );

    exit;
}


/* -------------------------------
   Phone Validation
-------------------------------- */

if (!preg_match("/^[0-9]{10}$/", $phone)) {

    header(
        "Location: ../frontend/add.html?error=" .
        urlencode("Please enter a valid 10-digit phone number.")
    );

    exit;
}


/* -------------------------------
   Insert Report
-------------------------------- */

$sql = "INSERT INTO reports
(
    item_name,
    description,
    category,
    location,
    report_date,
    person_name,
    phone,
    type
)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {

    header(
        "Location: ../frontend/add.html?error=" .
        urlencode("Database error: " . mysqli_error($conn))
    );

    exit;
}


/* -------------------------------
   Bind Parameters
-------------------------------- */

mysqli_stmt_bind_param(
    $stmt,
    "ssssssss",
    $item_name,
    $description,
    $category,
    $location,
    $report_date,
    $person_name,
    $phone,
    $type
);


/* -------------------------------
   Execute Query
-------------------------------- */

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header(
        "Location: ../frontend/add.html?success=1"
    );

    exit;
}


/* -------------------------------
   Insert Error
-------------------------------- */

$error = mysqli_stmt_error($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conn);

header(
    "Location: ../frontend/add.html?error=" .
    urlencode("Database Insert Error: " . $error)
);

exit;

?>