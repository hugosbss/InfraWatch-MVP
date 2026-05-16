````markdown
# InfraWatch — Arquitetura Oficial do Projeto (MVP SaaS)

> Plataforma SaaS de monitoramento de uptime, incidentes e serviços para pequenas empresas.

---

# Stack Principal

## Backend
- PHP 8.3+
- Laravel 12
- Laravel Jetstream
- Laravel Fortify
- Laravel Socialite
- Laravel Horizon
- Laravel Scheduler
- Laravel Queues
- Spatie Laravel Permission
- PostgreSQL
- Redis

---

## Frontend
- Blade
- Livewire
- Alpine.js
- TailwindCSS

---

## DevOps
- Docker
- Docker Compose
- Nginx
- Supervisor
- Redis
- PostgreSQL

---

## Observabilidade
- Laravel Telescope
- Horizon
- Grafana (futuro)
- Loki (futuro)

---

# Objetivo da Arquitetura

A arquitetura foi planejada para:

✅ MVP rápido  
✅ baixo custo  
✅ fácil deploy  
✅ escalabilidade futura  
✅ SaaS multiusuário  
✅ monitoramento em background  
✅ alertas automáticos  
✅ dashboard dinâmico  
✅ RBAC completo  
✅ filas e workers  
✅ autenticação robusta  

---

# Estrutura da Aplicação

```txt
infrawatch/

app/
 ├── Console/
 ├── Events/
 ├── Http/
 │    ├── Controllers/
 │    ├── Middleware/
 │    └── Requests/
 ├── Jobs/
 ├── Livewire/
 ├── Models/
 ├── Notifications/
 ├── Policies/
 ├── Providers/
 ├── Services/
 └── Traits/

bootstrap/

config/

database/
 ├── factories/
 ├── migrations/
 └── seeders/

resources/
 ├── views/
 ├── css/
 └── js/

routes/
 ├── web.php
 ├── auth.php
 └── console.php

storage/

docker/
 ├── nginx/
 ├── php/
 └── supervisor/

tests/
````

---

# Arquitetura do Sistema

```txt
Usuário
   ↓
Laravel Routes
   ↓
Middleware
   ↓
Controller/Livewire
   ↓
Service Layer
   ↓
Jobs/Queues
   ↓
PostgreSQL + Redis
```

---

# Funcionalidades do MVP

## Autenticação

* Login
* Registro
* Recuperação de senha
* Login Google
* Verificação de email
* Sessões seguras
* 2FA (futuro)

---

## Monitoramentos

* HTTP
* HTTPS
* Ping (futuro)
* SSL (futuro)
* DNS (futuro)

---

## Dashboard

* Uptime
* Downtime
* Incidentes
* Latência
* Status atual
* Histórico

---

## Alertas

* Email
* Telegram
* Discord (futuro)
* WhatsApp (futuro)

---

# Pacotes Laravel Recomendados

## Jetstream

Autenticação completa.

Instalação:

```bash
composer require laravel/jetstream
```

Instalar stack Livewire:

```bash
php artisan jetstream:install livewire
```

---

## Fortify

Backend de autenticação.

Instalação:

```bash
composer require laravel/fortify
```

Publicar:

```bash
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
```

---

## Socialite

Login com Google.

Instalação:

```bash
composer require laravel/socialite
```

---

## Spatie Permission

RBAC completo.

Instalação:

```bash
composer require spatie/laravel-permission
```

Publicar:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Migrar:

```bash
php artisan migrate
```

---

## Horizon

Gerenciamento de filas.

Instalação:

```bash
composer require laravel/horizon
```

Instalar:

```bash
php artisan horizon:install
```

---

## Telescope

Debug e observabilidade.

Instalação:

```bash
composer require laravel/telescope --dev
```

Instalar:

```bash
php artisan telescope:install
```

---

# Banco de Dados

## PostgreSQL

Tabelas principais:

```txt
users
roles
permissions
model_has_roles
model_has_permissions

monitors
monitor_logs
monitor_incidents
notifications
alert_channels
teams
```

---

# RBAC (Controle de Permissões)

## Roles sugeridas

```txt
Super Admin
Administrador
Gestor
Coordenador
Analista
Cliente
```

---

# Exemplo de criação de roles

```php
Role::create(['name' => 'gestor']);
Role::create(['name' => 'analista']);
```

---

# Exemplo de permissões

```php
Permission::create(['name' => 'view monitors']);
Permission::create(['name' => 'create monitors']);
Permission::create(['name' => 'delete monitors']);
```

---

# Middlewares Importantes

## Middleware de autenticação

```php
auth
```

---

## Middleware de verificação de email

```php
verified
```

---

## Middleware de roles

```php
role:gestor
```

---

## Middleware de permissões

```php
permission:create monitors
```

---

# Exemplo de rotas protegidas

```php
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', Dashboard::class);

});
```

---

# Rotas por Role

```php
Route::middleware(['role:gestor'])->group(function () {

    Route::get('/admin', AdminDashboard::class);

});
```

---

# Estrutura Livewire

```txt
app/Livewire/

 ├── Dashboard/
 ├── Monitors/
 ├── Incidents/
 ├── Settings/
 └── Users/
