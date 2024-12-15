USE pengyus_pizza;

create table user1 ( 
    username varchar(20), 
    password varchar(40)
);

CREATE TABLE Items (
    itemID INT UNSIGNED NOT NULL PRIMARY KEY,
    itemName CHAR(255) NOT NULL,
    price FLOAT(4,2)
);

CREATE TABLE Orders (
    orderID INT UNSIGNED NOT NULL,
    itemID INT UNSIGNED NOT NULL,
    quantity TINYINT UNSIGNED,
    thickness VARCHAR(100),
    sauce VARCHAR(100),
    toppings VARCHAR(255)
);

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    feedback TEXT NOT NULL,
    rating INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);