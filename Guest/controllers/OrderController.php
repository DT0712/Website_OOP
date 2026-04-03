<?php
require_once "models/Order.php";

class OrderController {
    private $model;

    public function __construct() {
        // giả lập login (sau này bỏ)
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 1;
        }

        $this->model = new Order();
    }

    public function index() {
        $buyer_id = $_SESSION['user_id'];
        $orders = $this->model->getByBuyer($buyer_id);
        $brands = $this->model->getPurchasedBrands($buyer_id);
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
        header("Location: buyer_order.php");
        exit;
    }

    // Hủy đơn
    public function cancel() {
        $order_id = $_GET['id'];
        $buyer_id = $_SESSION['user_id'];

        // check quyền + trạng thái
        $order = $this->model->getById($order_id);

        if (!$order) {
            die("Đơn không tồn tại!");
        }

        if ($order['buyer_id'] != $buyer_id) {
            die("Bạn không có quyền!");
        }

        // không cho hủy nếu đã hoàn thành
        if ($order['status'] == 'completed') {
            die("Không thể hủy đơn đã hoàn thành!");
        }

        // cập nhật trạng thái
        $this->model->cancelOrder($order_id);

        // reload lại trang
        header("Location: buyer_order.php");
        exit;
    }
}