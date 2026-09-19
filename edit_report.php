<?php

include "db.php";


/* ==================================
   Check Request
================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header(
        "Location: ../frontend/reports.html?error=" .
        urlencode("Invalid request.")
    );

    exit;
}


/* ==================================
   Get Form Data
================================== */

$id = intval($_POST["id"] ?? 0);

$type = trim($_POST["type"] ?? "");

$item_name = trim(
    $_POST["item_name"] ?? ""
);

$description = trim(
    $_POST["description"] ?? ""
);

$category = trim(
    $_POST["category"] ?? ""
);

$location = trim(
    $_POST["location"] ?? ""
);

$report_date = trim(
    $_POST["report_date"] ?? ""
);

$person_name = trim(
    $_POST["person_name"] ?? ""
);

$phone = trim(
    $_POST["phone"] ?? ""
);


/* ==================================
   Required Field Validation
================================== */

if (
    $id <= 0 ||
    $type === "" ||
    $item_name === "" ||
    $category === "" ||
    $location === "" ||
    $report_date === "" ||
    $person_name === "" ||
    $phone === ""
) {

    header(
        "Location: ../frontend/edit.html?id=" .
        $id .
        "&error=" .
        urlencode("Please fill all required fields.")
    );

    exit;
}


/* ==================================
   Type Validation
================================== */

if (
    !in_array(
        $type,
        ["Lost", "Found"],
        true
    )
) {

    header(
        "Location: ../frontend/edit.html?id=" .
        $id .
        "&error=" .
        urlencode("Invalid report type.")
    );

    exit;
}


/* ==================================
   Phone Validation
================================== */

if (
    !preg_match(
        "/^[0-9]{10}$/",
        $phone
    )
) {

    header(
        "Location: ../frontend/edit.html?id=" .
        $id .
        "&error=" .
        urlencode(
            "Please enter a valid 10-digit phone number."
        )
    );

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

    header(
        "Location: ../frontend/edit.html?id=" .
        $id .
        "&error=" .
        urlencode(
            "Database error: " .
            mysqli_error($conn)
        )
    );

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

    header(
        "Location: ../frontend/reports.html?error=" .
        urlencode("Report not found.")
    );

    exit;
}


mysqli_stmt_close(
    $checkStmt
);


/* ==================================
   Update Report
================================== */

$sql = "UPDATE reports SET
            item_name = ?,
            description = ?,
            category = ?,
            location = ?,
            report_date = ?,
            person_name = ?,
            phone = ?,
            type = ?
        WHERE id = ?";


$stmt =
    mysqli_prepare(
        $conn,
        $sql
    );


if (!$stmt) {

    header(
        "Location: ../frontend/edit.html?id=" .
        $id .
        "&error=" .
        urlencode(
            "Database error: " .
            mysqli_error($conn)
        )
    );

    exit;
}


/* ==================================
   Bind Parameters
================================== */

mysqli_stmt_bind_param(
    $stmt,
    "ssssssssi",
    $item_name,
    $description,
    $category,
    $location,
    $report_date,
    $person_name,
    $phone,
    $type,
    $id
);


/* ==================================
   Execute Update
================================== */

if (
    mysqli_stmt_execute($stmt)
) {

    mysqli_stmt_close(
        $stmt
    );

    mysqli_close(
        $conn
    );

    header(
        "Location: ../frontend/reports.html?updated=1"
    );

    exit;
}


/* ==================================
   Update Error
================================== */

$error =
    mysqli_stmt_error($stmt);


mysqli_stmt_close(
    $stmt
);

mysqli_close(
    $conn
);


header(
    "Location: ../frontend/edit.html?id=" .
    $id .
    "&error=" .
    urlencode(
        "Update failed: " . $error
    )
);

exit;

?>