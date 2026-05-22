<?php

namespace App\Support;

class MonitoringDemoData
{
    /**
     * Dados de demonstração até o domínio Monitor existir no banco.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function monitors(): array
    {
        return [
            [
                'id' => 'site-institucional',
                'name' => 'Site institucional',
                'target' => 'https://empresa.com.br',
                'type' => 'https',
                'status' => 'online',
                'response_ms' => 142,
                'last_check' => 'há 1 min',
                'uptime' => '99.98%',
                'frequency' => '5 min',
                'timeout' => 10,
            ],
            [
                'id' => 'api-principal',
                'name' => 'API principal',
                'target' => 'https://api.empresa.com/health',
                'type' => 'https',
                'status' => 'degraded',
                'response_ms' => 890,
                'last_check' => 'há 2 min',
                'uptime' => '98.40%',
                'frequency' => '1 min',
                'timeout' => 15,
            ],
            [
                'id' => 'dns-publico',
                'name' => 'DNS público',
                'target' => '8.8.8.8',
                'type' => 'ping',
                'status' => 'online',
                'response_ms' => 18,
                'last_check' => 'há 1 min',
                'uptime' => '100%',
                'frequency' => '5 min',
                'timeout' => 5,
            ],
            [
                'id' => 'loja-virtual',
                'name' => 'Loja virtual',
                'target' => 'https://loja.empresa.com',
                'type' => 'https',
                'status' => 'offline',
                'response_ms' => null,
                'last_check' => 'há 4 min',
                'uptime' => '96.12%',
                'frequency' => '1 min',
                'timeout' => 10,
            ],
            [
                'id' => 'webhook-pagamentos',
                'name' => 'Webhook pagamentos',
                'target' => 'https://hooks.empresa.com/payments',
                'type' => 'http',
                'status' => 'paused',
                'response_ms' => null,
                'last_check' => 'pausado',
                'uptime' => '—',
                'frequency' => '5 min',
                'timeout' => 20,
            ],
        ];
    }

    public static function findMonitor(string $id): ?array
    {
        foreach (self::monitors() as $monitor) {
            if ($monitor['id'] === $id) {
                return $monitor;
            }
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function incidents(): array
    {
        return [
            [
                'id' => 'inc-1042',
                'monitor' => 'Loja virtual',
                'target' => 'https://loja.empresa.com',
                'status' => 'open',
                'started_at' => '22/05/2026 14:32',
                'duration' => '12 min',
                'error' => 'Connection timeout após 10s',
            ],
            [
                'id' => 'inc-1041',
                'monitor' => 'API principal',
                'target' => 'https://api.empresa.com/health',
                'status' => 'resolved',
                'started_at' => '21/05/2026 09:15',
                'duration' => '8 min',
                'error' => 'HTTP 503 Service Unavailable',
            ],
            [
                'id' => 'inc-1040',
                'monitor' => 'Site institucional',
                'target' => 'https://empresa.com.br',
                'status' => 'resolved',
                'started_at' => '20/05/2026 03:44',
                'duration' => '3 min',
                'error' => 'HTTP 502 Bad Gateway',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function recentChecks(): array
    {
        return [
            ['monitor' => 'Site institucional', 'status' => 'online', 'code' => 200, 'ms' => 142, 'at' => '14:35'],
            ['monitor' => 'API principal', 'status' => 'degraded', 'code' => 200, 'ms' => 890, 'at' => '14:34'],
            ['monitor' => 'Loja virtual', 'status' => 'offline', 'code' => null, 'ms' => null, 'at' => '14:33'],
            ['monitor' => 'DNS público', 'status' => 'online', 'code' => null, 'ms' => 18, 'at' => '14:35'],
        ];
    }
}
