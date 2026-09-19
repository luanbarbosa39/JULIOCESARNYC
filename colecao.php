<?php
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'pt' : 'en';
$id   = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['id'] ?? ''));

// Load collections data
$data = json_decode(file_get_contents(__DIR__ . '/data/collections.json'), true);
$collection = null;
foreach ($data['collections'] as $c) {
    if ($c['id'] === $id || $c['slug'] === $id) { $collection = $c; break; }
}

if (!$collection) {
    header('Location: collection.php');
    exit;
}

$name    = $lang === 'pt' ? ($collection['namePt'] ?? $collection['nameEn']) : $collection['nameEn'];
$season  = $lang === 'pt' ? ($collection['seasonPt'] ?? $collection['season']) : $collection['season'];
$storyParagraphs = $lang === 'pt'
    ? ($collection['storyPt'] ?? $collection['storyEn'] ?? [])
    : ($collection['storyEn'] ?? []);
$heroImage = $collection['heroImage'] ?? ($collection['images'][0]['file'] ?? '');
$images    = $collection['images'] ?? [];

$pageTitle       = $name . ' - Júlio César NYC';
$pageDescription = $lang === 'pt'
    ? ($collection['descriptionPt'] ?? $collection['descriptionEn'] ?? '')
    : ($collection['descriptionEn'] ?? '');
$ogImage = !empty($heroImage) ? 'https://juliocesarnyc.com/' . ltrim($heroImage, '/') : '';

include __DIR__ . '/includes/head.php';
?>
<style>
.box-shadow { margin-bottom: 1.5rem!important; }
.box-texto  { flex: 1 1 auto; padding: 0.4rem; }
.textofoto  { font-style: italic; margin-bottom: 0; }
</style>

<?php if ($heroImage || !empty($storyParagraphs)): ?>
<div class="container">
<div class="box">
<div class="col-lg-12">
<h4><strong><?= htmlspecialchars(strtoupper($name)) ?></strong></h4>
<?php if ($season): ?><p class="text-muted"><?= htmlspecialchars($season) ?></p><?php endif; ?>

<?php if ($heroImage || !empty($storyParagraphs)): ?>
<div align="justify">
    <div class="col-md-12">
        <div class="box-shadow">
            <?php if ($heroImage): ?>
            <a class="glightbox" data-gallery="collection" href="<?= htmlspecialchars($heroImage) ?>" title="">
                <img loading="lazy" class="img-fluid" src="<?= htmlspecialchars($heroImage) ?>" />
            </a>
            <?php endif; ?>
            <?php if (!empty($storyParagraphs)): ?>
            <div class="box-texto">
                <?php foreach ($storyParagraphs as $p): ?>
                <p style="font-size: unset;"><?= $p ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

</div>
</div>
</div>
<?php endif; ?>

<?php if (!empty($images)): ?>
<div class="container">
<div class="row">
<?php foreach ($images as $img):
    $file = $img['file'] ?? '';
    $desc = $lang === 'pt' ? ($img['descriptionPt'] ?? '') : ($img['descriptionEn'] ?? '');
    if (!$file) continue;
?>
    <div class="col-md-4">
        <div class="box-shadow">
            <a class="glightbox" data-gallery="collection" href="<?= htmlspecialchars($file) ?>" title="">
                <img loading="lazy" class="img-fluid" src="<?= htmlspecialchars($file) ?>" />
            </a>
            <div class="box-texto">
                <p class="textofoto"><?= htmlspecialchars($desc) ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

<?php if (empty($images)): ?>
<div class="container"><p class="text-muted p-4"><?= $lang === 'pt' ? 'Em breve.' : 'Coming soon.' ?></p></div>
<?php endif; ?>

<script src="/js/glightbox.min.js"></script>
<script>
document.querySelectorAll(".glightbox").forEach(function(el) {
    var box = el.closest(".box-shadow");
    if (box) {
        var desc = box.querySelector(".textofoto");
        if (desc && desc.textContent.trim()) el.setAttribute("data-description", desc.textContent.trim());
    }
});
const lightbox = GLightbox({selector: ".glightbox", touchNavigation: true, loop: true, closeOnOutsideClick: true});
</script>
<?php include __DIR__ . '/includes/foot.php'; ?>
