<?php
require_once __DIR__ . "/config.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (isset($_GET['id'])) {
    $id  = (int)$_GET['id'];

    $sql = "SELECT b.*, 
                   c.name  AS category_name,
                   br.name AS brand_name
            FROM bicycles b
            LEFT JOIN categories c  ON b.category_id = c.id
            LEFT JOIN brands br     ON b.brand_id    = br.id
            WHERE b.id = $id
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'data'    => [
                'bicycle_id'       => (int)$row['id'],
                'name'             => $row['name'],
                'price'            => (int)$row['price'],
                'frame_size'       => $row['frame_size'],
                'condition_status' => $row['condition_status'],
                'brand_name'       => $row['brand_name'],
                'category_name'    => $row['category_name'],
                'location'         => $row['location'],
                'main_image'       => $row['main_image'],
            ]
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => "Xe #$id không tồn tại"
        ]);
    }
    exit;
}

if (($_GET['action'] ?? '') === 'list') {
    $sql = "SELECT b.id, b.name, b.price,
                   b.frame_size, b.condition_status, b.location,
                   br.name AS brand_name
            FROM bicycles b
            LEFT JOIN brands br ON b.brand_id = br.id
            ORDER BY b.id ASC";

    $result = mysqli_query($conn, $sql);
    $bikes  = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $bikes[] = [
            'bicycle_id'       => (int)$row['id'],
            'name'             => $row['name'],
            'price'            => (int)$row['price'],
            'frame_size'       => $row['frame_size'],
            'condition_status' => $row['condition_status'],
            'brand_name'       => $row['brand_name'],
            'location'         => $row['location'],
        ];
    }

    echo json_encode(['success' => true, 'data' => $bikes]);
    exit;
}

http_response_code(400);
echo json_encode([
    'success' => false,
    'message' => 'Thiếu tham số. Dùng ?id=1 hoặc ?action=list'
]);