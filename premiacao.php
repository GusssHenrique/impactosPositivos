<?php

session_start();

$vencedores_divulgados = ($_GET['estado'] ?? '') === 'vencedores';

$pageTitle = 'Prêmio Impactos Positivos 2026 — 1º Semestre';

$extraHead = <<<HTML
<style>
  .premio-hero {
    width: 100%;
    background: linear-gradient(145deg, #1e3425 0%, #2d4f36 55%, #3a6647 100%);
    padding: 80px 0 72px;
    position: relative;
    overflow: hidden;
  }

  .premio-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
      radial-gradient(ellipse 60% 40% at 15% 20%, rgba(205,222,0,.06) 0%, transparent 70%),
      radial-gradient(ellipse 50% 60% at 85% 80%, rgba(151,163,39,.07) 0%, transparent 70%);
    pointer-events: none;
  }

  .premio-hero-inner {
    position: relative;
    z-index: 1;
    max-width: 820px;
    margin: 0 auto;
    padding: 0 24px;
    text-align: center;
  }

  .premio-eyebrow {
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

  .premio-eyebrow i { font-size: 1rem; }

  .premio-hero h1 {
    font-size: clamp(2.4rem, 6vw, 4.2rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 20px;
    letter-spacing: -.02em;
  }

  .premio-hero h1 em {
    font-style: normal;
    color: #cdde00;
  }

  .premio-hero-sub {
    font-size: 1rem;
    color: rgba(255,255,255,.65);
    margin: 0;
    line-height: 1.6;
  }

  .premio-hero-sub strong { color: rgba(255,255,255,.9); font-weight: 600; }

  .premio-hero-sub a {
    color: #cdde00;
    text-decoration: none;
    font-weight: 600;
    border-bottom: 1px solid rgba(205,222,0,.4);
    transition: border-color .2s;
  }

  .premio-hero-sub a:hover { border-color: #cdde00; }

  .premio-alertas {
    padding: 48px 0 56px;
  }

  .premio-alertas-inner {
    max-width: 720px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .ip-alerta {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    padding: 24px 28px;
    border-radius: 16px;
    border: 1.5px solid transparent;
    transition: transform .2s, box-shadow .2s;
  }

  .ip-alerta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(30,52,37,.1);
  }

  .ip-alerta-icon {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  .ip-alerta-body { flex: 1; }

  .ip-alerta-body h3 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0 0 6px;
    line-height: 1.3;
  }

  .ip-alerta-body p {
    font-size: .875rem;
    margin: 0 0 16px;
    line-height: 1.55;
  }

  .ip-alerta-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    border-radius: 8px;
    font-size: .875rem;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s, transform .1s, box-shadow .2s;
    border: none;
    cursor: pointer;
    letter-spacing: .01em;
  }

  .ip-alerta-btn:hover { transform: translateY(-1px); }

  .ip-alerta--votacao-encerrada { background: #eef3ec; border-color: #b8d4b0; }
  .ip-alerta--votacao-encerrada .ip-alerta-icon { background: rgba(30,52,37,.1); color: #1e3425; }
  .ip-alerta--votacao-encerrada h3 { color: #1e3425; }
  .ip-alerta--votacao-encerrada p  { color: #3d5e44; }
  .ip-alerta--votacao-encerrada .ip-alerta-btn { background: #1e3425; color: #cdde00; }
  .ip-alerta--votacao-encerrada .ip-alerta-btn:hover { background: #16291d; box-shadow: 0 6px 20px rgba(30,52,37,.28); color: #cdde00; }

  .ip-alerta--vencedores { background: #f0f4e0; border-color: #c5d465; }
  .ip-alerta--vencedores .ip-alerta-icon { background: rgba(151,163,39,.15); color: #97a327; }
  .ip-alerta--vencedores h3 { color: #5a6318; }
  .ip-alerta--vencedores p  { color: #6b7530; }
  .ip-alerta--vencedores .ip-alerta-btn { background: #97a327; color: #fff; }
  .ip-alerta--vencedores .ip-alerta-btn:hover { background: #7e8a20; box-shadow: 0 6px 20px rgba(151,163,39,.32); color: #fff; }

  /* ── Toggle de prévia ── */
  .estado-toggle { text-align: center; padding: 10px 0 0; }
  .estado-toggle p { font-size: .72rem; color: #9aab9d; margin: 0 0 6px; text-transform: uppercase; letter-spacing: .05em; font-weight: 700; }
  .estado-toggle .d-flex { display: flex; justify-content: center; gap: 8px; }
  .estado-toggle a { font-size: .78rem; padding: 5px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; border: 1.5px solid; transition: all .18s; }
  .estado-toggle a.ativo { background: #1e3425; color: #cdde00; border-color: #1e3425; }
  .estado-toggle a:not(.ativo) { background: transparent; color: #1e3425; border-color: #b8d4b0; }
  .estado-toggle a:not(.ativo):hover { background: #eef3ec; }

  @media (max-width: 600px) {
    .premio-hero { padding: 56px 0 48px; }
    .ip-alerta { padding: 18px; gap: 14px; }
    .ip-alerta-icon { width: 38px; height: 38px; font-size: 1.05rem; }
  }
</style>
HTML;

include __DIR__ . '/app/views/public/header_public.php';
?>

</main>

<div class="premio-hero">
  <div class="premio-hero-inner">

    <div class="premio-eyebrow">
      <i class="bi bi-trophy-fill"></i>
      Edição 2026 · 1º Semestre
    </div>

    <h1>
      Prêmio<br>
      Impactos<br>
      <em>Positivos</em>
    </h1>

    <p class="premio-hero-sub">
      Os vencedores da <strong>Edição 2026</strong> já foram divulgados!&nbsp;
      <a href="https://impactospositivos.com/regulamento-do-premio/" target="_blank">Ver regulamento</a>
    </p>

  </div>
</div>

<main role="main" class="container">

  <div class="premio-alertas">
    <div class="premio-alertas-inner">

      <?php if (!$vencedores_divulgados): ?>
        <div class="ip-alerta ip-alerta--votacao-encerrada">
          <div class="ip-alerta-icon">
            <i class="bi bi-calendar-check-fill"></i>
          </div>
          <div class="ip-alerta-body">
            <h3>Votações encerradas — Edição 2026</h3>
            <p>
              Obrigado a todos que participaram! As votações foram encerradas e a
              cerimônia de premiação acontecerá no dia <strong>20/05/2026</strong>.
              Em breve os vencedores serão anunciados.
            </p>
            <a href="https://blog.impactospositivos.com/encontro/edicao-2025/" class="ip-alerta-btn">
              <i class="bi bi-calendar3-event"></i>
              Acompanhar o evento
            </a>
          </div>
        </div>

      <?php else: ?>
        <div class="ip-alerta ip-alerta--vencedores">
          <div class="ip-alerta-icon">
            <i class="bi bi-trophy-fill"></i>
          </div>
          <div class="ip-alerta-body">
            <h3>Os vencedores já foram divulgados!</h3>
            <p>
              Confira os negócios premiados nesta edição e em todas as edições anteriores.
            </p>
            <a href="/vencedores.php" class="ip-alerta-btn">
              <i class="bi bi-trophy"></i>
              Ver os vencedores
            </a>
          </div>
        </div>
      <?php endif; ?>

      <div class="estado-toggle">
        <p>Prévia dos estados da página</p>
        <div class="d-flex">
          <a href="?estado=encerrada" class="<?= !$vencedores_divulgados ? 'ativo' : '' ?>">
            Votação encerrada
          </a>
          <a href="?estado=vencedores" class="<?= $vencedores_divulgados ? 'ativo' : '' ?>">
            Vencedores divulgados
          </a>
        </div>
      </div>

    </div>
  </div>

<?php include __DIR__ . '/app/views/public/footer_public.php'; ?>
