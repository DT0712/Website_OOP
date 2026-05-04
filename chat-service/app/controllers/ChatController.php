<?php 
require_once __DIR__ . '/../services/ChatHistoryService.php';
require_once __DIR__ . '/../services/AIService.php';
require_once __DIR__ . '/../services/ProductService.php';

class ChatController {

    public function send() {

        // cho PHP chờ lâu hơn (rất quan trọng)
        set_time_limit(120);
        ini_set('max_execution_time',120);
        ini_set('default_socket_timeout',120);

        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);

        $message = strtolower(trim($input["message"] ?? ""));
        $session = $input["session_id"] ?? "guest";

        if(!$message){
            echo json_encode(["reply"=>"No message"]);
            return;
        }

        try {

            // =====================================================
            // 1️⃣ LƯU USER MESSAGE
            // =====================================================
            ChatHistoryService::saveUserMessage($session, $message);

            // =====================================================
            // 2️⃣ KIỂM TRA CÓ PHẢI CÂU HỎI VỀ SẢN PHẨM KHÔNG
            // =====================================================
            $isProductQuestion = $this->isProductQuestion($message);

            if ($isProductQuestion) {

                $product = ProductService::findProductByName($message);

                if ($product) {

                    $reply = $this->buildProductReply($message, $product);

                    // lưu bot reply
                    ChatHistoryService::saveAIMessage($session, $reply);

                    echo json_encode([
                        "status" => "success",
                        "reply"  => $reply
                    ]);
                    return;
                }
            }

            // =====================================================
            // 3️⃣ KHÔNG PHẢI HỎI SẢN PHẨM → GỌI AI
            // =====================================================
            $history = ChatHistoryService::getHistory($session);
            $reply   = AIService::ask($history, $message);

            ChatHistoryService::saveAIMessage($session, $reply);

            echo json_encode([
                "status" => "success",
                "reply"  => $reply
            ]);

        } catch(Exception $e){

            echo json_encode([
                "status" => "error",
                "reply"  => $e->getMessage()
            ]);
        }
    }


    // =====================================================
    // HÀM NHẬN DIỆN CÂU HỎI SẢN PHẨM
    // =====================================================
    private function isProductQuestion($message) {

        $keywords = [
            "giá",
            "bao nhiêu",
            "price",
            "xe",
            "bicycle",
            "mô tả",
            "thông tin",
            "còn hàng"
        ];

        foreach ($keywords as $k) {
            if (str_contains($message, $k)) {
                return true;
            }
        }
        return false;
    }


    // =====================================================
    // HÀM TẠO CÂU TRẢ LỜI SẢN PHẨM
    // =====================================================
    private function buildProductReply($message, $product) {

        $name  = $product['name'];
        $price = number_format($product['price'],0,',','.');
        $desc  = $product['description'];

        // hỏi giá
        if (str_contains($message, "giá") || str_contains($message, "bao nhiêu")) {
            return "🚴 Xe **$name** hiện có giá **$price VNĐ**.";
        }

        // hỏi mô tả
        if (str_contains($message, "mô tả") || str_contains($message, "thông tin")) {
            return "📄 Thông tin xe **$name**: $desc";
        }

        // hỏi chung chung
        return "🚴 **$name**
💰 Giá: $price VNĐ
📄 Mô tả: $desc";
    }
}