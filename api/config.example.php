<?php
/**
 * Copie este arquivo para config.php e preencha com os dados reais.
 * config.php está no .gitignore e NUNCA deve ser versionado.
 */

return [
    /**
     * Chave da API do Claude (console.anthropic.com > API Keys).
     * Em produção prefira a variável de ambiente ANTHROPIC_API_KEY.
     */
    'anthropic_api_key' => getenv('ANTHROPIC_API_KEY') ?: '',

    /**
     * Senha opcional para gerar com IA. Vazio = qualquer visitante gera sem
     * senha. Preenchido = o app pede o código antes de gerar.
     */
    'slides_codigo' => getenv('SLIDES_CODIGO') ?: '',

    // Gerações permitidas por IP a cada hora (0 = sem limite).
    'slides_limite_hora' => 20,

    // Teto de gerações do site inteiro por dia (0 = sem limite).
    // Protege os créditos da API se o link se espalhar.
    'slides_limite_dia' => 200,

    // Origens autorizadas a chamar a API de outro domínio (CORS).
    // Se o app e a pasta api/ estão no mesmo site, pode deixar vazio.
    'allowed_origins' => [],

    // Onde guardar o controle de limite por IP. De preferência fora da pasta pública.
    'storage_dir' => __DIR__ . '/../storage',

    /**
     * Com true, o app mostra o motivo real de uma falha da API
     * (chave inválida, sem crédito etc.). Desligue depois de configurar.
     */
    'debug' => false,
];
