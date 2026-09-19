<?php
// $pageTitle, $pageDescription, $ogImage, $lang already set by caller
$lang = $lang ?? 'en';
$pageTitle = $pageTitle ?? 'Júlio César NYC';
$pageDescription = $pageDescription ?? 'Exclusive high fashion collections by designer Júlio César. Explore our latest designs, collections, and couture creations.';
$ogImage = $ogImage ?? 'https://juliocesarnyc.com/img/waters/01.jpg';
$customJs = ($lang === 'pt') ? 'custom-pt.js' : 'custom.js?v=2';
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'pt' ? 'pt-BR' : 'en' ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Julio Cesar NYC">
    <link rel="shortcut icon" href="/img/icone.png" type="image/png" />
    <script src="https://kit.fontawesome.com/64c0754995.js" crossorigin="anonymous"></script>
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
    <meta property="og:type" content="website">
    <link href="/css/bootstrap5.min.css" rel="stylesheet">
    <link href="/css/business-casual.css" rel="stylesheet">
    <link href="/css/header-footer.css?v=2" rel="stylesheet">
    <link href="/css/layout.css?v=2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="/css/glightbox.min.css" />
    <script src="/<?= $customJs ?>"></script>
</head>
<body>
<my-header></my-header>
