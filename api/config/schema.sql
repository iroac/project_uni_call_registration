\c postgres

DROP DATABASE IF EXISTS db_chamados;
CREATE DATABASE db_chamados;

\c db_chamados

DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS chamados;

CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefone VARCHAR(150) NOT NULL,
    cpf VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS chamados (
    id_chamado SERIAL PRIMARY KEY,
    id_usuario INTEGER NOT NULL,
    titulo VARCHAR(60) NOT NULL,
    descricao TEXT,
    departamento VARCHAR(35) NOT NULL,
    responsavel VARCHAR(45) NOT NULL,
    regiao VARCHAR(20) NOT NULL,
    status VARCHAR(20) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);
