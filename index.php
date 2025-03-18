<?php
require 'fetch_news.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noticiero</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'templates/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center">Últimas Noticias</h1>
    <div class="row">
        <?php foreach ($articles as $article): 
            $author = getRandomAuthor();
        ?>
        <div class="col-md-6">
            <div class="card mb-4">
                <img src="<?= $article['urlToImage'] ?>" class="card-img-top" alt="Imagen Noticia">
                <div class="card-body">
                    <h5 class="card-title"><?= $article['title'] ?></h5>
                    <p class="card-text"><?= $article['description'] ?></p>
                    <p><strong>Autor:</strong> <?= $author['name']['first'] . " " . $author['name']['last'] ?></p>
                    <img src="<?= $author['picture']['thumbnail'] ?>" class="rounded-circle" alt="Autor">
                    <a href="<?= $article['url'] ?>" class="btn btn-primary" target="_blank">Leer más</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Anterior</a></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Siguiente</a></li>
        </ul>
    </nav>
</div>

<?php include 'templates/footer.php'; ?>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
