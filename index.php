<?php
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'pt' : 'en';
$data = json_decode(file_get_contents(__DIR__ . '/data/collections.json'), true);
// Use first 5 images from the latest collection as carousel slides
$latest = $data['collections'][0] ?? null;
$carouselImages = [];
if ($latest) {
    $imgs = $latest['images'] ?? [];
    // Pick varied indices for visual interest
    $picks = [0, 5, 10, 14, 18];
    foreach ($picks as $i) {
        if (isset($imgs[$i])) $carouselImages[] = $imgs[$i]['file'];
    }
    if (empty($carouselImages) && !empty($imgs)) $carouselImages[] = $imgs[0]['file'];
}
$latestName = $latest ? ($lang === 'pt' ? ($latest['namePt'] ?? $latest['nameEn']) : $latest['nameEn']) : '';
$latestSeason = $latest ? ($lang === 'pt' ? ($latest['seasonPt'] ?? $latest['season']) : $latest['season']) : '';
$latestUrl = $latest ? 'colecao.php?id=' . urlencode($latest['id']) . ($lang === 'pt' ? '&lang=pt' : '') : '#';

$pageTitle = 'Júlio César NYC';
$pageDescription = $lang === 'pt'
    ? 'Coleções exclusivas de alta costura por Júlio César. Explore nossos designs e criações mais recentes.'
    : 'Exclusive high fashion collections by designer Júlio César. Explore our latest designs, collections, and couture creations.';
$ogImage = !empty($carouselImages) ? 'https://juliocesarnyc.com/' . ltrim($carouselImages[0], '/') : '';

include __DIR__ . '/includes/head.php';
?>
<script src="/js/collections-loader.js"></script>

<div id="myCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <?php foreach ($carouselImages as $i => $img): ?>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?= $i ?>"
            <?= $i === 0 ? 'class="active" aria-current="true"' : '' ?>
            aria-label="Slide <?= $i+1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner" id="carousel-inner">
        <?php foreach ($carouselImages as $i => $img): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <a href="<?= htmlspecialchars($latestUrl) ?>">
                <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100"
                    alt="<?= htmlspecialchars($latestName) ?>">
            </a>
            <?php if ($i === 0): ?>
            <div class="carousel-caption">
                <h3><?= htmlspecialchars($latestName) ?></h3>
                <p><?= htmlspecialchars($latestSeason) ?> &mdash; <?= $lang === 'pt' ? 'Última Coleção' : 'Latest Collection' ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>
