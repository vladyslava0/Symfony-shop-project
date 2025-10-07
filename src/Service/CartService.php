<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function getCart(): array
    {
        return $this->session->get('cart', []);
    }

    public function addToCart(int $itemId): void
    {
        $cart = $this->getCart();
        if (!isset($cart[$itemId])) {
            $cart[$itemId] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        $cart = $this->getCart();
        if (isset($cart[$itemId])) {
            $cart[$itemId] = $quantity;
            $this->session->set('cart', $cart);
        }
    }

    public function removeFromCart(int $itemId): void
    {
        $cart = $this->getCart();
        unset($cart[$itemId]);
        $this->session->set('cart', $cart);
    }

    public function clearCart(): void
    {
        $this->session->set('cart', []);
    }
}
