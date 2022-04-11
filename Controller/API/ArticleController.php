<?php

namespace App\Controller\API;

use App\Controller\AbstractController;
use App\Model\Entity\Article;
use App\Model\Manager\ArticleManager;

class ArticleController extends AbstractController
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    /**
     * Add method from API.
     * @return void
     */
    public function addArticle()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);

        // On quitte si tous les paramètres ne sont pas la...
        if(empty($payload->title) || empty($payload->content)) {
            // 400 = Bad Request.
            http_response_code(400);
            exit;
        }

        // On quitte si l'utilisateur n'est pas connecté !
        if(!self::isUserConnected()) {
            // 403 = Non autorisé.
            http_response_code(403);
            exit;
        }

        // On nettoye les données.
        $title = $this->sanitizeString($payload->title);
        $content = $this->sanitizeString($payload->content);

        $user = self::getConnectedUser();
        $article = new Article();
        $article->setTitle($title);
        $article->setContent($content);
        $article->setAuthor($user);

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
    }
}