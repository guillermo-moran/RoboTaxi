USE users;

CREATE TABLE user(
    user_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) UNIQUE NOT NULL,
    -- THIS ONE ASKS FOR USERNAME AND IT IS UNIQUE
    user_firstName VARCHAR(100) NOT NULL,
    user_lastNmae VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password INTEGER NOT NULL,
    credit_card_number INTEGER NOT NULL,
    credit_card_username VARCHAR(100) NOT NULL,
    credit_expiration INTEGER NOT NULL,
    credit_ccv INTEGER NOT NULL
);

