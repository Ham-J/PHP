USE php;

DELETE FROM trips;
DELETE FROM agencies;
DELETE FROM users;

ALTER TABLE trips AUTO_INCREMENT = 1;
ALTER TABLE agencies AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;

INSERT INTO users (first_name, last_name, email, phone, password_hash, role) VALUES
('John',      'Dubois',    'john@test.com',     '0601020304', '$2y$10$2pJk8sYFh4x5l9m1lQbqLeZz8nE1m3Y9iYcYl5c5o0sJ7CwG2R7rO', 'user'),
('Sebastien', 'Martin',    'sebastien@test.com','0611223344', '$2y$10$2pJk8sYFh4x5l9m1lQbqLeZz8nE1m3Y9iYcYl5c5o0sJ7CwG2R7rO', 'user'),
('Bernard',   'Leroy',     'bernard@test.com',  '0622334455', '$2y$10$2pJk8sYFh4x5l9m1lQbqLeZz8nE1m3Y9iYcYl5c5o0sJ7rO',      'user'),
('Isabelle',  'Moreau',    'isabelle@test.com', '0633445566', '$2y$10$2pJk8sYFh4x5l9m1lQbqLeZz8nE1m3Y9iYcYl5c5o0sJ7rO',      'user'),
('Anna',      'Bernier',   'anna@test.com',     '0644556677', '$2y$10$yEqOnbQXh7yxu9xvnzZQkuH5L1n5v6sWzQ5oA2tfqCkAvbQhY7h7a', 'admin');

INSERT INTO agencies (name) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Lille'),
('Nantes');

INSERT INTO trips (departure_agency_id, arrival_agency_id, departure_at, arrival_at, total_seats, available_seats, contact_user_id, created_by_user_id) VALUES
(1, 2, DATE_ADD(NOW(), INTERVAL 1 DAY),  DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY),  INTERVAL 3 HOUR), 4, 2, 1, 1),
(2, 3, DATE_ADD(NOW(), INTERVAL 2 DAY),  DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY),  INTERVAL 4 HOUR), 3, 1, 2, 2),
(4, 5, DATE_ADD(NOW(), INTERVAL 3 DAY),  DATE_ADD(DATE_ADD(NOW(), INTERVAL 3 DAY),  INTERVAL 2 HOUR), 5, 5, 3, 3),
(3, 1, DATE_ADD(NOW(), INTERVAL 4 DAY),  DATE_ADD(DATE_ADD(NOW(), INTERVAL 4 DAY),  INTERVAL 5 HOUR), 3, 2, 4, 4),
(5, 2, DATE_ADD(NOW(), INTERVAL 5 DAY),  DATE_ADD(DATE_ADD(NOW(), INTERVAL 5 DAY),  INTERVAL 1 HOUR), 2, 1, 5, 5),
(1, 4, DATE_ADD(NOW(), INTERVAL 6 DAY),  DATE_ADD(DATE_ADD(NOW(), INTERVAL 6 DAY),  INTERVAL 3 HOUR), 6, 4, 1, 1);
