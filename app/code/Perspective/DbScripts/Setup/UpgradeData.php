<?php
namespace Perspective\DbScripts\Setup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
class UpgradeData implements UpgradeDataInterface
{
    protected $_postFactory;
    public function __construct
    (\Perspective\DbScripts\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.3.0', '<')) {
            for ($i=2; $i<6; $i++){
                $data = [
                    'name' => "Post ".$i,
                    'post_content' => "TestPost ".$i,
                    'url_key' => '/magento-2-module-development
/magento-2-post '.$i.'.html',
                    'tags' => 'magento 2, post '.$i,
                    'status' => 1,
                    'test' => 'testPost '.$i,
                ];
                $post = $this->_postFactory->create();
                $post->addData($data)->save();
            }
        }
    }
}
