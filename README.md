# Configurações
Configurações e requisitos iniciais para rodar o projeto de chamados

## Requisitos 
- **PHP** (versão recente)
- **Postgress 18**
- Extensão **PDO** ativada no php.ini (rodar php --ini para validar localização)

## Iniciar projeto 

#### Servidor PHP
1. Abra um terminal no *diretorio atual*
2. Rode o comando "*php -S localhost:8000 -t public*"

#### Instância Postgress
1. Abra um terminal no diretorio atual 
2. Rode o comando "*psql -h 127.0.0.1 -p 5433 -U postgres -d postgres*"
3. Rode o comando "*\i api/config/schema.sql*" (irá iniciar/resetar o banco)

