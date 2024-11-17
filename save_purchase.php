<?php
// save_purchase.php
$connect = mysqli_connect("localhost", "root", "", "anthea");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $items = $data['cart'];
    $paymentMethod = $data['paymentMethod'];

    foreach ($items as $item) {
        $name = mysqli_real_escape_string($connect, $item['name']);
        $price = floatval($item['price']);

        $query = "INSERT INTO purchases (item_name, item_price, payment_method) VALUES ('$name', '$price', '$paymentMethod')";
        mysqli_query($connect, $query);
    }
    echo json_encode(['status' => 'success']);
}
?>
