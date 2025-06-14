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
        try {
            $order = $observer->getEvent()->getOrder();
            if ($order && $order->getId()) {
                $this->publisher->publish((int) $order->getId());
            }
        } catch (\Throwable $e) {
            $this->logger->error('Error while sending order ID to queue: ' . $e->getMessage());
        }
    }
}
