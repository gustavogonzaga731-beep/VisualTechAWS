USE visual_tech;

CREATE TABLE products (
    id_product INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    img_product VARCHAR(500) NOT NULL,
    name_product VARCHAR(100) NOT NULL,
    description_product VARCHAR(500),
    price_product DECIMAL(10,2),
	id_seller INT,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(id_seller) REFERENCES sellers(id_seller)
);

DROP TABLE `visual_tech` . `products`;