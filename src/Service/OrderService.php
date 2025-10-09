<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ItemRepository $itemRepository
    ) {}

    public function createOrderFromCart(array $cart, $user): void
    {
        $order = new Order();
        $order->setUser($user);
        $order->setDate(new \DateTime());

        $itemIds = array_keys($cart);
        $items = $this->itemRepository->findBy(['id' => $itemIds]);
        $itemMap = [];
        foreach ($items as $item) {
            $itemMap[$item->getId()] = $item;
        }

        foreach ($cart as $itemId => $qty) {
            if (isset($itemMap[$itemId]) && $itemMap[$itemId]->getQuantity() >= $qty) {
                $item = $itemMap[$itemId];

                $orderItem = new OrderItem();
                $orderItem->setItem($item);
                $orderItem->setQuantityOrdered($qty);
                $orderItem->setPrice($item->getPrice());
                $orderItem->setBelongToOrder($order);

                $this->entityManager->persist($orderItem);

                $item->setQuantity($item->getQuantity() - $qty);
                $this->entityManager->persist($item);
            }
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
