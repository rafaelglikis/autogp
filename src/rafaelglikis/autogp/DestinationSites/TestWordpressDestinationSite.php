<?php

namespace rafaelglikis\autogp\DestinationSites;
use rafaelglikis\autogp\Datatypes\Article;

class TestWordpressDestinationSite extends WordpressDestinationSite
{
    public function __construct($wpPath)
    {
        parent::__construct($wpPath);
    }

    public function insertPost(string $title, string $imageUrl, string $content, string $status, $categoryIds = WordpressDestinationSite::UNCATEGORIZED)
    {
        parent::insertPost($title, $imageUrl, $content, $status, $categoryIds);

        return [
            "title" => $title,
            "image_url" => $imageUrl,
            "content" => $content,
            "status" => $status,
            "category_ids" =>$categoryIds
        ];
    }

    public function insertPublishedPost(string $title, string $imageUrl, string $content, $categoryIds = WordpressDestinationSite::UNCATEGORIZED)
    {
        parent::insertPost($title, $imageUrl, $content, "published", $categoryIds);

        return [
            "title" => $title,
            "image_url" => $imageUrl,
            "content" => $content,
            "status" => "published",
            "category_ids" =>$categoryIds
        ];
    }

    public function insertDraftPost(string $title, string $imageUrl, string $content, $categoryIds = WordpressDestinationSite::UNCATEGORIZED)
    {
        parent::insertPost($title, $imageUrl, $content, "draft", $categoryIds);

        return [
            "title" => $title,
            "image_url" => $imageUrl,
            "content" => $content,
            "status" => "draft",
            "category_ids" =>$categoryIds
        ];
    }

    public function insertPublishedArticle(Article $article, $categories = null)
    {
        parent::insertPublishedArticle($article, $categories);
        if ($categories===null) $categories = $article->getDestinationCategories();

        return [
            "title" => $article->getTitle(),
            "image_url" => $article->getImgUrl(),
            "content" => $article->getContent(),
            "status" => "published",
            "category_ids" => $categories
        ];
    }

    public function insertDraftArticle(Article $article, $categories = null)
    {
        parent::insertDraftArticle($article, $categories);
        if ($categories===null) $categories = $article->getDestinationCategories();

        return [
            "title" => $article->getTitle(),
            "image_url" => $article->getImgUrl(),
            "content" => $article->getContent(),
            "status" => "draft",
            "category_ids" => $categories
        ];
    }
}