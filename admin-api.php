<?php
/**
 * Admin API - Júlio César NYC
 * Handles read/write operations for collection pages
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: same-origin');

// Simple auth - change this password
define('ADMIN_PASSWORD', 'juliocesar2025');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Check auth for write operations
$write_actions = ['save_collection', 'upload_image', 'delete_image', 'save_about'];
if (in_array($action, $write_actions)) {
    $token = $_SERVER['HTTP_X_ADMIN_TOKEN'] ?? $_POST['token'] ?? '';
    if ($token !== md5(ADMIN_PASSWORD . date('Y-m-d'))) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
}

// Known collection pages
$COLLECTIONS = [
    'waters-of-march'        => ['file' => 'waters-of-march.html',       'name' => 'Waters of March', 'has_descriptions' => true],
    'waters-of-march_pt'     => ['file' => 'waters-of-march_pt.html',    'name' => 'Águas de Março (PT)', 'has_descriptions' => true],
    'tkos'                   => ['file' => 'tkos.html',                  'name' => 'The Kindness of Strangers', 'has_descriptions' => true],
    'tkos_pt'                => ['file' => 'tkos_pt.html',               'name' => 'A Gentileza dos Estranhos (PT)', 'has_descriptions' => true],
    'wanderlust'             => ['file' => 'wanderlust.html',             'name' => 'Wanderlust', 'has_descriptions' => true],
    'wanderlust_pt'          => ['file' => 'wanderlust_pt.html',          'name' => 'Wanderlust (PT)', 'has_descriptions' => true],
    'soft-seduction'         => ['file' => 'soft-seduction.html',         'name' => 'Soft Seduction', 'has_descriptions' => true],
    'soft-seduction_pt'      => ['file' => 'soft-seduction_pt.html',      'name' => 'Soft Seduction (PT)', 'has_descriptions' => true],
    'sampa-sp'               => ['file' => 'sampa-sp.html',               'name' => 'Fall/Winter 2023', 'has_descriptions' => true],
    'sampa-sp_pt'            => ['file' => 'sampa-sp_pt.html',            'name' => 'Fall/Winter 2023 (PT)', 'has_descriptions' => true],
    'rio'                    => ['file' => 'rio.html',                    'name' => 'Fall/Winter 2022', 'has_descriptions' => true],
    'rio_pt'                 => ['file' => 'rio_pt.html',                 'name' => 'Fall/Winter 2022 (PT)', 'has_descriptions' => true],
    'colors-and-devotion'    => ['file' => 'colors-and-devotion.html',    'name' => 'Colors and Devotion', 'has_descriptions' => true],
    'colors-and-devotion_pt' => ['file' => 'colors-and-devotion_pt.html', 'name' => 'Colors and Devotion (PT)', 'has_descriptions' => true],
    'land-of-plenty'         => ['file' => 'land-of-plenty.html',         'name' => 'Land of Plenty', 'has_descriptions' => true],
    'gentle_stillness'       => ['file' => 'gentle_stillness.html',       'name' => 'Gentle Stillness', 'has_descriptions' => true],
    'gentle_stillness_pt'    => ['file' => 'gentle_stillness_pt.html',    'name' => 'Gentle Stillness (PT)', 'has_descriptions' => true],
    'reflections'            => ['file' => 'reflections.html',            'name' => 'Reflections', 'has_descriptions' => true],
    'touchingfromadistance'  => ['file' => 'touchingfromadistance.html',  'name' => 'Touching from a Distance', 'has_descriptions' => true],
    'polymath'               => ['file' => 'polymath.html',               'name' => 'Polymath', 'has_descriptions' => true],
    'sp2019'                 => ['file' => 'sp2019.html',                 'name' => 'Spring/Summer 2019', 'has_descriptions' => true],
    'ciclo'                  => ['file' => 'ciclo.html',                  'name' => 'Ciclo', 'has_descriptions' => false],
    'ciclo-en'               => ['file' => 'ciclo-en.html',               'name' => 'Ciclo (EN)', 'has_descriptions' => false],
];

switch ($action) {

    case 'login':
        $pw = $_POST['password'] ?? '';
        if ($pw === ADMIN_PASSWORD) {
            $token = md5(ADMIN_PASSWORD . date('Y-m-d'));
            echo json_encode(['ok' => true, 'token' => $token]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Wrong password']);
        }
        break;

    case 'list_collections':
        $out = [];
        foreach ($COLLECTIONS as $key => $col) {
            $out[] = ['key' => $key, 'name' => $col['name'], 'file' => $col['file'], 'has_descriptions' => $col['has_descriptions']];
        }
        echo json_encode(['collections' => $out]);
        break;

    case 'get_collection':
        $key = $_GET['key'] ?? '';
        if (!isset($COLLECTIONS[$key])) { echo json_encode(['error' => 'Not found']); break; }
        $col = $COLLECTIONS[$key];
        $file = __DIR__ . '/' . $col['file'];
        if (!file_exists($file)) { echo json_encode(['error' => 'File not found: ' . $col['file']]); break; }
        $html = file_get_contents($file);
        $pieces = parse_pieces($html, $col['has_descriptions']);
        echo json_encode(['key' => $key, 'name' => $col['name'], 'file' => $col['file'], 'pieces' => $pieces]);
        break;

    case 'save_collection':
        $body = json_decode(file_get_contents('php://input'), true);
        $key = $body['key'] ?? '';
        $pieces = $body['pieces'] ?? [];
        if (!isset($COLLECTIONS[$key])) { echo json_encode(['error' => 'Not found']); break; }
        $col = $COLLECTIONS[$key];
        $file = __DIR__ . '/' . $col['file'];
        if (!file_exists($file)) { echo json_encode(['error' => 'File not found']); break; }
        $html = file_get_contents($file);
        $new_html = rebuild_pieces($html, $pieces, $col['has_descriptions']);
        // Backup
        file_put_contents($file . '.bak', $html);
        file_put_contents($file, $new_html);
        echo json_encode(['ok' => true, 'message' => 'Collection saved']);
        break;

    case 'upload_image':
        $collection = $_POST['collection'] ?? '';
        if (!isset($COLLECTIONS[$collection])) { echo json_encode(['error' => 'Invalid collection']); break; }
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Upload failed']); break;
        }
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $mime = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($mime, $allowed)) { echo json_encode(['error' => 'Invalid file type']); break; }
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $folder = 'img/' . preg_replace('/[^a-z0-9_-]/', '', strtolower($collection)) . '/';
        if (!is_dir(__DIR__ . '/' . $folder)) mkdir(__DIR__ . '/' . $folder, 0755, true);
        // Find next available number
        $i = 1;
        while (file_exists(__DIR__ . '/' . $folder . $i . '.' . $ext)) $i++;
        $filename = $i . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/' . $folder . $filename);
        echo json_encode(['ok' => true, 'path' => $folder . $filename]);
        break;

    case 'get_about':
        $file = __DIR__ . '/about.html';
        $html = file_get_contents($file);
        // Extract bio paragraphs between col-lg-7 div
        preg_match('/<div class="col-lg-7">(.*?)<\/div>/s', $html, $m);
        $bio_html = trim($m[1] ?? '');
        // Extract photo paths
        preg_match_all('/src="(img\/profile[^"]+)"/', $html, $pm);
        echo json_encode(['photos' => $pm[1], 'bio_html' => $bio_html]);
        break;

    default:
        echo json_encode(['error' => 'Unknown action: ' . $action]);
}

/**
 * Parse pieces from a collection HTML file
 */
