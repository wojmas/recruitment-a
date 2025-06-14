<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderComment\Model\Queue;

use Magento\Framework\MessageQueue\PublisherInterface;

/**
 * Publishes order IDs to the message queue topic for adding comments to orders.
 */
class AddCommentPublisher
{
    public function __construct(
        private PublisherInterface $publisher
    ) {}

    /**
     * Publishes the given order ID to the queue topic.
     *
     * @param int $orderId The order ID to publish
     * @return void
     */
    public function publish(int $orderId): void
    {
        $this->publisher->publish('ordercomment.order.add_comment', $orderId);
    }
}
