<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="products")
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/add", name="addproduct")
    */
    public function new(Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $imagePath = $form['image_path']->getData();
            $extension = $imagePath->guessExtension();
            $webPath = $this->getParameter('kernel.project_dir') . '/public/img/';
            $fileName = time() . '.' . $extension;
            $imagePath->move($webPath, $fileName);
            $product->setImagePath('/img/' . $fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/search", name="searchproduct")
    */
    public function searchProduct(Request $request): Response
    {
        $q = $request->query->get('term'); // use "term" instead of "q" for jquery-ui
        $results = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('order/product.json.twig', ['results' => $results]);
    }

    /**
     * @Route("/product/get", name="getproduct")
    */
    public function getProduct(Request $request): Response
    {
        $id = $request->query->get('id');
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->json($product->getName());
    }
}
