create database visual_tech;
USE visual_tech;

CREATE TABLE clients (
    id_client INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name_complete VARCHAR(80) NOT NULL,
	date_birth DATE,
	gender ENUM('M', 'F', 'OT') NOT NULL,
	maternal_name VARCHAR(30) NOT NULL,
    CPF VARCHAR(14) UNIQUE NOT NULL,
    user_email VARCHAR(50) UNIQUE NOT NULL,
    user_cell VARCHAR(15) UNIQUE NOT NULL,
    landline VARCHAR(14) DEFAULT "",
    cep VARCHAR(9) NOT NULL,
    street VARCHAR(40) NOT NULL,
    num VARCHAR(10) NOT NULL,
    complement VARCHAR(50) NOT NULL,
    status ENUM('ativo', 'ausente', 'inativo') DEFAULT 'ausente',
    password VARCHAR(9),
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

