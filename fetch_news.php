<?php

//llamado de las Apis

define('NEWS_API_KEY', '51f6efb545134117b884df0a9a61546a'); 
define('NEWS_API_URL', 'https://newsapi.org/v2/top-headlines?country=us&pageSize=10&page=');
define('RANDOM_USER_API', 'https://randomuser.me/api/');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$cacheDir = __DIR__ . "/cache"; 
$cacheFile = "$cacheDir/news_page_$page.json";
$cacheTime = 300; 


if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}


function getNews($page, $cacheFile) {
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 300) {
        return json_decode(file_get_contents($cacheFile), true);
    }

    $newsUrl = NEWS_API_URL . $page . '&apiKey=' . NEWS_API_KEY;
    
   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $newsUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        return ['articles' => []]; 
    }

    file_put_contents($cacheFile, $response); 
    return json_decode($response, true);
}

// Para obtener un autor aleatorio
function getRandomAuthor() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, RANDOM_USER_API);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    return $data['results'][0] ?? null;
}

//  Obtener noticias
$newsData = getNews($page, $cacheFile);
$articles = $newsData['articles'] ?? [];
?>
