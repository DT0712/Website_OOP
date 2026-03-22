<?php
require_once "models/Order.php";

class OrderController {
    private $model;

    public function __construct() {
        session_start();

        // giả lập login (sau này bỏ)
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1;
        }

        $this->model = new Order();
    }

    public function index() {
        $orders = $this->model->getByBuyer($_SESSION['user_id']);
        require __DIR__ . "/../views/orders.php";
    }

    // Buyer đặt cọc
    public function deposit() {
        $id = $_GET['id'];
        $amount = $_GET['amount'];

        $order = $this->model->getByBuyer($id);
        $price = $order['price'];

        $minDeposit = max($price * 0.2, 500000);

        if ($amount < $minDeposit) {
            die("Số tiền cọc không hợp lệ!");
        }

        $this->model->updateDeposit($id, $amount);
        header("Location: index.php");
    }

    // Hủy đơn
    public function cancel() {
        $id = $_GET['id'];
        $this->model->updateStatus($id, 'cancelled');
        header("Location: index.php");
    }
}