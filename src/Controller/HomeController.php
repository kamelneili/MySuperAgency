<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route ;
class HomeController  extends AbstractController
{
    
    /**
     * @Route("/", methods={"GET","POST"}, name="home")
     */
    public function index(\App\Repository\PropertyRepository $repository)
    {
        $properties=$repository->findLatest();
        return $this->render('home.html.twig',['properties'=>$properties]);
       // return $this->render('home.html.twig');

    }
    /**
     * @Route("/api/getposts/{offset?}", methods={"GET"})
     */
    public function getPosts(\App\Repository\PropertyRepository $repository)
    {
          $properties=$repository->findLatest();

        return $this->render('home.html.twig',['properties'=>$properties]);
      return $this->json([
           'posts'=>$repository->getPosts(),
           'totals' => $repository->getCountPosts()
       ]);
    }
}

