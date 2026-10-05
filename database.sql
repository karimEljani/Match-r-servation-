CREATE DATABASE IF NOT EXISTS match_reservation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE match_reservation;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(180) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(180) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE stadiums (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 address VARCHAR(255),
 capacity INT NOT NULL DEFAULT 1000
);

CREATE TABLE matches (
 id INT AUTO_INCREMENT PRIMARY KEY,
 home_team VARCHAR(120) NOT NULL,
 away_team VARCHAR(120) NOT NULL,
 competition VARCHAR(120) NOT NULL,
 match_date DATETIME NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 stadium_id INT NOT NULL,
 total_seats INT NOT NULL DEFAULT 1000,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_match_stadium FOREIGN KEY(stadium_id) REFERENCES stadiums(id) ON DELETE RESTRICT
);

CREATE TABLE reservations (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 match_id INT NOT NULL,
 quantity INT NOT NULL,
 total_price DECIMAL(10,2) NOT NULL,
 status ENUM('confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_res_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 CONSTRAINT fk_res_match FOREIGN KEY(match_id) REFERENCES matches(id) ON DELETE CASCADE
);

INSERT INTO admins(name,email,password) VALUES
('Administrateur','admin@matchticket.local','$2y$12$auJCeYoSJFzyjZmiSROHx..y0ay3/wbWk1aFUfOrzGiyYcGyZu186');

INSERT INTO stadiums(name,address,capacity) VALUES
('Stade Olympique de Radès','Radès, Tunisie',60000),
('Stade de Sousse','Sousse, Tunisie',40000),
('Stade Mustapha Ben Jannet','Monastir, Tunisie',20000);

INSERT INTO matches(home_team,away_team,competition,match_date,price,stadium_id,total_seats) VALUES
('Club Africain','Espérance de Tunis','Ligue 1','2026-12-10 19:00:00',35.00,1,5000),
('Étoile du Sahel','CS Sfaxien','Ligue 1','2026-12-15 18:00:00',25.00,2,3500),
('Tunisie','Maroc','Match international','2027-01-20 20:00:00',50.00,1,8000);
