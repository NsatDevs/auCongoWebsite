<?php
namespace  App\Controller\NewsController;

use App\Repository\NewsRepository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index")
     */
    public function index(PostRepository $repos)
    {
        return $this->render('news/posts/index.html.twig',['posts'=>$repos->findAll()]);
    }
}
