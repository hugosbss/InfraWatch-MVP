# Jobs, Queues e Scheduler no InfraWatch

Este documento resume como rodar o motor de monitoramento do InfraWatch em desenvolvimento e producao.

## Visao geral

O fluxo de monitoramento usa tres partes do Laravel:

1. **Scheduler**
   - Roda a cada minuto.
   - Busca monitores ativos.
   - Verifica a frequencia do monitor (`1m` ou `5m`).
   - Dispara um Job para a fila.

2. **Job**
   - Executa a verificacao de um monitor especifico.
   - Mede a latencia.
   - Salva o resultado em `monitor_logs`.
   - Abre ou fecha incidentes quando necessario.

3. **Queue Worker**
   - Fica escutando a fila.
   - Processa os Jobs disparados pelo Scheduler.

## Arquivos principais

```text
routes/console.php
app/Jobs/CheckMonitorJob.php
app/Actions/Monitoring/DispatchDueMonitorChecks.php
app/Actions/Monitoring/CheckMonitor.php
app/Models/Monitor.php
app/Models/MonitorLog.php
app/Models/Incident.php
```

## Configuracao do .env

Para usar fila com banco de dados:

```env
QUEUE_CONNECTION=database
```

Para usar Redis:

```env
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Depois de alterar o `.env`, rode:

```bash
php artisan config:clear
```

## Preparar banco de dados

Suba os servicos locais:

```bash
docker compose up -d
```

Rode as migrations:

```bash
php artisan migrate
```

Se estiver usando `QUEUE_CONNECTION=database`, garanta que a tabela de jobs existe:

```bash
php artisan queue:table
php artisan migrate
```

## Rodar em desenvolvimento

Use tres terminais.

Terminal 1: servidor Laravel

```bash
php artisan serve
```

Terminal 2: worker da fila

```bash
php artisan queue:work
```

Terminal 3: scheduler local

```bash
php artisan schedule:work
```

Com isso, o Laravel:

```text
schedule:work
→ executa routes/console.php a cada minuto
→ DispatchDueMonitorChecks dispara CheckMonitorJob
→ queue:work processa CheckMonitorJob
→ CheckMonitor salva logs e incidentes
```

## Testar um Job manualmente

Use o Tinker:

```bash
php artisan tinker
```

Dentro do Tinker:

```php
App\Jobs\CheckMonitorJob::dispatchSync(1);
```

Ou para disparar para a fila:

```php
App\Jobs\CheckMonitorJob::dispatch(1);
```

Depois confira no banco:

```sql
select * from monitor_logs order by checked_at desc;
select * from incidents order by started_at desc;
```

## Comandos uteis de fila

Processar fila continuamente:

```bash
php artisan queue:work
```

Processar apenas um Job e encerrar:

```bash
php artisan queue:work --once
```

Ver Jobs que falharam:

```bash
php artisan queue:failed
```

Tentar novamente todos os Jobs falhados:

```bash
php artisan queue:retry all
```

Limpar Jobs falhados:

```bash
php artisan queue:flush
```

Reiniciar workers apos deploy ou alteracao de codigo:

```bash
php artisan queue:restart
```

## Comandos uteis do Scheduler

Listar tarefas agendadas:

```bash
php artisan schedule:list
```

Rodar o scheduler localmente em modo continuo:

```bash
php artisan schedule:work
```

Executar uma rodada do scheduler:

```bash
php artisan schedule:run
```

## Producao

Em producao, nao use `schedule:work` como processo principal. Use o cron do servidor para chamar o scheduler a cada minuto:

```cron
* * * * * cd /caminho/do/projeto && php artisan schedule:run >> /dev/null 2>&1
```

Tambem mantenha um worker de fila rodando continuamente via Supervisor, Systemd, Docker ou Coolify:

```bash
php artisan queue:work --sleep=3 --tries=3 --timeout=90
```

Depois de um deploy, rode:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
```

## Debug rapido

Se os checks nao aparecem em `monitor_logs`, verifique:

1. O Postgres esta rodando?
   ```bash
   docker compose up -d
   ```

2. Existem monitores ativos?
   ```sql
   select id, name, target, type, frequency, status from monitors;
   ```

3. O scheduler esta rodando?
   ```bash
   php artisan schedule:work
   ```

4. O worker esta rodando?
   ```bash
   php artisan queue:work
   ```

5. Existem Jobs falhados?
   ```bash
   php artisan queue:failed
   ```

## Observacao sobre Ping

O worker atual processa monitores do tipo `http`. Monitores `ping` devem ganhar uma action propria depois, para manter o codigo organizado sem misturar verificacao HTTP com ICMP.
