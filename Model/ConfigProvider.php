<?php
declare(strict_types=1);

namespace RecruitmentTasks\OrderComment\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class ConfigProvider
 *
 * Provides access to module configuration values from admin panel.
 */
class ConfigProvider
{
    /**
     * XML path to order comment text configuration.
     */
    private const XML_PATH_COMMENT_TEXT = 'catalog/ordercomment_settings/comment_text';

    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {}

    /**
     * Returns the configured order comment text.
     *
     * @return string
     */
    public function getOrderCommentText(): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_COMMENT_TEXT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
