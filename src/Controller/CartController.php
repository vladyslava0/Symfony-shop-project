<?php

namespace App\Controller;

use App\Service\CartService;
use App\Service\OrderService;
use App\Repository\ItemRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function view(CartService $cartService, ItemRepository $itemRepository, OrderRepository $orderRepository): Response
    {
        $cart = $cartService->getCart();
        $items = [];
        $total = 0;

        $itemIds = array_keys($cart);
        $itemsDB = $itemRepository->findBy(['id' => $itemIds]);
        $itemMap = [];
        foreach ($itemsDB as $item) {
            $itemMap[$item->getId()] = $item;
        }

        foreach ($cart as $id => $qty) {
            if (isset($itemMap[$id])) {
                $item = $itemMap[$id];
                $items[] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'available' => $item->getQuantity(),
                    'quantity' => $qty,
                    'subtotal' => $item->getPrice() * $qty,
                ];
                $total += $item->getPrice() * $qty;
            }
        }

        $orders = $orderRepository->findBy(['user' => $this->getUser()], ['date' => 'DESC']);

        return $this->render('cart/index.html.twig', [
            'items' => $items,
            'total' => $total,
            'orders' => $orders,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(int $id, CartService $cartService): Response
    {
        $cartService->addToCart($id);
        return $this->redirectToRoute('app_catalog');
    }

    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(int $id, Request $request, CartService $cartService): Response
    {
        $quantity = (int) $request->request->get('quantity');
        $cartService->updateQuantity($id, $quantity);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id, CartService $cartService): Response
    {
        $cartService->removeFromCart($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/checkout', name: 'cart_checkout')]
    public function checkout(CartService $cartService, OrderService $orderService): Response
    {
        $cart = $cartService->getCart();
        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        $orderService->createOrderFromCart($cart, $this->getUser());
        $cartService->clearCart();

        return $this->redirectToRoute('app_cart');
    }
}
