<?php
class FileController {

    public function delete() {

        header('Content-Type: application/json');

        $file = $_GET['file'] ?? null;

        if (!$file) {
            echo json_encode(["error" => "No file"]);
            return;
        }

        if (strpos($file, 'suggest') !== false) {
            echo json_encode(["error" => "Cannot delete suggest images"]);
            return;
        }

        $path = __DIR__ . '/../../storage/' . $file;

        if (file_exists($path)) {
            unlink($path);
            echo json_encode([
                "status" => "success",
                "deleted" => $file
            ]);
        } else {
            echo json_encode([
                "error" => "File not found",
                "debug_path" => $path
            ]);
        }
    }
}