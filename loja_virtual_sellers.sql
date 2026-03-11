
USE visual_tech;

CREATE TABLE sellers (
    id_seller INT PRIMARY KEY AUTO_INCREMENT,
    img_seller VARCHAR(500),
    name_seller VARCHAR(100) NOT NULL,
    gender ENUM ('M', 'F', 'OT'),
    email_seller VARCHAR(100)  UNIQUE,
    pass_seller VARCHAR(9),
    cargo_seller ENUM('vendedor', 'gerente', 'master') DEFAULT 'vendedor',
    status ENUM('ativo', 'ausente', 'inativo') DEFAULT 'ativo',
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);