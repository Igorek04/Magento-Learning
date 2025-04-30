<?php

namespace Perspective\SchemaPatch\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Change a column 'body' -> 'content' from 'intray_table2' table.
 */
class ChangeColumn implements SchemaPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Сonstructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $this->moduleDataSetup->getConnection()->changeColumn(
            $this->moduleDataSetup->getTable('intray_table2'),
            'body',
            'content',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 10,
                'nullable' => true,
                'comment' => 'Contents'
            ]
        );

        $this->moduleDataSetup->endSetup();
    }
}