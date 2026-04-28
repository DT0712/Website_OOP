<?php
class AuthMiddleware {

    public static function getUser() {
        $user_id   = $_SERVER['HTTP_X_USER_ID']   ?? null;
        $user_role = $_SERVER['HTTP_X_USER_ROLE']  ?? null;

        if (!$user_id || !$user_role) {
            Response::error("Unauthorized: thiếu thông tin xác thực", 401);
        }

        return [
            'id'   => (int)$user_id,
            'role' => $user_role
        ];
    }

    public static function requireRole(string $required_role) {
        $user = self::getUser();
        if ($user['role'] !== $required_role) {
            Response::error("Forbidden: yêu cầu role '{$required_role}'", 403);
        }
        return $user;
    }

    public static function requireAnyRole(array $roles) {
        $user = self::getUser();
        if (!in_array($user['role'], $roles)) {
            Response::error("Forbidden: không đủ quyền truy cập", 403);
        }
        return $user;
    }
}