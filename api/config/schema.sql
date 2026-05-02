-- Create the database (run in the default postgres database)
DROP DATABASE IF EXISTS db_chamados;
CREATE DATABASE db_chamados;

-- Connect to the new database in psql with: \c db_chamados
\c db_chamados

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150)
);

INSERT INTO users (name, email) VALUES ('Vinicius', 'vinicius@gmail.com'), ('Arthur', 'arthur@gmail.com') ;