function parse_pieces($html, $has_descriptions) {
    $pieces = [];
    // Match box-shadow divs (collections with descriptions)
    if ($has_descriptions) {
        preg_match_all('/<div class="box-shadow">(.*?)<\/div>\s*<\/div>/s', $html, $matches);
        foreach ($matches[1] as $block) {
            // Get href (large image)
            preg_match('/href="([^"]+)"/', $block, $href);
            // Get src (thumbnail - same as href usually)
            preg_match('/src="([^"]+)"/', $block, $src);
            // Get description
            preg_match('/<p class="textofoto">(.*?)<\/p>/s', $block, $desc);
            if (!empty($href[1])) {
                $pieces[] = [
                    'href' => $href[1],
                    'src'  => $src[1] ?? $href[1],
                    'desc' => trim(strip_tags($desc[1] ?? '')),
                ];
            }
        }
    } else {
        // Simple gallery (ciclo style) - just glightbox links
        preg_match_all('/<a href="([^"]+)"[^>]*class="glightbox"[^>]*>[\s\S]*?<img src="([^"]+)"[^>]*>[\s\S]*?<\/a>/i', $html, $matches, PREG_SET_ORDER);
        foreach ($matches as $m) {
            $pieces[] = [
                'href' => $m[1],
                'src'  => $m[2],
                'desc' => '',
            ];
        }
    }
    return $pieces;
}

