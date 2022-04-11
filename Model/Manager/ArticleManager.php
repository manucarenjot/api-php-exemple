<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Article;
use DateTime;

class ArticleManager
{
    public const TABLE = 'article';

    /**
     * Return all users.
     * @return array
     */
    public function findAll(): array
    {
        $articles = [];
        $query = DB::getPDO()->query("SELECT * FROM " . self::TABLE);
        if($query) {
            $userManager = new UserManager();
            $format = 'Y-m-d H:i:s';

            foreach($query->fetchAll() as $articleData) {
                $articles[] = (new Article())
                    ->setId($articleData['id'])
                    ->setAuthor($userManager->getUser($articleData['user_fk']))
                    ->setContent($articleData['content'])
                    ->setDateAdd(DateTime::createFromFormat($format, $articleData['date_add']))
                    ->setDateUpdate(DateTime::createFromFormat($format, $articleData['date_update']))
                    ->setTitle($articleData['title'])
                ;
            }
        }

        return $articles;
    }


    /**
     * Add a new article into the db.
     * @param Article $article
     * @return void
     */
    public static function addNewArticle(Article &$article): bool
    {
        $stmt = DB::getPDO()->prepare("
            INSERT INTO ". self::TABLE ." (title, content, user_fk) VALUES (:title, :content, :author)
        ");

        $stmt->bindValue(':title', $article->getTitle());
        $stmt->bindValue(':content', $article->getContent());
        $stmt->bindValue(':author', $article->getAuthor()->getId());

        $result = $stmt->execute();
        $article->setId(DB::getPDO()->lastInsertId());
        return $result;
    }
}








