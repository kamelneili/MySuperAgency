<?php
namespace App\Controller\Admin;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;
use App\Entity\Image;

use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
class AdminPostController extends AbstractController
{ 
    private $repository;
    private $em;
    
    public function __construct(\App\Repository\PostRepository $repository, ObjectManager $em
            ) {
       $this->repository=$repository ;
       $this->em=$em;
    }
   
     /**
     * @Route("/post/{id}",name="post.show",requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Post $post)
    {
              
        return $this->render('post/show.html.twig',[
            'post'=>$post]);
    }
    
    /**
     * @Route("/admin",name="admin.post.index")
     */

    public function index()
    {
        $posts=$this->repository->findAll();
                          
        return $this->render('admin/post/index.html.twig',compact('posts'));
    }
    /**
     * @Route("/admin/post/create",name="admin.post.create")
     */

    public function create(Request $request)
    {
         $post=new Post();
        $form=$this->createForm(PostType::class, $post);          
         
        $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){
             
         $files=$request->files->get('post')['images'];
        // var_dump($files);die();
         foreach($files as $file){

             $image= new Image();
             $filename= md5(uniqid()) . $file->guessExtension();
             $image->setFilename($filename);
             $image->setPath(
                 '/uploads/' .$filename
             );
             $file->move(
                 $this->getParameter('uploads'),$filename
             );
             $image->setPost($post);
             $post->addImage($image);
         $this->em->persist($image);

         }

         $this->em->persist($post);

             $this->em->flush();
                          $this->addFlash('success','bien crée avec succes');

             return $this->redirectToRoute('admin.post.index');
         }
        return $this->render('admin/post/create.html.twig',['post'=>$post,
                                                               'form'=>$form->createView()]);
    }
   
}

