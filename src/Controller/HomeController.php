<?php

namespace App\Controller;

use App\Repository\NewsRepository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repos):Response
    {
        $this->data=[];
        return $this->render('news/home/index.html.twig', [
            'postsLatest'   =>$repos->findLatest(),
            'postGlobal'    =>$repos->findByGlobal()
        ]);
    }
}
