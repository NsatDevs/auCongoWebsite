<?php
namespace  App\Controller\NewsController;

use App\Entity\NewsEntity\Post;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
     * @Route("/news")
*/
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
     * @Route("/{name}", name="post_cat")
     */
    
    public function getByCategory(string $name,Request $request,PostRepository $repos)
    {
         $this->data=
         [
            'page'=>$request->query->get('page',1),
            'number'=>12,
            'name' =>$name
        ];
        $posts=$repos->searchPostByCategory($this->data);
        return $this->render('news/category/index.html.twig', [
            'posts' => $posts,
        ]);
       
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
