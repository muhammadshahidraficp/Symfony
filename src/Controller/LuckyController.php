<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserRegister;
use Symfony\Component\HttpFoundation\JsonResponse;


class LuckyController extends AbstractController
{

    /**
      * @Route("/success",name="success")
      */
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);

    }

    /**
     * @Route("/register", name="signup")
     */
    public function register(Request $request)
    {
        
        $request_data = $request->request->all();
        //print_r($request_data);
        if(isset($request_data['email']) && isset($request_data['name']) && isset($request_data['mobile']) && isset($request_data['password']))
        //print_r($request_data);
        {
          $email = $request_data['email'];
          $name = $request_data['name'];
          $mobile = $request_data['mobile'];
          $password = $request_data['password'];
          //echo $email;
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)

        $entityManager = $this->getDoctrine()->getManager();

        $user = new UserRegister();
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($password);
        //$user->setPassword($hashed_password);
        $user->setMobile($mobile);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('success');
      }
        //$posts = $entityManager->getRepository('App:UserRegister')->findAll();

        //print_r($posts);


   return $this->render('registration/register.html.twig');

    }


    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
      $request_data = $request->request->all();
      if(isset($request_data['email']) && isset($request_data['password'])){
      $email = $request_data['email'];
      $password = $request_data['password'];

      //print_r($request_data);
      $logindata = $this->getDoctrine()->getRepository('App:UserRegister')->findOneBy(['email'=>$email,'password'=>$password]);
      if(isset($logindata)){
        return $this->render('home/home.html.twig');  
      }
      else{
       return $this->render('lucky/number.html.twig'); 
      }
    }
    return $this->render('lucky/number.html.twig'); 

}


/**
     * @Route("/validate", name="validate")
     */
    public function validate(Request $request)
    {
      $email=$request->get('email');
      $mobile=$request->get('mobile');
      //print_r($mobile);
      $emailcheck = $this->getDoctrine()->getRepository('App:UserRegister')->findOneBy(['email'=>$email]);
      $mobilecheck = $this->getDoctrine()->getRepository('App:UserRegister')->findOneBy(['mobile'=>$mobile]);
      if($emailcheck){
        $returnData['exist'] = 1;
        //print_r($returnData);
        //return $returnData;
        
      }
      else
      $returnData['exist'] = 0;
      //print_r($returnData);exit;
      
    if($mobilecheck){
      $returnData['mobile'] = 1;
    }
    else
      $returnData['mobile'] = 0;
return new JsonResponse($returnData);
}
}




