<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderComment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use RecruitmentTasks\OrderComment\Model\Queue\AddCommentPublisher;

/**
 * Observer that publishes the order ID to the queue after an order is placed.
 */
class PublishOrderToQueue implements ObserverInterface
{

    public function __construct(
        private AddCommentPublisher $publisher,
        private LoggerInterface $logger

    ) {}

    /**
     * Publishes the order ID to the queue after the order is placed.
     *
     * @param Observer $observer Event observer containing the order
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $order = $observer->getEvent()->getOrder();
        $this->logger->error('Wysyłanie ID zamówienia do kolejki: ' . $order->getId());
        if ($order && $order->getId()) {
            $this->publisher->publish((int) $order->getId());
            $this->logger->error('Wysłano');
        }
    }
}
