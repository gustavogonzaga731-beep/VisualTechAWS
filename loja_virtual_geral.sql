CREATE DATABASE visual_tech;

USE visual_tech;

-- Primeiro temos que ter um vendedor
CREATE TABLE sellers (
    id_seller INT PRIMARY KEY AUTO_INCREMENT,
    img_seller VARCHAR(500),
    name_seller VARCHAR(80) NOT NULL,
    gender ENUM ('M', 'F', 'OT'),
    email_seller VARCHAR(100) UNIQUE,
    pass_seller VARCHAR(8),
    cargo_seller ENUM('vendedor', 'gerente', 'master') DEFAULT 'vendedor',
    status ENUM('ativo', 'ausente', 'inativo') DEFAULT 'ativo',
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Segundo temos que ter um produto
CREATE TABLE products (
    id_product INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    img_product VARCHAR(500) NOT NULL,
    name_product VARCHAR(80) NOT NULL,
    description_product VARCHAR(500) NOT NULL,
    quantity_stock INT NOT NULL,
    price_product DECIMAL(10,2) NOT NULL,
    id_seller INT NOT NULL,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_seller) REFERENCES sellers(id_seller)
);

-- Terceiro temos que ter um cliente
CREATE TABLE clients (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    name_complete VARCHAR(80) NOT NULL,
    gender ENUM('M', 'F', 'OT') DEFAULT 'OT',
    date_birth DATE,
    maternal_name VARCHAR(30) NOT NULL,
    CPF VARCHAR(14) UNIQUE NOT NULL,
    user_email VARCHAR(50) UNIQUE NOT NULL,
    user_cell VARCHAR(15) UNIQUE NOT NULL,
    landline VARCHAR(14) DEFAULT "",
    cep VARCHAR(9) NOT NULL,
    street VARCHAR(40) NOT NULL,
    num VARCHAR(10) NOT NULL,
    complement VARCHAR(50) NOT NULL,
    pass VARCHAR(255) NOT NULL, -- Aumentado para armazenar o hash da senha
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE item_pedido (
    id_item_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_product INT,
    id_client INT,
    price_total DECIMAL(10,2),
    quantity INT
);

CREATE TABLE log (
    id_log INT PRIMARY KEY AUTO_INCREMENT, -- ID único para cada registro de log
    user_type ENUM('vendedor', 'client', 'master') NOT NULL, -- Tipo de usuário que realizou a ação (vendedor ou cliente)
    user_id INT NOT NULL, -- ID do usuário (vendedor ou cliente)
    action VARCHAR(255) NOT NULL, -- Ação realizada (ex.: "Login", "Adicionou produto", "Atualizou estoque", etc.)
    description TEXT, -- Detalhes adicionais sobre a ação
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data e hora do evento
);


-- Inserindo dados
INSERT INTO sellers (img_seller, name_seller, gender, email_seller, pass_seller, cargo_seller)
VALUES('/visual_tech/uploads/sellers/1728693229_caio.foto.png', 'Caio Querino', 'M', 'caio.querino@visual_tech.com.br', '12345678', 'master');

INSERT INTO sellers (img_seller, name_seller, gender, email_seller, pass_seller, cargo_seller)
VALUES('/visual_tech/uploads/sellers/1728693724_gustavo.foto.png', 'Gustavo Gonzaga', 'M', 'gustavo.gonzaga@visual_tech.com.br', '12345678', 'vendedor');

INSERT INTO sellers (img_seller, name_seller, gender, email_seller, pass_seller, cargo_seller)
VALUES('/visual_tech/uploads/sellers/1728694600_laryssa.foto.png', 'Laryssa Monyke', 'F', 'laryssa.monyke@visual_tech.com.br', '12345678', 'vendedor');

INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1728696816_computador.png', 'PC Gamer Completo AMD Ryzen 5 5600G', 'Pc Gamer Completo 3green Force, AMD Ryzen 5-5600g, 16GB DDR4, Gráficos Radeon Vega 7, SSD 256GB, Fonte 500W + Monitor 24 FHD 75Hz - 3f-017', 10, 2339.10, 1);

INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1728699732_fone.png', 'Fone de ouvido sem fio JBL Tune 520BT Dobrável Preto', 'SOM SURROUND 3D: O driver dinâmico magnético forte de NdFe de 40 mm oferece um grande palco de som, apenas mergulhe em sua música favorita o tempo todo.', 5, 220.00, 3);

INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1728700061_kindle.png', 'Kindle 11ª Geração', 'Conheça o Kindle, que agora conta com uma aprimorada tela de alta resolução.', 15, 449.10, 3);

INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1728700326_ps5.png', 'PlayStation 5', 'Console PlayStation 5 Slim, SSD 1TB, Edição Digital.', 20, 3533.07, 2);

INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1728876720_notebook-laptop.avif', 'Notebook Gamer G15', 'O PC gamer pode ser equipado com processadores de última geração e placas gráficas poderosas, que garantem um desempenho melhor em comparação aos notebooks.', 50, 6299.00, 1);

INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1729294073_alexia.png', 'Echo Dot 5ª geração ', 'Curta uma experiência sonora ainda melhor em comparação às versões anteriores do Echo Dot com Alexa e ouça vocais mais nítidos, graves mais potentes e um som vibrante em qualquer ambiente.', 100, 429.00, 1);


INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller)
VALUES('/visual_tech/uploads/products/1733500996_camera.png', 'Câmera', 'Câmera Canon Eos Rebel T7+ Com Lente Ef-s 18-55mm + Nf-e', 100, 4.488, 1);