<?php
session_start();

function h(?string $v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

// ══════════════════════════════════════════════════════════════════════
// DADOS DO BANCO — COMENTADOS PARA VISUALIZAÇÃO COM DADOS FICTÍCIOS
// Descomente este bloco e remova os dados fictícios abaixo quando
// integrar ao banco de dados em produção.
// ══════════════════════════════════════════════════════════════════════
/*
$config = require __DIR__ . '/app/config/db.php';
$pdo = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']};charset={$config['charset']}",
    $config['user'], $config['pass'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$filtroAno      = (int)($_GET['ano'] ?? 0);
$filtroCategoria = trim($_GET['categoria'] ?? '');

$edicoes = $pdo->query("
    SELECT DISTINCT p.id, p.nome, p.ano, p.slug
    FROM premiacoes p
    INNER JOIN premiacao_inscricoes pi ON pi.premiacao_id = p.id AND pi.status = 'vencedora'
    ORDER BY p.ano DESC
")->fetchAll(PDO::FETCH_ASSOC);

$whereAno = $filtroAno > 0 ? 'AND p.ano = ' . $filtroAno : '';
$whereCat = $filtroCategoria !== '' ? "AND n.categoria = " . $pdo->quote($filtroCategoria) : '';

$stmt = $pdo->prepare("
    SELECT
        p.id   AS premiacao_id,
        p.nome AS premiacao_nome,
        p.ano  AS premiacao_ano,
        n.id   AS negocio_id,
        n.nome_fantasia,
        n.categoria,
        n.municipio,
        n.estado,
        a.logo_negocio,
        a.imagem_destaque,
        a.frase_negocio,
        o.icone_url  AS ods_icone,
        o.nome       AS ods_nome,
        et.nome      AS eixo_nome,
        CONCAT(e.nome, ' ', e.sobrenome) AS empreendedor_nome
    FROM premiacao_inscricoes pi
    INNER JOIN premiacoes p        ON p.id  = pi.premiacao_id
    INNER JOIN negocios n          ON n.id  = pi.negocio_id
    LEFT  JOIN negocio_apresentacao a  ON a.negocio_id  = n.id
    LEFT  JOIN ods o               ON o.id  = n.ods_prioritaria_id
    LEFT  JOIN eixos_tematicos et  ON et.id = n.eixo_principal_id
    LEFT  JOIN empreendedores e    ON e.id  = pi.empreendedor_id
    WHERE pi.status = 'vencedora'
    $whereAno
    $whereCat
    ORDER BY p.ano DESC, n.categoria ASC, n.nome_fantasia ASC
");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$porEdicao = [];
foreach ($rows as $r) {
    $anoKey = (int)$r['premiacao_ano'];
    if (!isset($porEdicao[$anoKey])) {
        $porEdicao[$anoKey] = [
            'id'   => $r['premiacao_id'],
            'nome' => $r['premiacao_nome'],
            'ano'  => $anoKey,
            'categorias' => [],
        ];
    }
    $cat = $r['categoria'] ?: 'Sem categoria';
    if (!isset($porEdicao[$anoKey]['categorias'][$cat])) {
        $porEdicao[$anoKey]['categorias'][$cat] = [];
    }
    $porEdicao[$anoKey]['categorias'][$cat][] = $r;
}
*/
// ══════════════════════════════════════════════════════════════════════
// FIM DO BLOCO DO BANCO
// ══════════════════════════════════════════════════════════════════════


// ══════════════════════════════════════════════════════════════════════
// DADOS FICTÍCIOS — SUBSTITUIR PELOS DADOS DO BANCO EM PRODUÇÃO
// Remover este bloco inteiro quando descomentar o bloco acima.
// ══════════════════════════════════════════════════════════════════════
$filtroAno       = (int)($_GET['ano'] ?? 0);
$filtroCategoria = trim($_GET['categoria'] ?? '');

// TO DO: substituir por query: SELECT DISTINCT p.ano FROM premiacoes p INNER JOIN premiacao_inscricoes pi ...
$edicoes = [
    ['id' => 1, 'nome' => 'Prêmio Impactos Positivos 2026 - 1º semestre', 'ano' => 2026, 'slug' => 'edicao-2026-1'],
    ['id' => 2, 'nome' => 'Prêmio Impactos Positivos 2025 - 1º semestre', 'ano' => 2025, 'slug' => 'edicao-2025-1'],
];

// Vencedores fictícios
// TO DO: substituir pelo resultado da query acima ($rows / $stmt->fetchAll())
$rowsFicticios = [
    // Edição 2026 ─────────────────────────────────────────────────────
    [
        'premiacao_id'     => 1,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2026 - 1º semestre',
        'premiacao_ano'    => 2026,
        'negocio_id'       => 101,
        'nome_fantasia'    => 'HackCafé',
        'categoria'        => 'Dinamizador',
        'municipio'        => 'Aripuanã',
        'estado'           => 'MT',
        'logo_negocio'     => null,
        'imagem_destaque'  => 'https://images.unsplash.com/photo-1514539079130-25950c84af65?w=600&q=80',
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliq',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Sustainable_Development_Goal_08.png/240px-Sustainable_Development_Goal_08.png',
        'ods_nome'         => 'ODS 8',
        'eixo_nome'        => 'Finanças',
        'empreendedor_nome'=> 'Daniela Silva',
    ],
    [
        'premiacao_id'     => 1,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2026 - 1º semestre',
        'premiacao_ano'    => 2026,
        'negocio_id'       => 102,
        'nome_fantasia'    => 'Casa Ponte',
        'categoria'        => 'Ideação',
        'municipio'        => 'Osasco',
        'estado'           => 'SP',
        'logo_negocio'     => 'https://placehold.co/200x80/eef4df/4f5f00?text=EduAcelera+Para',
        'imagem_destaque'  => null,
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porta vehicula nulla, id tempor velit rutrum eget.',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Sustainable_Development_Goal_16.png/240px-Sustainable_Development_Goal_16.png',
        'ods_nome'         => 'ODS 16',
        'eixo_nome'        => 'Cidadania, Direitos Humanos e Sociedade',
        'empreendedor_nome'=> 'Daniela Silva',
    ],
    [
        'premiacao_id'     => 1,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2026 - 1º semestre',
        'premiacao_ano'    => 2026,
        'negocio_id'       => 103,
        'nome_fantasia'    => 'Cereus',
        'categoria'        => 'Operação',
        'municipio'        => 'Osasco',
        'estado'           => 'SP',
        'logo_negocio'     => 'https://placehold.co/200x80/eef4df/4f5f00?text=CicloVerde+Bus',
        'imagem_destaque'  => null,
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur faucibus elit nec sapien varius fermentum. Aeneon sus',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Sustainable_Development_Goal_16.png/240px-Sustainable_Development_Goal_16.png',
        'ods_nome'         => 'ODS 16',
        'eixo_nome'        => 'Cidadania, Direitos Humanos e Sociedade',
        'empreendedor_nome'=> 'Daniela Silva',
    ],
    [
        'premiacao_id'     => 1,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2026 - 1º semestre',
        'premiacao_ano'    => 2026,
        'negocio_id'       => 104,
        'nome_fantasia'    => 'Capacitação Empreendedora para mulheres - Efeito Furacão',
        'categoria'        => 'Tração/Escala',
        'municipio'        => 'Aripuanã',
        'estado'           => 'MT',
        'logo_negocio'     => null,
        'imagem_destaque'  => 'https://images.unsplash.com/photo-1446941611757-91d2c3bd3d45?w=600&q=80',
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliq',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Sustainable_Development_Goal_10.png/240px-Sustainable_Development_Goal_10.png',
        'ods_nome'         => 'ODS 10',
        'eixo_nome'        => 'Finanças',
        'empreendedor_nome'=> 'Daniela Silva',
    ],
    // Edição 2025 ─────────────────────────────────────────────────────
    [
        'premiacao_id'     => 2,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2025 - 1º semestre',
        'premiacao_ano'    => 2025,
        'negocio_id'       => 201,
        'nome_fantasia'    => 'Verde Raiz',
        'categoria'        => 'Dinamizador',
        'municipio'        => 'Cuiabá',
        'estado'           => 'MT',
        'logo_negocio'     => null,
        'imagem_destaque'  => 'https://www.greenpeace.org/static/planet4-brasil-stateless/2024/05/5b07ea98-floresta-amazonica-1024x682.jpg',
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Sustainable_Development_Goal_15.png/240px-Sustainable_Development_Goal_15.png',
        'ods_nome'         => 'ODS 15',
        'eixo_nome'        => 'Meio Ambiente',
        'empreendedor_nome'=> 'Carlos Mendes',
    ],
    [
        'premiacao_id'     => 2,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2025 - 1º semestre',
        'premiacao_ano'    => 2025,
        'negocio_id'       => 202,
        'nome_fantasia'    => 'Sementes do Futuro',
        'categoria'        => 'Ideação',
        'municipio'        => 'São Paulo',
        'estado'           => 'SP',
        'logo_negocio'     => 'https://placehold.co/200x80/eef4df/4f5f00?text=Sementes+do+Futuro',
        'imagem_destaque'  => null,
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius interdum.',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Sustainable_Development_Goal_04.png/240px-Sustainable_Development_Goal_04.png',
        'ods_nome'         => 'ODS 4',
        'eixo_nome'        => 'Educação',
        'empreendedor_nome'=> 'Ana Lima',
    ],
    [
        'premiacao_id'     => 2,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2025 - 1º semestre',
        'premiacao_ano'    => 2025,
        'negocio_id'       => 203,
        'nome_fantasia'    => 'Circuito Solidário',
        'categoria'        => 'Operação',
        'municipio'        => 'Belo Horizonte',
        'estado'           => 'MG',
        'logo_negocio'     => null,
        'imagem_destaque'  => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=600&q=80',
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec urna a felis.',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Sustainable_Development_Goal_11.png/240px-Sustainable_Development_Goal_11.png',
        'ods_nome'         => 'ODS 11',
        'eixo_nome'        => 'Cidadania, Direitos Humanos e Sociedade',
        'empreendedor_nome'=> 'João Ferreira',
    ],
    [
        'premiacao_id'     => 2,
        'premiacao_nome'   => 'Prêmio Impactos Positivos 2025 - 1º semestre',
        'premiacao_ano'    => 2025,
        'negocio_id'       => 204,
        'nome_fantasia'    => 'ImpulsoTech',
        'categoria'        => 'Tração/Escala',
        'municipio'        => 'Florianópolis',
        'estado'           => 'SC',
        'logo_negocio'     => null,
        'imagem_destaque'  => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600&q=80',
        'frase_negocio'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Aliquam erat volutpat.',
        'ods_icone'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Sustainable_Development_Goal_09.png/240px-Sustainable_Development_Goal_09.png',
        'ods_nome'         => 'ODS 9',
        'eixo_nome'        => 'Tecnologia e Inovação',
        'empreendedor_nome'=> 'Beatriz Souza',
    ],
];

// Aplicar filtros nos dados fictícios
// TO DO: quando usar o banco, os filtros já são aplicados via SQL ($whereAno / $whereCat)
$rows = array_filter($rowsFicticios, function($r) use ($filtroAno, $filtroCategoria) {
    $passaAno = ($filtroAno === 0 || (int)$r['premiacao_ano'] === $filtroAno);
    $passaCat = ($filtroCategoria === '' || $r['categoria'] === $filtroCategoria);
    return $passaAno && $passaCat;
});

// Agrupar por edição → categoria → negócios
// TO DO: este agrupamento permanece igual ao usar o banco
$porEdicao = [];
foreach ($rows as $r) {
    $anoKey = (int)$r['premiacao_ano'];
    if (!isset($porEdicao[$anoKey])) {
        $porEdicao[$anoKey] = [
            'id'         => $r['premiacao_id'],
            'nome'       => $r['premiacao_nome'],
            'ano'        => $anoKey,
            'categorias' => [],
        ];
    }
    $cat = $r['categoria'] ?: 'Sem categoria';
    if (!isset($porEdicao[$anoKey]['categorias'][$cat])) {
        $porEdicao[$anoKey]['categorias'][$cat] = [];
    }
    $porEdicao[$anoKey]['categorias'][$cat][] = $r;
}
// ══════════════════════════════════════════════════════════════════════
// FIM DOS DADOS FICTÍCIOS
// ══════════════════════════════════════════════════════════════════════


$iconesCat = [
    'Ideação'       => '/assets/images/icons/ideacao.png',
    'Operação'      => '/assets/images/icons/operacao.png',
    'Tração/Escala' => '/assets/images/icons/tracao.png',
    'Dinamizador'   => '/assets/images/icons/dinamizadores.png',
];


$emojiCat = [
    'Ideação'       => '💡',
    'Operação'      => '⚙️',
    'Tração/Escala' => '📈',
    'Dinamizador'   => '🌱',
];

// TO DO: quando usar o banco, buscar categorias únicas via query
// Ex: SELECT DISTINCT n.categoria FROM negocios n INNER JOIN premiacao_inscricoes pi ...
$todasCategorias = ['Dinamizador', 'Ideação', 'Operação', 'Tração/Escala'];

$pageTitle = 'Vencedores — Impactos Positivos';
$extraHead = <<<HTML
<style>
.venc-hero {
    width: 100%;
    background: linear-gradient(145deg, #1e3425 0%, #2d4f36 55%, #3a6647 100%);
    padding: 80px 0 72px;
    position: relative;
    overflow: hidden;
}
.venc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(ellipse 60% 40% at 15% 20%, rgba(205,222,0,.06) 0%, transparent 70%),
        radial-gradient(ellipse 50% 60% at 85% 80%, rgba(151,163,39,.07) 0%, transparent 70%);
    pointer-events: none;
}
.venc-hero-inner {
    position: relative;
    z-index: 1;
    max-width: 820px;
    margin: 0 auto;
    padding: 0 24px;
    text-align: center;
}
.venc-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .15em;
    color: #cdde00;
    margin-bottom: 20px;
}
.venc-eyebrow i { font-size: 1rem; }
.venc-hero h1 {
    font-size: clamp(2.6rem, 6vw, 4.4rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 20px;
    letter-spacing: -.02em;
}
.venc-hero h1 em {
    font-style: normal;
    color: #cdde00;
}
.venc-hero-sub {
    font-size: 1rem;
    color: rgba(255,255,255,.65);
    margin: 0;
    line-height: 1.6;
}

.venc-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 24px;
    padding: 28px 0 8px;
}
.venc-filters-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.venc-filters-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #9aab9d;
}
.venc-filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.venc-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 999px;
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid #c8d4ca;
    color: #1e3425;
    background: #fff;
    transition: background .18s, border-color .18s, color .18s, box-shadow .18s;
    cursor: pointer;
}
.venc-pill:hover {
    background: #eef3ec;
    border-color: #97a327;
    color: #1e3425;
    box-shadow: 0 2px 10px rgba(30,52,37,.08);
}
.venc-pill.ativo {
    background: #1e3425;
    border-color: #1e3425;
    color: #cdde00;
    box-shadow: 0 4px 14px rgba(30,52,37,.18);
}
.venc-pill img {
    width: 16px;
    height: 16px;
    object-fit: contain;
}

