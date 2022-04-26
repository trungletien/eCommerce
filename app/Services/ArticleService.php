<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService 
{
    public $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }
}