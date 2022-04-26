<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends CustomerController
{
    private $articleRepo;
    private $categoryRepo;

    public function __construct(ArticleRepository $articleRepo, CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->articleRepo = $articleRepo;
        parent::__construct($categoryRepo);
    }

    //
    public function index()
    {
        $countArticle = $this->articleRepo->getAll()->count();

        $checkLink = 0;
        if ($countArticle > 7) {
            $articles = $this->articleRepo->findByStatus('1', 6);
            $checkLink = 1;
        } else {
            $articles = $this->articleRepo->findByStatus('1');
        }

        $data = [
            'articles' => $articles,
            'checkLink' => $checkLink
        ];

        return view('customer.article.index',$data);
    }

    public function getDetailArticle($id)
    {
        $articles = $this->articleRepo->getAnother($id, 5);
        $article = $this->articleRepo->find($id);

        $data = [
            'article' => $article,
            'articles' => $articles
        ];

        return view('customer.article.detail',$data);
    }
}
