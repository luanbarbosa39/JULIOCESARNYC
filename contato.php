<?php
$lang  = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'pt' : 'en';
$pages = json_decode(file_get_contents(__DIR__ . '/data/pages.json'), true);
$contact = $pages['contact'];

$pageTitle = $lang === 'pt' ? 'Contato - Júlio César NYC' : 'Contact - Júlio César NYC';
$pageDescription = $lang === 'pt'
    ? 'Entre em contato com Júlio César NYC.'
    : 'Contact Júlio César NYC.';

include __DIR__ . '/includes/head.php';
?>
<div class="wrapper fade-in">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4><strong>USA</strong></h4>
                <p><?= $lang === 'pt' ? 'Telefone' : 'Phone' ?>: <strong><?= htmlspecialchars($contact['usa']['phone']) ?></strong></p>
                <p>Email: <strong><a style="color:#888" href="mailto:<?= htmlspecialchars($contact['usa']['email']) ?>">
                    <?= htmlspecialchars($contact['usa']['email']) ?></a></strong></p>
                <a href="https://goo.gl/maps/93WMf4SFgzcsq44S9" target="_blank">
                    <p><?= $lang === 'pt' ? 'Endereço' : 'Address' ?>: <strong><?= htmlspecialchars($contact['usa']['address']) ?></strong></p>
                </a>
                <iframe src="<?= htmlspecialchars($contact['usa']['mapEmbed']) ?>"
                    width="80%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6">
                <h4><strong>Brazil</strong></h4>
                <p><?= $lang === 'pt' ? 'Telefone' : 'Phone' ?>: <strong><?= htmlspecialchars($contact['brazil']['phone']) ?></strong></p>
                <p>Email: <strong><a style="color:#888" href="mailto:<?= htmlspecialchars($contact['brazil']['email']) ?>">
                    <?= htmlspecialchars($contact['brazil']['email']) ?></a></strong></p>
                <a href="https://goo.gl/maps/WsBwhaNyXSougXvk7" target="_blank">
                    <p><?= $lang === 'pt' ? 'Endereço' : 'Address' ?>: <strong><?= htmlspecialchars($contact['brazil']['address']) ?></strong></p>
                </a>
                <iframe src="<?= htmlspecialchars($contact['brazil']['mapEmbed']) ?>"
                    width="80%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>
