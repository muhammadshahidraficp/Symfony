<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserRegister;


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
     * @Route("/register")
     */
    public function register(Request $request)
    {
        
        $request_data = $request->request->all();
        print_r($request_data);
        if(isset($request_data['email']) && isset($request_data['name']))
        //print_r($request_data);
        {
          $email = $request_data['email'];
          $name = $request_data['name'];
          echo $email;
        

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)

        $entityManager = $this->getDoctrine()->getManager();

        $user = new UserRegister();

        $user->setEmail($email);
        $user->setName($name);


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

}


