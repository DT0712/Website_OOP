# Hướng dẫn Copilot cho dự án Website_OOP (định dạng GitHub)

> Tóm tắt ngắn: bộ microservices PHP nhỏ, không sử dụng framework lớn. Mỗi service là một app PHP thuần với public/index.php làm entrypoint.

## Lệnh build / test / lint

- Không tìm thấy composer.json, package.json, hoặc framework test/lint trong repo.
- Chạy từng service thủ công bằng PHP built-in server:
  - Ví dụ (chạy trong thư mục service, ví dụ `user-service`):
    php -S localhost:8001 -t public/
  - Thay đổi cổng theo service bạn đang chạy.
- Kiểm tra một endpoint (ví dụ Payment service):
  - curl -X GET http://localhost:PORT/  # nhiều service trả về health/route cơ bản

> Nếu bắt đầu thêm composer / PHPUnit / PHPStan, cập nhật file này với cách chạy `composer install`, `vendor/bin/phpunit <testfile>` và linter commands.

## Kiến trúc tổng quan (high-level)

- Kiến trúc: tập hợp microservices nhỏ (mỗi service là một PHP app):
  - api-gateway/ — proxy rất nhỏ (ví dụ: chuyển /users → http://localhost:8001)
  - user-service/ — quản lý user (controllers, services, models)
  - payment-service/ — endpoint thanh toán (POST để tạo/cập nhật; GET health)
  - chat-service/ — endpoint chat (Router::handle())
  - Inspection-Service/ — API kiểm định (tạo báo cáo, thống kê, duyệt/từ chối)
  - file-service/ và có thể các dịch vụ khác theo cùng pattern
- Mỗi service thường có: app/ (controllers, models, services, core), public/ (entrypoint), uploads/ hoặc storage/ cho file, config/ và Dockerfile (nếu có).
- Giao tiếp giữa service: gọi HTTP trực tiếp (InspectionController gọi bicycle service qua URL). API gateway dùng làm proxy đơn giản cho một vài route.
- Cơ sở dữ liệu: SQL thô có trong repo (oop_bicycle_system.sql, Inspection-Service/db_inspection.sql). Các service dùng config DB nội bộ (no ORM).

## Quy ước chính của codebase

- Entrypoint: public/index.php trong mỗi service; một số service tự parse REQUEST_URI để định tuyến.
- Router: simple routing implemented in app/core/Router.php (xuất hiện trong user-service và chat-service).
- Autoload: dùng spl_autoload_register tìm trong các thư mục cố định: core, controllers, models, services, config (xem chat-service/app/bootstrap.php).
- Naming: Controller = XController.php, Service = XService.php, Model = X.php.
- Input/Response: Controller đọc dữ liệu từ php://input hoặc $_POST/$_FILES; Response helper (Response::json/success/error) để trả JSON.
- Auth:
  - Inspection-Service: header-based auth với X-User-Id và X-User-Role; middleware AuthMiddleware::requireRole kiểm tra role.
  - user-service: login demo trả JWT (xem UserController::login — test credential: admin@gmail.com / 123).
- File upload: controllers lưu file vào uploads/ hoặc uploads/avatars/; có kiểm tra kiểu và kích thước.
- Docker: nhiều service có Dockerfile nhưng không có docker-compose; nếu containerizing, build từng Dockerfile.

## Hướng dẫn khi Copilot đề xuất code

- Giữ phong cách PHP thuần hiện có: require_once rõ ràng, controllers nhỏ, helpers chung.
- Nếu thay đổi API public, cập nhật public/index.php và app/core/Router.php tương ứng.
- Khi thêm depend hoặc toolchain (composer, PHPUnit), ghi rõ cách cài và chạy trong phần "Build / test / lint".
- Tránh đưa vào cấu hình CI/CD giả định (ví dụ: GitHub Actions) trừ khi repo thêm các file cấu hình tương ứng.

## Các vị trí cần đọc để hiểu sâu

- public/index.php của từng service — entrypoint và routing
- app/core/Router.php — pattern định tuyến dùng trong nhiều service
- Inspection-Service/app/controllers/InspectionController.php — ví dụ nhiều logic nghiệp vụ + gọi service khác
- auth middleware: Inspection-Service/app/middleware/AuthMiddleware.php — xác thực theo header
- SQL files: oop_bicycle_system.sql, Inspection-Service/db_inspection.sql

## Ghi chú tích hợp với file README / Docker / 기타

- Nếu README hoặc CONTRIBUTING xuất hiện, hợp nhất phần cài đặt local / ports / env vào đây.
- Có Dockerfile/service — thêm docker-compose nếu muốn chạy nhiều service cùng lúc.

---

## Run & Deploy với Docker (local)

Một docker-compose.yml và Dockerfile cho payment-service và chat-service đã được thêm vào repository root và hai thư mục service tương ứng.

Các lệnh cơ bản:

- Build & chạy (chạy trong thư mục repo root):
  - docker-compose up --build -d
- Xem logs:
  - docker-compose logs -f payment-service
  - docker-compose logs -f chat-service
- Dừng & xóa containers:
  - docker-compose down

Ports mặc định (từ docker-compose.yml):
- payment-service → http://localhost:8002/
- chat-service    → http://localhost:8003/

Lưu ý vận hành:
- Các Dockerfile dùng image php:8.1-apache và mount mã nguồn vào /var/www/html. Nếu muốn chạy code mà không mount (biên dịch image tĩnh), xóa volumes trong docker-compose.yml.
- Không có database container trong compose hiện tại. Nếu dịch vụ cần DB, thêm service DB (mysql/postgres) và cập nhật file config DB trong từng service hoặc .env.
- Uploads/avatars được mount vào container thông qua volume (mã nguồn); dữ liệu địa phương sẽ xuất hiện trong thư mục uploads/ tương ứng.

Nếu muốn, có thể mở rộng docker-compose để include:
- MySQL/MariaDB + phpMyAdmin
- API gateway
- user-service


Nếu muốn mình chạy kiểm tra cục bộ (tạo hướng dẫn bước-1 để chạy docker trên máy của bạn), hay mở rộng compose để chạy toàn bộ hệ thống, chọn option mong muốn.