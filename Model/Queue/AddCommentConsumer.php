<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderComment\Model\Queue;

use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Consumer for processing order comment messages from the queue.
 */
class AddCommentConsumer
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private LoggerInterface $logger
    ) {}

    /**
     * Handles the queue message and adds a comment to the order.
     *
     * @param int $orderId Order ID from the queue
     * @return void
     */
    public function process(int $orderId): void
    {
        try {
            $order = $this->orderRepository->get($orderId);
            $order->addCommentToStatusHistory('comment temp', false, true);
            $this->orderRepository->save($order);
        } catch (\Exception $e) {
            $this->logger->error('Error adding comment: ' . $e->getMessage());
        }
    }
}
