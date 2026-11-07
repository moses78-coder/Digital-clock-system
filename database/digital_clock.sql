CREATE DATABASE IF NOT EXISTS digital_clock_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE digital_clock_db;
CREATE TABLE IF NOT EXISTS alarms (
 id INT AUTO_INCREMENT PRIMARY KEY,
 label VARCHAR(80) NOT NULL,
 alarm_at DATETIME NOT NULL,
 repeat_daily TINYINT(1) NOT NULL DEFAULT 0,
 is_enabled TINYINT(1) NOT NULL DEFAULT 1,
 last_triggered_date DATE NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_alarm_enabled_time(is_enabled,alarm_at)
) ENGINE=InnoDB;
