CREATE DATABASE php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE php;


CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  phone VARCHAR(30) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE agencies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE trips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  departure_agency_id INT NOT NULL,
  arrival_agency_id INT NOT NULL,
  departure_at DATETIME NOT NULL,
  arrival_at DATETIME NOT NULL,
  total_seats INT NOT NULL,
  available_seats INT NOT NULL,
  contact_user_id INT NOT NULL,
  created_by_user_id INT NOT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  CONSTRAINT chk_seats CHECK (total_seats >= 1 AND available_seats >= 0 AND available_seats <= total_seats),
  CONSTRAINT fk_dep FOREIGN KEY (departure_agency_id) REFERENCES agencies(id) ON DELETE RESTRICT,
  CONSTRAINT fk_arr FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id) ON DELETE RESTRICT,
  CONSTRAINT fk_contact FOREIGN KEY (contact_user_id) REFERENCES users(id) ON DELETE RESTRICT,
  CONSTRAINT fk_created_by FOREIGN KEY (created_by_user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
