<?php

namespace App\Controller;

use App\Repository\NewsRepository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repos)
    {
        
        return $this->render('news/home/index.html.twig', [
            'postsLatest'   =>$repos->findLatest(),
            'postGlobal'    =>$repos->findByGlobal()
        ]);
    }
}
