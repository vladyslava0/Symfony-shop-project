<?php

namespace App\Controller;

use App\Service\CartService;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog', name: 'app_catalog')]
    public function index(ItemRepository $itemRepository, CartService $cartService): Response
    {
        $items = $itemRepository->findBy([], ['name' => 'ASC']);
        $cartItems = $cartService->getCart();

        return $this->render('catalog/index.html.twig', [
            'items' => $items,
            'cartItems' => $cartItems,
        ]);
    }
}
