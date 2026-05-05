-- db_inspection.sql
CREATE DATABASE IF NOT EXISTS db_inspection
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE db_inspection;

CREATE TABLE inspection_reports (
  id                   INT AUTO_INCREMENT PRIMARY KEY,

  -- Tham chiếu sang service khác, KHÔNG dùng FOREIGN KEY
  bicycle_id           INT NOT NULL,
  inspector_id         INT NOT NULL,

  -- Checklist kỹ thuật xe đạp
  frame_condition      ENUM('good','fair','poor') NOT NULL,
  brake_condition      ENUM('good','fair','poor') NOT NULL,
  drivetrain_condition ENUM('good','fair','poor') NOT NULL,
  tire_condition       ENUM('good','fair','poor') NOT NULL,

  overall_score        TINYINT      NOT NULL,   -- 0 đến 100
  notes                TEXT         DEFAULT NULL,
  report_file          VARCHAR(255) DEFAULT NULL, -- file ảnh/PDF upload

  -- Trạng thái duyệt
  status               ENUM('pending','approved','rejected') DEFAULT 'pending',
  approved_by          INT          DEFAULT NULL, -- admin_id
  approved_at          DATETIME     DEFAULT NULL,

  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);