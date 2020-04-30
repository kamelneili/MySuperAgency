<?php
namespace App\Controller\Admin;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
class AdminPropertyController extends AbstractController
{ 
    private $repository;
    private $em;
    
    public function __construct(\App\Repository\PropertyRepository $repository, ObjectManager $em
            ) {
       $this->repository=$repository ;
       $this->em=$em;
    }
    /**
     * @Route("/admin",name="admin.property.index")
     */

    public function index()
    {
        $properties=$this->repository->findAll();
                          
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }
    /**
     * @Route("/admin/property/create",name="admin.property.create")
     */

    public function create(Request $request)
    {
         $property=new Property();
        $form=$this->createForm(PropertyType::class,$property);          
         $files=$request->files;
         
        $form->handleRequest($request);
        //var_dump($files);die();

         if($form->isSubmitted()&&$form->isValid()){
             
            $files=$request->files->get('property')['images'];
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
                 $image->setProperty($property);
                 $property->addImage($image);
             $this->em->persist($image);
        
             }
        
             $this->em->persist($property);
        
                 $this->em->flush();
                              $this->addFlash('success','bien crée avec succes');
        

             return $this->redirectToRoute('admin.property.index');
         }
        return $this->render('admin/property/create.html.twig',['property'=>$property,
                                                               'form'=>$form->createView()]);
    }
    
    /**
     * @Route("/admin/property/{id}",name="admin.property.edit",methods="GET|POST")
     */

    public function edit(Property $property,Request $request)
    {
        $properties=$this->repository->findAll();
         $form=$this->createForm(PropertyType::class,$property);  
         $form->handleRequest($request);
         if($form->isSubmitted()&&$form->isValid()){
             $this->em->flush();
             $this->addFlash('success','bien modifié avec succes');
             return $this->redirectToRoute('admin.property.index');
         }
        return $this->render('admin/property/edit.html.twig',['property'=>$property,
                                                               'form'=>$form->createView()]);
    }
    /**
     * @Route("/admin/property/{id}",name="admin.property.delete",methods="DELETE")
     */
     public function delete(Property $property)
    {
     $this->em->remove($property);
     $this->em->flush();
                  $this->addFlash('success','bien supprimé avec succes');

             return $this->redirectToRoute('admin.property.index');
         }
    
}

