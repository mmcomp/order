<?php
// src/Controller/OrderController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", methods={"GET"})
    */
    public function getOrder(): Response
    {
        $session = new Session();
        $session->start();
        $orders = $session->get('orders');
        if($orders===null) {
            $orders = [];
            $session->set('orders', '[]');
        }else {
            $orders = json_decode($orders, true);
        }
        // var_dump($orders);
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
        return $this->render('order/index.html.twig');
    }

    /**
     * @Route("/order", methods={"POST"})
    */
    public function addOrder(): Response
    {
        $request = Request::createFromGlobals();
        $products_id = $request->request->post("products_id");
        // $session = new Session();
        // $session->start();
        // $orders = $session->get('orders');
        // if($orders===null) {
        //     $orders = [];
        //     $session->set('orders', '[]');
        // }else {
        //     $orders = json_decode($orders, true);
        // }
        // // var_dump($orders);
        // return $this->render('order/index.html.twig');
    }
}