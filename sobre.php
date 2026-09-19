<?php
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'pt' : 'en';
$pages = json_decode(file_get_contents(__DIR__ . '/data/pages.json'), true);
$about = $pages['about'];

$pageTitle = $lang === 'pt'
    ? 'Sobre - Júlio César NYC'
    : 'About - Júlio César NYC';
$pageDescription = $lang === 'pt'
    ? 'Sobre Júlio César - estilista brasileiro baseado em Nova York, conhecido por colagem em tecido e alta costura.'
    : 'About Júlio César NYC - Brazilian fashion designer based in New York, known for collage on fabric and haute couture creations.';

$title = $lang === 'pt' ? $about['titlePt'] : $about['titleEn'];
$bio   = $lang === 'pt' ? $about['bioPt'] : $about['bioEn'];

include __DIR__ . '/includes/head.php';
?>
<div class="container">
    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <h4><?= htmlspecialchars($title) ?></h4>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div id="aboutCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-indicators">
                            <?php foreach ($about['photos'] as $i => $photo): ?>
                            <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="<?= $i ?>"
                                <?= $i === 0 ? 'class="active" aria-current="true"' : '' ?>
                                aria-label="Photo <?= $i+1 ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php foreach ($about['photos'] as $i => $photo): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                <img src="<?= htmlspecialchars($photo) ?>" class="d-block w-100" alt="Júlio César - Profile">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <p class="mt-2 text-center" style="font-size:0.85em; color:#999;">
                        Photo by <a href="<?= htmlspecialchars($about['photoCreditUrl']) ?>" target="_blank" style="color:#999;">
                        <?= htmlspecialchars($about['photoCredit']) ?></a>
                    </p>
                </div>
                <div class="col-lg-7">
                    <?php foreach ($bio as $paragraph): ?>
                    <p><?= $paragraph ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>