/**
 * Rebuild the pieces section in the HTML file
 */
function rebuild_pieces($html, $pieces, $has_descriptions) {
    if ($has_descriptions) {
        // Build new pieces HTML
        $new_pieces = '';
        foreach ($pieces as $p) {
            $href = htmlspecialchars($p['href'], ENT_QUOTES);
            $src  = htmlspecialchars($p['src'],  ENT_QUOTES);
            $desc = htmlspecialchars($p['desc'],  ENT_QUOTES | ENT_HTML5);
            $new_pieces .= '        <div class="col-md-4">' . "\n";
            $new_pieces .= '                    <div class="box-shadow"><a class="glightbox" data-gallery="collection" href="' . $href . '" title=""><img class="img-fluid" src="' . $src . '" /> </a>' . "\n";
            $new_pieces .= '                 <div class="box-texto">' . "\n";
            $new_pieces .= '                         <p class="textofoto">' . htmlspecialchars_decode($desc) . '</p>' . "\n";
            $new_pieces .= '                </div>' . "\n";
            $new_pieces .= '                    </div>' . "\n";
            $new_pieces .= '        </div>' . "\n";
        }
        // Replace the pieces section (between the first row div and closing row)
        // Find the row that contains col-md-4 boxes
        $pattern = '/(<div class="row"[^>]*class="linha\d*"[^>]*>|<div class="row" class="linha\d*">)(.*?)(<\/div>\s*<\/div>\s*<!-- The Gallery|<\/div>\s*<\/div>\s*\n\s*<my-footer|<\/div>\s*<\/div>\s*\n<my-footer)/s';
        if (preg_match($pattern, $html, $m, PREG_OFFSET_CAPTURE)) {
            $start = $m[0][1];
            $len = strlen($m[0][0]);
            $replacement = $m[1][0] . "\n" . $new_pieces . $m[3][0];
            $html = substr($html, 0, $start) . $replacement . substr($html, $start + $len);
        } else {
            // Fallback: replace all col-md-4 blocks in the main content area
            // More targeted: find second .row (first is usually the header box)
            preg_match_all('/<div class="row"[^>]*>(.*?)<\/div>\s*<\/div>/s', $html, $rows, PREG_OFFSET_CAPTURE);
            // Find the row containing glightbox links
            foreach ($rows[0] as $row) {
                if (strpos($row[0], 'glightbox') !== false) {
                    $html = substr($html, 0, $row[1]) . '<div class="row" class="linha1">' . "\n" . $new_pieces . "\n</div>\n</div>" . substr($html, $row[1] + strlen($row[0]));
                    break;
                }
            }
        }
    } else {
        // Ciclo style - rebuild the links div
        $new_links = '';
        foreach ($pieces as $p) {
            $href = htmlspecialchars($p['href'], ENT_QUOTES);
            $src  = htmlspecialchars($p['src'],  ENT_QUOTES);
            $new_links .= '                <div class="col-md-4">' . "\n";
            $new_links .= '                    <a href="' . $href . '" title="" class="glightbox" data-gallery="collection"><img src="' . $src . '" class="img-fluid"></a>' . "\n";
            $new_links .= '                </div>' . "\n";
        }
        $html = preg_replace(
            '/(<div id="links"[^>]*>)(.*?)(<\/div>\s*<\/div>)/s',
            '$1' . "\n" . $new_links . '$3',
            $html
        );
    }
    return $html;
}
