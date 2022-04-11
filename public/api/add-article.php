<?php
require __DIR__ . '/../../Config.php';
require __DIR__ . '/../../Model/DB.php';
require __DIR__ . '/../../Model/Entity/AbstractEntity.php';
require __DIR__ . '/../../Model/Entity/Article.php';
require __DIR__ . '/../../Model/Entity/User.php';
require __DIR__ . '/../../Model/Manager/ArticleManager.php';


use App\Model\Entity\Article;
use App\Model\Manager\ArticleManager;
use App\Model\Entity\User;

session_start();

$payload = file_get_contents('php://input');
$payload = json_decode($payload);

// On quitte si tous les paramètres ne sont pas la...
if(empty($payload->title) || empty($payload->content)) {
    // 400 = Bad Request.
    http_response_code(400);
    exit;
}

// On quitte si l'utilisateur n'est pas connecté !
if(!isset($_SESSION['user'])) {
    // 403 = Non autorisé.
    http_response_code(403);
    exit;
}

// On nettoye les données.
$title = filter_var($payload->title, FILTER_SANITIZE_STRING);
$content = trim(strip_tags(htmlentities(($payload->content))));

$article = new Article();
$article->setTitle($title);
$article->setContent($content);
$article->setAuthor($_SESSION['user']);

// On tente l'enregistrement.
if (ArticleManager::addNewArticle($article)) {
    // Si on le souhaite, on peut renvoyer l'article avec son ID (souvenez vous qu'on lui donne son id après enregistrement)
    echo json_encode([
        'id' => $article->getId(),
        'title' => $article->getTitle(),
        'content' => $article->getContent(),
        'author' => $article->getAuthor()->getFirstname(),
    ]);
    http_response_code(200);
    exit;
}

http_response_code(200);
exit;