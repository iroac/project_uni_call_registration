-- Always switch to postgres before dropping/creating databases.
\c postgres

DROP DATABASE IF EXISTS db_chamados;
CREATE DATABASE db_chamados;

-- Connect to the new database in psql with: \c db_chamados
\c db_chamados

-- Reset table to avoid schema drift during local dev.
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(150) NOT NULL,
    cpf VARCHAR(150) NOT NULL,
    password VARCHAR(150) NOT NULL
);

INSERT INTO users (name, email, telefone, cpf, password) VALUES ('Vinicius', 'vinicius@gmail.com', '123456789', '12345678900', 'senha123'), ('Arthur', 'arthur@gmail.com', '987654321', '98765432100', 'senha456') ;
