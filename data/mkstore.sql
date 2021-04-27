
CREATE DATABASE IF NOT EXISTS mkstore;

USE mkstore;

CREATE TABLE users (
    id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    createdate DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products
(
    id         INT AUTO_INCREMENT
        PRIMARY KEY,
    name       VARCHAR(200)                            NOT NULL,
    `desc`     TEXT                                    NOT NULL,
    price      DECIMAL(7, 2)                           NOT NULL,
    rrp        DECIMAL(7, 2) DEFAULT 0.00              NOT NULL,
    quantity   INT                                     NOT NULL,
    img        TEXT                                    NOT NULL,
    date_added DATETIME      DEFAULT CURRENT_TIMESTAMP NOT NULL
)
    CHARSET = utf8;

INSERT INTO products (`id`, `name`, `desc`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
(1, 'Cyberpunk', '<p>Cyberpunk</p>', '59.99', '0.00', 100, 'Cyberbonk.jpg', '2021-04-25 14:11:00'),
(2, 'Doom Eternal', '<p>Doom Eternal</p>', '14.99', '59.99', 100, 'doooooomeeeeteeernaaaal.jpg', '2021-04-25 14:11:00'),
(3, 'Halo Infinite', '<p>Halo Infinite</p>', '69.99', '0.00', 100, 'images/HaloInfinite.jpg', '2021-04-25 14:11:00');