```

---

# Exemplo de componente

```bash
php artisan make:livewire Dashboard/Overview
```

---

# Estados Dinâmicos

## Alpine.js

Uso:

* dropdowns
* modais
* tabs
* menus
* pequenos estados reativos

---

## Livewire

Uso:

* tabelas
* polling
* filtros
* paginação
* formulários
* realtime leve

---

# Atualização automática do dashboard

Exemplo:

```html
<div wire:poll.30s>
```

---

# Scheduler do Laravel

## Arquivo

```txt
routes/console.php
```

---

# Exemplo

```php
Schedule::job(new CheckMonitorsJob)->everyMinute();
```

---

# Workers

Executar worker:

```bash
php artisan queue:work
```

---

# Fila recomendada

## Redis

Instalar Redis:

```bash
docker compose up -d redis
```

---

# Configuração Queue

```env
QUEUE_CONNECTION=redis
```

---

# Configuração Cache

```env
CACHE_DRIVER=redis
```

---

# Configuração Session

```env
SESSION_DRIVER=redis
```

---

# Docker Compose

## Estrutura

```txt
services:
  app:
  nginx:
  postgres:
  redis:
  queue:
  scheduler:
```

---

# Serviços do Docker

## App

Laravel + PHP-FPM

## Nginx

Servidor web

## PostgreSQL

Banco principal

## Redis

Filas/cache/sessões

## Queue

Worker queues

## Scheduler

Cron Laravel

---

# Comandos Importantes

## Criar projeto

```bash
composer create-project laravel/laravel infrawatch
```

---

## Instalar Jetstream

```bash
php artisan jetstream:install livewire
npm install && npm run build
```

---

## Rodar migrations

```bash
php artisan migrate
```

---

## Criar chave da aplicação

```bash
php artisan key:generate
```

---

## Criar componente Livewire

```bash
php artisan make:livewire Dashboard/Overview
```

---

## Criar Job

```bash
php artisan make:job CheckMonitorJob
```

---

## Criar Notification

```bash
php artisan make:notification MonitorOfflineNotification
```

---

## Criar Middleware

```bash
php artisan make:middleware CheckRole
```

---

## Criar Policy

```bash
php artisan make:policy MonitorPolicy
```

---

## Criar Seeder

```bash
php artisan make:seeder RolesSeeder
```

---

# Estrutura do Monitoramento

## Fluxo

```txt
Scheduler
   ↓
Job
   ↓
HTTP Request
   ↓
Salva monitor_log
   ↓
Detecta falha
   ↓
Cria incidente
   ↓
Envia alerta
```

---

# Verificação HTTP

Recomendado usar:

```php
Http::timeout(10)->get($url);
```

---

# Estratégia Anti Falso Positivo

Antes de criar incidente:

```txt
1ª falha → aguarda
2ª falha → aguarda
3ª falha → cria incidente
```

---

# Alertas

## Email

Laravel Notifications

## Telegram

Laravel Notification Channel

Instalar:

```bash
composer require laravel-notification-channels/telegram
```

---

# Filament (Futuro)

## Uso recomendado

* relatórios
* dashboards admin
* analytics
* gestão interna

---

# Instalação futura

```bash
composer require filament/filament
```

---

# Segurança

## Recomendações

* CSRF ativo
* Rate limiting
* Verificação de email
* Password hashing
* HTTPS obrigatório
* Cloudflare
* Backup automático

---

# Deploy Recomendado

## Melhor arquitetura gratuita

```txt
Cloudflare
   ↓
Nginx
   ↓
Laravel App
   ↓
Redis
   ↓
PostgreSQL
```

---

# Infraestrutura Gratuita Recomendada

# TOP 10 SERVIDORES GRATUITOS

## 1. Oracle Cloud Free Tier

[https://www.oracle.com/cloud/free/](https://www.oracle.com/cloud/free/)

Melhor opção gratuita.

Recursos:

* VPS ARM
* 24GB RAM
* 4 OCPU
* Docker
* Redis
* PostgreSQL

---

## 2. Railway

[https://railway.com/](https://railway.com/)

Excelente DX.

---

## 3. Render

[https://render.com/](https://render.com/)

Boa para Laravel.

---

## 4. Fly.io

[https://fly.io/](https://fly.io/)

Excelente para Docker.

---

## 5. Koyeb

[https://www.koyeb.com/](https://www.koyeb.com/)

Muito boa para containers.

---

## 6. Northflank

[https://northflank.com/](https://northflank.com/)

Ótima para Docker Compose.

---

## 7. Deta Space

[https://deta.space/](https://deta.space/)

Boa para MVP.

---

## 8. InfinityFree

[https://infinityfree.net/](https://infinityfree.net/)

Hospedagem PHP gratuita.

---

## 9. AwardSpace

[https://www.awardspace.com/](https://www.awardspace.com/)

Boa para Laravel simples.

---

## 10. AlwaysData

[https://www.alwaysdata.com/](https://www.alwaysdata.com/)

Possui suporte PHP gratuito.

---

# Plataformas adicionais úteis

## Vercel

[https://vercel.com/](https://vercel.com/)

Landing pages.

---

## Netlify

[https://netlify.com/](https://netlify.com/)

Frontend estático.

---

## Supabase

[https://supabase.com/](https://supabase.com/)

PostgreSQL gratuito.

---

## Upstash

[https://upstash.com/](https://upstash.com/)

Redis gratuito.

---

# Melhor Estratégia MVP

## InfraWatch MVP

```txt
Oracle Cloud
 ├── Laravel
 ├── PostgreSQL
 ├── Redis
 ├── Horizon
 ├── Scheduler
 └── Nginx
```

---

# Melhor Estratégia Futura

```txt
Oracle VPS
 ├── Coolify
 ├── Docker Compose
 ├── Laravel
 ├── Redis
 ├── PostgreSQL
 ├── Horizon
 ├── Grafana
 └── Loki
```

---

# Objetivo Final

O InfraWatch deverá evoluir para:

✅ SaaS multiempresa
✅ monitoramento distribuído
✅ status page pública
✅ monitoramento SSL
✅ monitoramento DNS
✅ monitoramento Mikrotik
✅ billing
✅ planos pagos
✅ aplicativo mobile
✅ integrações externas

---

```
```
