API Laravel 10 + Doctrine + PostgreSQL
📋 Descrição

API desenvolvida em Laravel 10 utilizando Doctrine ORM, PostgreSQL como banco de dados e Docker para facilitar o ambiente de desenvolvimento. A documentação dos endpoints está disponível via Swagger.

🔧 Requisitos

Docker

Docker Compose

Git

🚀 Instalação e Uso
Clone o repositório
git clone [URL_DO_REPOSITORIO]
cd [NOME_DO_PROJETO]

Configure as variáveis de ambiente
cp .env.example .env


Edite o arquivo .env se necessário, mas as credenciais padrão já funcionam para o ambiente local.

Suba os containers
docker-compose up -d

Instale as dependências do Laravel
docker exec -it laravel_app composer install

Gere a chave da aplicação
docker exec -it laravel_app php artisan key:generate

Atualize o schema do banco de dados via Doctrine
docker exec -it laravel_app php artisan doctrine:schema:update --force

Rode o seeder para popular a base
docker exec -it laravel_app php artisan db:seed --class=ProductSeeder

🗄️ Banco de Dados

O banco de dados PostgreSQL é inicializado automaticamente via Docker.

As credenciais e configurações estão no arquivo .env.example.

📑 Documentação da API

A documentação interativa dos endpoints está disponível em:

http://localhost:8000/api/documentation


A API foi documentada utilizando Swagger, o que permite explorar os endpoints e seus parâmetros de forma interativa.

🧪 Testes

Para rodar os testes unitários:

docker exec -it laravel_app php artisan test


Ou, para rodar apenas o teste de produtos:

docker exec -it laravel_app php artisan test --filter=ProductTest

📝 Observações

Certifique-se de que as portas 8000 (API) e 5432 (PostgreSQL) estejam livres em sua máquina.

Para customizar as configurações do banco, edite o arquivo .env.