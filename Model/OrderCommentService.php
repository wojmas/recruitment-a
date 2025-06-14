<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderComment\Model;

use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class OrderCommentService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private LoggerInterface $logger,
        private ConfigProvider $config
    ) {}

    /**
     * Adds a comment to the order with the given ID.
     *
     * @param int $orderId
     * @return void
     */
    public function addComment(int $orderId): void
    {
        try {
            $order = $this->orderRepository->get($orderId);
            $comment = $this->config->getOrderCommentText();
            $order->addCommentToStatusHistory($comment, false, true);
            $this->orderRepository->save($order);
        } catch (\Exception $e) {
            $this->logger->error('Error while adding comment to order: ' . $e->getMessage());
        }
    }
}
