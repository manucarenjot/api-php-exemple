<?php

namespace App\Controller;

use App\Config;
use App\Model\Entity\Article;
use App\Model\Manager\ArticleManager;
use App\Model\Manager\UserManager;

class ArticleController extends AbstractController
{

    public function index()
    {
        // mon commentaire qui m'a pris du temsp à écrire.
    }

    public function listAllArticles()
    {

    }

    /**
     * Route to add a new article.
     * @return void
     */
    public function addArticle()
    {
        self::redirectIfNotConnected();

        if($this->isFormSubmitted()) {
            // Admettons que ce user ait été pris depuis la session.
            $user = UserManager::getUser(1); // ATTENTION => Fake user -> normalement, il vient de la session

            // Getting Article data from form.
            $title = $this->sanitizeString($this->getFormField('title'));
            $content = $this->sanitizeString($this->getFormField('content'));

            // Create a new Article entity (no persisted).
            $article = new Article();
            $article
                ->setTitle($title)
                ->setContent($content)
                ->setAuthor($user)
            ;

            // Saving new article.
            if(ArticleManager::addNewArticle($article)) {
                $this->render('article/show-article', [
                    'article' => $article,
                ]);
            }
        }

        $this->render('article/add-article');
    }


}























