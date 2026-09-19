<?php

include "db.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");


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
        ORDER BY id DESC";


$result = mysqli_query($conn, $sql);


if (!$result) {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . mysqli_error($conn)
    ]);

    exit;
}


$reports = [];


while ($row = mysqli_fetch_assoc($result)) {

    $reports[] = $row;

}


echo json_encode([
    "success" => true,
    "data" => $reports
]);


mysqli_close($conn);

?>