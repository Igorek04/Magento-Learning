<?php
namespace Perspective\BDScriptPractice\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Perspective\BDScriptPractice\Model\PostFactory;

class InstallData implements InstallDataInterface
{
	protected $_postFactory;

	public function __construct(PostFactory $postFactory)
	{
		$this->_postFactory = $postFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$data = [
			'name' => "How to Create SQL Setup Script in Magento 2",
			'post_content' => "In this article, we will find out how to install and upgrade sql script for module in Magento 2",
			'url_key' => '/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html',
			'tags' => 'magento 2,perspective helloworld',
			'status' => 1
		];

		$post = $this->_postFactory->create();
		$post->addData($data)->save();
	}
}
