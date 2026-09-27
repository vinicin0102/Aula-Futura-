<?php
declare(strict_types=1);

/**
 * Utilitários compartilhados pelos endpoints da API.
 * Este arquivo não responde nada sozinho.
 */

function carregarConfig(): array
{
    $caminho = __DIR__ . '/config.php';
    if (!is_file($caminho)) {
        responder(500, ['erro' => 'Servidor não configurado. Copie api/config.example.php para api/config.php.']);
    }
    return require $caminho;
}

function responder(int $status, array $dados): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

function aplicarCors(array $config): void
{
    $origem = $_SERVER['HTTP_ORIGIN'] ?? '';
    if ($origem !== '' && in_array($origem, (array) ($config['allowed_origins'] ?? []), true)) {
        header('Access-Control-Allow-Origin: ' . $origem);
        header('Vary: Origin');
    }
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Allow-Methods: POST, OPTIONS');

    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}

function corpoJson(): array
{
    $bruto = file_get_contents('php://input');
    $dados = json_decode((string) $bruto, true);
    return is_array($dados) ? $dados : [];
}

/** Registra no log de erros do servidor, sem devolver detalhes ao cliente. */
function registrarErro(string $contexto, string $detalhe): void
{
    error_log(sprintf('[aula-futura][%s] %s', $contexto, $detalhe));
}

/** Diretório de estado (controle de limite por IP). */
function diretorioEstado(array $config): string
{
    $dir = (string) ($config['storage_dir'] ?? __DIR__ . '/../storage');
    if (!is_dir($dir)) {
        @mkdir($dir, 0770, true);
    }
    return $dir;
}
