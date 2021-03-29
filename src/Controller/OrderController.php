<?php
// src/Controller/OrderController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\OrderType;
use App\Form\OrderItemType;

class OrderController extends AbstractController
{
    /**
     * @Route("/order_item", name="orderItems")
     */
    public function index(): Response
    {
        $orderItems = $this->getDoctrine()
            ->getRepository(OrderItem::class)
            ->findAll();

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'orderItems' => $orderItems
        ]);
    }

    /**
     * @Route("/order_item/add", name="addOrderItem")
    */
    public function new(Request $request): Response
    {
        $orderItem = new OrderItem();

        $form = $this->createForm(OrderItemType::class, $orderItem);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $orderItem = $form->getData();

            // $imagePath = $form['image_path']->getData();
            // $extension = $imagePath->guessExtension();
            // $webPath = $this->getParameter('kernel.project_dir') . '/public/img/';
            // $fileName = time() . '.' . $extension;
            // $imagePath->move($webPath, $fileName);
            // $product->setImagePath('/img/' . $fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderItem);
            $entityManager->flush();

            return $this->redirectToRoute('orderItems');
        }

        return $this->render('order/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}