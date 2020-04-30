<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Property;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{ 
   
    
    /**
     * @Route("/login",name="login")
     */
    public function login()
    {
        
        return $this->render('security/login.html.twig'
        );
    }
    /**
     * @Route("/logout",name="logout")
     */
    public function logout()
    {
    }
    
     /**
     * @Route("/inscription",name="security_registration")
     */
    public function registration(Request $request,ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user=new User();
        $form=$this->createForm(\App\Form\RegistrationType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
         $manager->persist($user);

         $manager->flush();
         $this->redirectToRoute('login');
        }
        
        
        return $this->render('security/registration.html.twig',[
            'form'=>$form->createView()]
                );
    }
}

