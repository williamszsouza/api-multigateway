#  Multi-Gateway Payment API - BeTalent (Nível 2)

Esta é uma API RESTful desenvolvida em Laravel 11 para o gerenciamento de pagamentos multigateway. O sistema foi projetado para ser modular, permitindo a integração de diferentes provedores de pagamento com uma lógica inteligente de **priorização dinâmica** via banco de dados.



---

## 🚀 Tecnologias e Requisitos

* **Linguagem:** PHP 8.3
* **Framework:** [Laravel 11](https://laravel.com/)
* **Banco de Dados:** MySQL 8.0
* **Ambiente de Desenvolvimento:** [Laravel Sail](https://laravel.com/docs/11.x/sail) (Docker)
* **Autenticação:** [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum) (Bearer Token)

---

## 🛠️ Instalação e Configuração

Irei disponibilizar a collection que utilizei para testes no arquivo "collection" na raiz do projeto

A url para se consumir a api é "http://localhost" + rota do endpoint

Certifique-se de ter o **Docker** instalado em sua máquina.

### 1. Clonar o Repositório
```bash
git clone [https://github.com/seu-usuario/seu-repositorio.git](https://github.com/seu-usuario/seu-repositorio.git)
cd seu-repositorio

## 🛠️ Instalação e Configuração (Docker Compose)

### 1. Subir os Containers
```bash
docker-compose up -d

# Instalar dependências
docker exec -it api-multigateway-laravel.test-1 composer install

# Gerar chave e rodar banco
docker exec -it api-multigateway-laravel.test-1 php artisan key:generate
docker exec -it api-multigateway-laravel.test-1 php artisan migrate:fresh --seed --seeder=GatewaySeeder

cp .env.example .env

docker-compose up -d

#É crucial rodar o container que possui os mocks para que a api consuma
docker run -p 3001:3001 -p 3002:3002 matheusprotzen/gateways-mock

Regras de Negócio Implementadas (Nível 2)
Cálculo no Back-end: O valor total da compra é calculado no servidor (valor_do_produto * quantidade)

Orquestrador de Pagamentos: Consulta os gateways ativos e processa seguindo a ordem de priority.

Fallback Automático: Caso o primeiro gateway falhe tecnicamente, o sistema tenta o próximo de forma transparente para o usuário.

Gestão de Clientes: Implementação de lógica firstOrCreate para identificar clientes por e-mail e vincular o histórico de compras.

