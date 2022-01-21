<?php

namespace Magenest\DeliveryTime\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Class UpgradeSchema
 * @package Magenest\DeliveryTime\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection->addColumn($setup->getTable('quote'), 'mp_delivery_information', [
                'type'    => Table::TYPE_TEXT,
                'visible' => false,
                'comment' => 'Magenest Delivery Time'
            ]);
        }

        $setup->endSetup();
    }
}
