-- Création de la table games
CREATE TABLE games (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    result_id INT NOT NULL,
    date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (result_id) REFERENCES result(id)
);

-- Insertion des résultats
INSERT INTO results (name, description, image_url) VALUES
('Miko', 'Un personnage maniant un katana.', 'miko.png'),
('Lunatic', 'Un personnage combattant sans katana.', 'lunatic.png'),
('Fallen', 'Un personnage qui peut voler.', 'fallen.png'),
('Seigen', 'Un personnage qui ne peut pas voler.', 'seigen.png'),
('The Strongest Sorcerer/ GOJO', 'Un personnage maîtrisant l'infini.', 'gojo.png'),
('The King of Curses/ Sukuna', 'Un roi des malédictions.', 'sukuna.png'),
('Shin Goren', 'Un esprit démoniaque.', 'shin_goren.png'),
('Goren', 'Un personnage ordinaire.', 'goren.png'),
('Wonderboy', 'Un boxeur utilisant des gants.', 'wonderboy.png'),
('Nakmuay', 'Un combattant sans gants.', 'nakmuay.png');

-- Insertion des questions
INSERT INTO questions (text, is_first_question) VALUES
('Le personnage utilise-t-il une arme blanche ?', TRUE),
('Est-ce une femme ?', FALSE),
('Son arme est un katana ?', FALSE),
('Peut-il voler ?', FALSE),
('Utilise une sorte de magie ?', FALSE),
('Provient-il d'un manga ?', FALSE),
('Utilise-t-il l'infini ?', FALSE),
('Est-il l'esprit démoniaque ?', FALSE),
('Utilise-t-il des gants de boxe ?', FALSE);

-- Insertion des réponses
INSERT INTO answers (questions_id, response, next_question, result_id) VALUES
(1, 'Oui', 2, NULL),
(1, 'Non', 5, NULL),
(2, 'Oui', 3, NULL),
(2, 'Non', 4, NULL),
(3, 'Oui', NULL, 1),
(3, 'Non', NULL, 2),
(4, 'Oui', NULL, 3),
(4, 'Non', NULL, 4),
(5, 'Oui', 6, NULL),
(5, 'Non', 9, NULL),
(6, 'Oui', 7, NULL),
(6, 'Non', 8, NULL),
(7, 'Oui', NULL, 5),
(7, 'Non', NULL, 6),
(8, 'Oui', NULL, 7),
(8, 'Non', NULL, 8),
(9, 'Oui', NULL, 9),
(9, 'Non', NULL, 10); 