<?php
$lang  = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'pt' : 'en';
$press = json_decode(file_get_contents(__DIR__ . '/data/press.json'), true);
$items = $press['items'] ?? [];

$pageTitle = $lang === 'pt' ? 'Imprensa - Júlio César NYC' : 'Press - Júlio César NYC';
$pageDescription = $lang === 'pt'
    ? 'Cobertura da imprensa sobre o designer Júlio César NYC.'
    : 'Press coverage about designer Júlio César NYC.';

include __DIR__ . '/includes/head.php';
?>
<style>.thumbnail { max-width:100%; height:auto; }</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2><?= $lang === 'pt' ? 'Imprensa' : 'Press' ?></h2>
        </div>
    </div>
    <div class="row">
    <?php foreach ($items as $item):
        $title = $lang === 'pt' ? ($item['titlePt'] ?? $item['titleEn']) : $item['titleEn'];
    ?>
        <div class="col-md-4 col-12 mb-4">
            <div class="list-group">
                <a target="_blank" href="<?= htmlspecialchars($item['url']) ?>" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= htmlspecialchars($title) ?></h5>
                    </div>
                    <img src="<?= htmlspecialchars($item['image']) ?>" class="thumbnail mt-2" alt="">
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>