.venc-edicao-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin: 48px 0 28px;
}
.venc-edicao-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: linear-gradient(135deg, #1e3425, #3a6647);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #cdde00;
    box-shadow: 0 6px 20px rgba(30,52,37,.2);
}
.venc-edicao-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: #1e3425;
    margin: 0 0 3px;
    line-height: 1.2;
}
.venc-edicao-sub {
    font-size: .82rem;
    color: #9aab9d;
    margin: 0;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.venc-cat-label {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #eef4df;
}
.venc-cat-label img {
    width: 28px;
    height: 28px;
    object-fit: contain;
}
.venc-cat-label span {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e3425;
}
.venc-cat-emoji {
    font-size: 1.4rem;
    line-height: 1;
}

.venc-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #fff;
    border-radius: 1.4rem;
    overflow: hidden;
    border: 1.5px solid #e8f0d8;
    box-shadow: 0 6px 24px rgba(30,52,37,.06);
    transition: transform .22s cubic-bezier(.22,1,.36,1),
                box-shadow .22s cubic-bezier(.22,1,.36,1),
                border-color .22s;
}
.venc-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(30,52,37,.14);
    border-color: hsl(66, 61%, 40%);
}

.venc-card-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: linear-gradient(90deg, #eef6c0, #f5fadc);
    border-bottom: 1.5px solid #cdde00;
}
.venc-card-badge i { color: #1e3425; font-size: .9rem; }
.venc-card-badge span {
    font-size: .78rem;
    font-weight: 800;
    color: #1e3425;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.venc-card-link {
    display: flex;
    flex-direction: column;
    flex: 1;
    color: inherit;
    text-decoration: none;
}

.venc-card-media {
    position: relative;
    height: 200px;
    background: #eef2eb;
    overflow: hidden;
}
.venc-card-cover {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .3s ease;
}
.venc-card:hover .venc-card-cover {
    transform: scale(1.04);
}
.venc-card-media.sem-capa {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    background: linear-gradient(135deg, rgba(151,163,39,.12), rgba(30,52,37,.07));
}
.venc-card-logo-wrap {
    width: min(220px, 100%);
    height: 110px;
    padding: 1rem;
    border-radius: 1rem;
    background: rgba(255,255,255,.9);
    box-shadow: 0 8px 24px rgba(16,32,21,.08);
    display: flex;
    align-items: center;
    justify-content: center;
}
.venc-card-logo {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.venc-card-fallback {
    width: 82px;
    height: 82px;
    border-radius: 999px;
    background: #1e3425;
    color: #cdde00;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    font-weight: 800;
}

.venc-card-body {
    display: flex;
    flex-direction: column;
    gap: .85rem;
    padding: 1.15rem 1.15rem .8rem;
    flex: 1;
}
.venc-card-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1e3425;
    line-height: 1.25;
    margin: 0;
}
.venc-card-local {
    margin: 4px 0 0;
    color: #667085;
    font-size: .88rem;
    display: flex;
    align-items: center;
    gap: .38rem;
}
.venc-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .6rem;
}
.venc-chip {
    display: inline-flex;
    align-items: center;
    padding: .45rem .8rem;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 700;
    background: #eef4df;
    color: #4f5f00;
    line-height: 1.2;
}
.venc-ods img {
    width: 38px;
    height: 38px;
    object-fit: contain;
    display: block;
    flex-shrink: 0;
}
.venc-card-frase {
    margin: 0;
    padding-left: .85rem;
    border-left: 3px solid #cdde00;
    color: #475467;
    font-size: .9rem;
    line-height: 1.6;
    font-style: italic;
}
.venc-card-empreendedor {
    font-size: .82rem;
    color: #9aab9d;
    margin: 0;
    display: flex;
    align-items: center;
    gap: .35rem;
}

