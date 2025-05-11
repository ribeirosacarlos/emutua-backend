# API Laravel 10 + Doctrine + PostgreSQL

## 📋 Descrição

API desenvolvida em Laravel 10 utilizando Doctrine ORM, PostgreSQL como banco de dados e Docker para facilitar o ambiente de desenvolvimento. A documentação dos endpoints está disponível via Swagger.

---

## 🔧 Requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

---

## 🚀 Instalação e Uso

1. **Clone o repositório**

   ```bash
   git clone https://github.com/ribeirosacarlos/emutua-backend.git
   cd emutua-backend
   ```

2. **Configure as variáveis de ambiente**

   ```bash
   cp .env.example .env
   ```

   > Edite o arquivo `.env` se necessário, mas as credenciais padrão já funcionam para o ambiente local.

3. **Suba os containers**

   ```bash
   docker-compose up -d
   ```

4. **Instale as dependências do Laravel**

   ```bash
   docker exec -it laravel_app composer install
   ```

5. **Gere a chave da aplicação**

   ```bash
   docker exec -it laravel_app php artisan key:generate
   ```

6. **Atualize o schema do banco de dados via Doctrine**

   ```bash
   docker exec -it laravel_app php artisan doctrine:schema:update --force
   ```

7. **Rode o seeder para popular a base**

   ```bash
   docker exec -it laravel_app php artisan db:seed --class=ProductSeeder
   ```

---

## 🗄️ Banco de Dados

- O banco de dados PostgreSQL é inicializado automaticamente via Docker.
- As credenciais e configurações estão no arquivo `.env.example`.

---

## 📑 Documentação da API

A documentação interativa dos endpoints está disponível em:

```
http://localhost:8000/api/documentation
```

> A API foi documentada utilizando Swagger, o que permite explorar os endpoints e seus parâmetros de forma interativa.

---

## 🧪 Testes

Para rodar os testes unitários:

```bash
docker exec -it laravel_app php artisan test
```

Ou, para rodar apenas o teste de produtos:

```bash
docker exec -it laravel_app php artisan test --filter=ProductTest
```

---

## 📝 Observações

- Certifique-se de que as portas 8000 (API) e 5432 (PostgreSQL) estejam livres em sua máquina.
- Para customizar as configurações do banco, edite o arquivo `.env`.
