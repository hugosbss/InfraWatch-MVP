# InfraWatch - Roadmap de Desenvolvimento

Roadmap consolidado a partir de `README.md` e `InfraWatch-Laravel.MD`, mantendo Laravel, Jetstream, Fortify, Livewire, TailwindCSS, PostgreSQL e Redis como base.

## Etapa 0 - Base atual

Status: iniciado.

- Laravel com Jetstream, Fortify, Livewire e autenticação de usuários.
- Layout responsivo inicial do sistema.
- Dashboard visual inicial, ainda sem dados reais de monitoramento.
- Perfil de usuário com upload de foto redonda via Jetstream.
- Docker Compose com PostgreSQL e Redis para desenvolvimento local.
- Tabelas essenciais já previstas pelas migrations padrão: `users`, `sessions`, `password_reset_tokens`, `cache`, `jobs`, `personal_access_tokens` e suporte a 2FA/passkeys.

## Etapa 1 - Fundação do domínio

Objetivo: preparar a arquitetura limpa antes do CRUD principal.

- Definir módulos em `app/Livewire`, `app/Services`, `app/Jobs`, `app/Models`, `app/Policies` e `app/Notifications`.
- Criar entidades iniciais: `Monitor`, `MonitorCheck`, `MonitorIncident` e `AlertChannel`.
- Criar migrations apenas do domínio de monitoramento.
- Definir enums/status: `online`, `offline`, `degraded`, `paused`.
- Garantir que cada registro pertença a um usuário ou organização futura.

## Etapa 2 - Cadastro de monitoramentos

Objetivo: permitir que o usuário cadastre sites, APIs, IPs e servidores.

- CRUD Livewire para monitoramentos.
- Campos iniciais: nome, alvo, tipo, frequência, timeout e status.
- Validação de URL/IP.
- Listagem responsiva com filtros por status e tipo.
- Tela de detalhes do monitor.

## Etapa 3 - Worker de verificação

Objetivo: executar checks automáticos em background.

- Job `CheckMonitorJob`.
- Scheduler em `routes/console.php` para disparos recorrentes.
- Queue com Redis.
- Verificação HTTP/HTTPS com status code e tempo de resposta.
- Registro de logs de check e resultado.

## Etapa 4 - Incidentes

Objetivo: detectar quedas e controlar ciclo de incidentes.

- Abrir incidente quando um monitor falhar conforme regra definida.
- Fechar incidente quando o serviço voltar.
- Registrar início, fim, duração, erro e impacto.
- Exibir últimos incidentes no dashboard.

## Etapa 5 - Alertas

Objetivo: avisar o usuário rapidamente.

- Canal de email.
- Canal de Telegram.
- Configuração de canais por usuário.
- Templates simples para offline e recuperação.
- Controle para evitar spam de alertas repetidos.

## Etapa 6 - Dashboard dinâmico

Objetivo: transformar a tela atual em painel real.

- Cards de uptime, downtime, latência e incidentes.
- Tabela de status atual dos monitores.
- Histórico recente de checks.
- Polling com Livewire para atualização leve.
- Estados vazios bem desenhados para novos usuários.

## Etapa 7 - RBAC e operação SaaS

Objetivo: preparar crescimento multiusuário.

- Instalar Spatie Laravel Permission.
- Roles sugeridas: Super Admin, Administrador, Gestor, Coordenador, Analista e Cliente.
- Policies para monitores, incidentes e canais de alerta.
- Preparar evolução para multiempresa/teams.

## Etapa 8 - Observabilidade e produção

Objetivo: deixar o MVP pronto para operar.

- Horizon para filas.
- Telescope em ambiente de desenvolvimento.
- Logs estruturados para checks e alertas.
- Healthcheck da aplicação.
- Deploy com Docker, Nginx, Supervisor, PostgreSQL e Redis.

## Evoluções futuras

- Login Google com Socialite.
- Monitoramento SSL.
- Monitoramento DNS.
- Status page pública.
- Webhooks.
- Discord e WhatsApp.
- Monitoramento Mikrotik.
- Planos pagos e limites por assinatura.