.venc-card-actions {
    padding: 0 1.15rem 1.15rem;
}
.venc-card-actions .btn {
    width: 100%;
    border-radius: 999px;
    font-weight: 700;
    font-size: .88rem;
    padding: 10px 20px;
    border: 1.5px solid #1e3425;
    color: #1e3425;
    background: transparent;
    transition: background .18s, color .18s, box-shadow .18s, transform .12s;
}
.venc-card-actions .btn:hover {
    background: #1e3425;
    color: #cdde00;
    box-shadow: 0 6px 20px rgba(30,52,37,.22);
    transform: translateY(-1px);
}

.venc-empty {
    text-align: center;
    padding: 64px 24px;
    border-radius: 1.5rem;
    background: #f8faf8;
    border: 1.5px dashed #c8d4ca;
    margin: 40px 0;
}
.venc-empty h3 { color: #1e3425; font-weight: 700; }
.venc-empty p  { color: #9aab9d; }

.venc-cta {
    text-align: center;
    padding: 56px 24px 72px;
}
.venc-cta p { color: #9aab9d; margin-bottom: 16px; }
.venc-cta .btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    border-radius: 999px;
    background: #1e3425;
    color: #cdde00;
    font-weight: 800;
    font-size: .95rem;
    text-decoration: none;
    border: none;
    transition: background .18s, transform .14s, box-shadow .18s;
    box-shadow: 0 6px 22px rgba(30,52,37,.2);
}
.venc-cta .btn-cta:hover {
    background: #152a1b;
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(30,52,37,.28);
    color: #cdde00;
}

@media (max-width: 600px) {
    .venc-hero { padding: 52px 0 44px; }
    .venc-filters { gap: 16px; }
    .venc-edicao-header { margin-top: 32px; }
}
</style>
HTML;

include __DIR__ . '/app/views/public/header_public.php';
?>

</main>

<div class="venc-hero">
    <div class="venc-hero-inner">
        <div class="venc-eyebrow">
            <i class="bi bi-trophy-fill"></i>
            Premiação
        </div>
        <h1>Vence<em>dores</em></h1>
        <p class="venc-hero-sub">
            Conheça os negócios de impacto positivo premiados em cada edição.
        </p>
    </div>
</div>

<main role="main" class="container">

    <div class="venc-filters">

        <div class="venc-filters-group">
            <span class="venc-filters-label">Filtrar por edição</span>
            <div class="venc-filter-pills">
                <a href="?<?= $filtroCategoria ? 'categoria='.urlencode($filtroCategoria) : '' ?>"
                   class="venc-pill <?= $filtroAno === 0 ? 'ativo' : '' ?>">
                    Todas
                </a>
                <?php foreach ($edicoes as $ed): ?>
                    <a href="?ano=<?= (int)$ed['ano'] ?><?= $filtroCategoria ? '&categoria='.urlencode($filtroCategoria) : '' ?>"
                       class="venc-pill <?= $filtroAno === (int)$ed['ano'] ? 'ativo' : '' ?>">
                        <?= (int)$ed['ano'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="venc-filters-group">
            <span class="venc-filters-label">Tipo de premiação</span>
            <div class="venc-filter-pills">
                <a href="?<?= $filtroAno ? 'ano='.$filtroAno : '' ?>"
                   class="venc-pill <?= $filtroCategoria === '' ? 'ativo' : '' ?>">
                    Todos
                </a>
                <?php foreach ($todasCategorias as $cat): ?>
                    <?php $icone = $iconesCat[$cat] ?? null; ?>
                    <a href="?<?= $filtroAno ? 'ano='.$filtroAno.'&' : '' ?>categoria=<?= urlencode($cat) ?>"
                       class="venc-pill <?= $filtroCategoria === $cat ? 'ativo' : '' ?>">
                        <?php if ($icone): ?>
                            <img src="<?= h($icone) ?>" alt="<?= h($cat) ?>">
                        <?php else: ?>
                            <span><?= $emojiCat[$cat] ?? '' ?></span>
                        <?php endif; ?>
                        <?= h($cat) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <?php if (empty($porEdicao)): ?>
        <div class="venc-empty">
            <i class="bi bi-trophy" style="font-size:2.5rem;color:#c8d4ca;display:block;margin-bottom:16px;"></i>
            <h3>Nenhum vencedor encontrado</h3>
            <p>Tente ajustar os filtros ou aguarde a divulgação dos resultados.</p>
            <a href="/premiacao.php" class="venc-pill ativo mt-3" style="display:inline-flex;">
                Ver premiação ativa
            </a>
        </div>

    <?php else: ?>

        <?php foreach ($porEdicao as $anoKey => $edicao): ?>
            <section>

                <div class="venc-edicao-header">
                    <div class="venc-edicao-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div>
                        <h2 class="venc-edicao-title"><?= h($edicao['nome']) ?></h2>
                        <p class="venc-edicao-sub">Edição <?= (int)$edicao['ano'] ?></p>
                    </div>
                </div>

                <?php foreach ($edicao['categorias'] as $categoria => $negocios): ?>
                    <div class="mb-5">

                        <div class="venc-cat-label">
                            <?php
                            $icCat = $iconesCat[$categoria] ?? null;
                            if ($icCat): ?>
                                <img src="<?= h($icCat) ?>" alt="<?= h($categoria) ?>">
                            <?php else: ?>
                                <span class="venc-cat-emoji"><?= $emojiCat[$categoria] ?? '🏅' ?></span>
                            <?php endif; ?>
                            <span><?= h($categoria) ?></span>
                        </div>

                        <div class="row g-4">
                            <?php foreach ($negocios as $n): ?>
                            <div class="col-12 col-md-6 col-xl-4">
                                <article class="venc-card h-100">

                                    <div class="venc-card-badge">
                                        <i class="bi bi-trophy-fill"></i>
                                        <span>Vencedor <?= (int)$edicao['ano'] ?></span>
                                    </div>

                                    <!-- Link principal clicável -->
                                    <!-- TO DO: href="/negocio.php?id=<?= (int)$n['negocio_id'] ?>" -->
                                    <a href="#" class="venc-card-link">

                                        <div class="venc-card-media <?= empty($n['imagem_destaque']) ? 'sem-capa' : '' ?>">
                                            <?php if (!empty($n['imagem_destaque'])): ?>
                                                <img src="<?= h($n['imagem_destaque']) ?>"
                                                     alt="<?= h($n['nome_fantasia']) ?>"
                                                     class="venc-card-cover">
                                            <?php elseif (!empty($n['logo_negocio'])): ?>
                                                <div class="venc-card-logo-wrap">
                                                    <img src="<?= h($n['logo_negocio']) ?>"
                                                         alt="<?= h($n['nome_fantasia']) ?>"
                                                         class="venc-card-logo">
                                                </div>
                                            <?php else: ?>
                                                <div class="venc-card-fallback">
                                                    <?= h(mb_strtoupper(mb_substr($n['nome_fantasia'], 0, 1))) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="venc-card-body">

                                            <div>
                                                <h4 class="venc-card-title"><?= h($n['nome_fantasia']) ?></h4>
                                                <?php if (!empty($n['municipio']) || !empty($n['estado'])): ?>
                                                    <p class="venc-card-local">
                                                        <i class="bi bi-geo-alt"></i>
                                                        <?= h(trim(($n['municipio'] ?? '') . ' / ' . ($n['estado'] ?? ''), ' /')) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="venc-card-meta">
                                                <?php if (!empty($n['eixo_nome'])): ?>
                                                    <span class="venc-chip"><?= h($n['eixo_nome']) ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($n['ods_icone'])): ?>
                                                    <span class="venc-ods">
                                                        <img src="<?= h($n['ods_icone']) ?>"
                                                             alt="<?= h($n['ods_nome'] ?? 'ODS') ?>">
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <?php if (!empty($n['frase_negocio'])): ?>
                                                <blockquote class="venc-card-frase">
                                                    <?= h($n['frase_negocio']) ?>
                                                </blockquote>
                                            <?php endif; ?>

                                            <?php if (!empty($n['empreendedor_nome'])): ?>
                                                <p class="venc-card-empreendedor">
                                                    <i class="bi bi-person"></i>
                                                    <?= h($n['empreendedor_nome']) ?>
                                                </p>
                                            <?php endif; ?>

                                        </div>
                                    </a>

                                    <div class="venc-card-actions">
                                        <!-- TO DO: href="/negocio.php?id=<?= (int)$n['negocio_id'] ?>" -->
                                        <a href="#" class="btn">Conhecer Negócio</a>
                                    </div>

                                </article>
                            </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                <?php endforeach; ?>

                <?php if (!array_key_last($porEdicao) === $anoKey): ?>
                    <hr style="margin:40px 0;border-color:#e8ede9;">
                <?php endif; ?>

            </section>
        <?php endforeach; ?>

    <?php endif; ?>

    <div class="venc-cta">
        <p>Quer participar da próxima edição?</p>
        <a href="/premiacao.php" class="btn-cta">
            <i class="bi bi-rocket-takeoff"></i>
            Ver premiação ativa e inscrever-se
        </a>
    </div>

</main>

<?php include __DIR__ . '/app/views/public/footer_public.php'; ?>