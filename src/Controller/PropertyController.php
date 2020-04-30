<?php
namespace App\Controller;
use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{ 
    private $repository;
    private $em;
    public function __construct(\App\Repository\PropertyRepository $repository
            ) {
       $this->repository=$repository ;
       
    }
    public function index(PaginatorInterface $paginator,  Request $request)
    {
        $search=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        
        
        
        $properties=$paginator->paginate(
                $this->repository->findAllVisible($search),
                $request->query->getInt('page', 1),12
                );
                          
        return $this->render('property/index.html.twig',['properties'=>$properties,
            'form'=>$form->createView()]
                );
    }
    /**
     * @Route("/biens/{slug}-{id}",name="property.show",requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug,$id, Request $request, ContactNotification $notification)
    {
                $property=$this->repository->find($id);

       $contact = new Contact();
       $contact->setProperty($property);
       $form=$this->createForm(ContactType::class,$contact);
       $form->handleRequest($request);
       if($form->isSubmitted()&& $form->isValid())
       {
           $notification->notify($contact);
           $this->addFlash('success','votre email a été bien envoyé');
           return $this->redirectToRoute('property.show',[
               'id'=>$property->getId(),
               'slug'=>$property->getSlug()
           ]);
       }
        return $this->render('property/show.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()]);
    }
    
}

