<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderComment\Model\Queue;

use RecruitmentTasks\OrderComment\Model\OrderCommentService;

/**
 * Queue consumer responsible for adding a comment to an order.
 */
class AddCommentConsumer
{
    public function __construct(
        private OrderCommentService $orderCommentService
    ) {}

    /**
     * Processes the queue message and adds a comment to the order.
     *
     * @param int $orderId Order ID
     * @return void
     */
    public function process(int $orderId): void
    {
        $this->orderCommentService->addComment($orderId);
    }
}
