CREATE DATABASE  akinator_db;
USE akinator_db;

-- Table users (doit être créée en premier car référencée par games)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table results (doit être créée avant games et answers qui la référencent)
CREATE TABLE results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

-- Table questions (doit être créée avant answers qui la référence)
CREATE TABLE questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    text TEXT NOT NULL,
    is_first_question BOOLEAN DEFAULT FALSE
);

-- Table answers
CREATE TABLE answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    questions_id INT NOT NULL,
    response ENUM('Oui', 'Non') NOT NULL,
    next_question INT NULL,
    result_id INT NULL,
    FOREIGN KEY (questions_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE SET NULL
);

-- Table games (doit être créée en dernier car elle référence users et results)
CREATE TABLE games (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    result_id INT,
    date DATETIMEv,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE SET NULL
); 