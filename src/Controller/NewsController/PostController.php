<?php
namespace  App\Controller\NewsController;

use App\Entity\NewsEntity\Post;
use Symfony\Component\Routing\Annotation\Route;
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

     /**
     * @Route("/article/{slug}-{id}", name="post_show", requirements={"slug":"[a-z0-9\-]*"})
     */
    public function show(Post $post, string $slug)
    {
        if ($post->getSlug()!=$slug) {
            return $this->redirectToRoute('post_show',['id'=>$post->getId,'slug'=>$post->getSlug],301);
            # code...
        }
        return $this->render('news/posts/show.html.twig',compact('post'));
    }
}
