# Aula Futura

Gerador de slides futuristas e animados para professores. O professor informa
a disciplina, o tema exato da aula, o nível da turma e, se quiser, cola o
próprio material. A IA (Claude) monta a aula em slides com notas para o
professor, que depois podem ser editados e apresentados em tela cheia.

```
index.html               o app (início, estúdio de edição e modo apresentação)
api/slides.php           gera o roteiro de slides com a API do Claude
api/_bootstrap.php       utilitários (config, CORS, respostas JSON)
api/config.example.php   modelo de configuração
storage/                 controle de limite por IP (não versionado)
```

## Recursos

- **Layouts:** capa, tópicos, destaque (número/conceito), comparação, etapas,
  definição/citação, pergunta de quiz (a resposta aparece ao avançar) e resumo.
- **Movimento:** transições entre slides (dobra espacial, deslizar, cubo 3D,
  glitch), partículas que disparam na troca e fogem do mouse, parallax das
  camadas, cartões flutuando, números que contam até o valor, pulso de energia
  nas etapas e títulos com brilho/glitch. Opcional: revelar os itens um a um,
  a cada clique. Respeita a opção "reduzir movimento" do sistema.
- **Visuais:** Neon, Plasma, Solar, Matrix e Gelo.
- **Apresentação:** setas/espaço/clique/swipe para navegar, `N` mostra as notas,
  `F` tela cheia, `Esc` sai.
- **Exportar:** "Baixar apresentação (.html)" gera um arquivo único que abre
  direto no modo apresentação, sem servidor. O `.json` pode ser reaberto no app.
- **Modo manual:** a aba "Escrever meu roteiro" monta os slides a partir de um
  texto simples, sem IA e sem custo.
- **Aula de exemplo:** o botão "Ver aula de exemplo" abre uma aula pronta.
- As aulas ficam salvas no navegador do professor (localStorage).

## Instalação

Requisitos: hospedagem com PHP 8.1+ e a extensão cURL.

1. Envie todos os arquivos para a pasta do site.
2. Crie a configuração:

   ```bash
   cp api/config.example.php api/config.php
   ```

3. Preencha no `api/config.php`:

   | Chave | O que é |
   |---|---|
   | `anthropic_api_key` | chave da API do Claude (console.anthropic.com), ou a variável `ANTHROPIC_API_KEY` |
   | `slides_codigo` | código que o professor digita no app. **Vazio = geração com IA desligada** |
   | `slides_limite_hora` | gerações por IP por hora (padrão 20) |

4. Abra o site, preencha o formulário e use o código de acesso para gerar.

Sem a chave configurada, o app continua funcionando no modo manual e com a
aula de exemplo.

Para testar localmente:

```bash
php -S localhost:8000
# abra http://localhost:8000
```

## Decisões de segurança

- **A chave da API nunca vai para o navegador.** A chamada ao Claude é feita
  em PHP, no servidor.
- **Cada geração custa créditos**, então o endpoint recusa pedidos sem o
  código de acesso e limita o volume por IP.
- **O formato é garantido.** A chamada usa `claude-opus-5` com saída
  estruturada (JSON Schema); o PHP ainda normaliza o resultado, e o front só
  insere texto com `textContent`, nunca como HTML.
- **O material do professor é tratado como conteúdo**, não como instrução:
  vai delimitado no pedido e o modelo é orientado a não seguir ordens que
  apareçam dentro dele.

## Se a geração falhar

Ligue `'debug' => true` no `config.php` para o app mostrar o motivo real
(chave inválida, sem crédito, limite atingido). Desligue depois.
