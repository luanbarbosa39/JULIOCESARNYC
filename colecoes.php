<?php
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'pt' : 'en';
$data = json_decode(file_get_contents(__DIR__ . '/data/collections.json'), true);
$collections = $data['collections'] ?? [];

$pageTitle = $lang === 'pt' ? 'Coleções - Júlio César NYC' : 'Collections - Júlio César NYC';
$pageDescription = $lang === 'pt'
    ? 'Explore todas as coleções de alta costura de Júlio César NYC.'
    : 'Explore all haute couture collections by Júlio César NYC.';

include __DIR__ . '/includes/head.php';
?>
<style>
.hovereffect { width:100%; height:100%; float:left; overflow:hidden; position:relative; text-align:center; cursor:default; }
.hovereffect .overlay { width:100%; height:100%; position:absolute; overflow:hidden; top:0; left:0; }
.hovereffect img { display:block; position:relative; transition: all 0.4s ease-in; }
.hovereffect:hover img { filter: grayscale(1) blur(3px); transform: scale(1.2); }
</style>

<div class="wrapper fade-in">
<div class="container">
    <div class="row">
<?php foreach ($collections as $c):
    $name = $lang === 'pt' ? ($c['namePt'] ?? $c['nameEn']) : $c['nameEn'];
    $thumb = $c['thumbnail'] ?? '';
    $url = 'colecao.php?id=' . urlencode($c['id']) . ($lang === 'pt' ? '&lang=pt' : '');
?>
        <div class="col-sm-6 col-md-4">
            <a class="click" target="_blank" href="<?= htmlspecialchars($url) ?>">
                <img loading="lazy" class="img-fluid" src="<?= htmlspecialchars($thumb) ?>" alt="<?= htmlspecialchars($name) ?>">
                <h4><?= htmlspecialchars($name) ?></h4>
            </a>
        </div>
<?php endforeach; ?>
    </div>
</div>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>
