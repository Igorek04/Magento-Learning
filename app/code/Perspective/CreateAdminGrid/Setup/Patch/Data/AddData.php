<?php
namespace Perspective\CreateAdminGrid\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Perspective\CreateAdminGrid\Model\PostFactory;
use Perspective\CreateAdminGrid\Model\ResourceModel\Post;

class AddData implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var PostFactory 
     */
    private PostFactory $postFactory;

    /**
     * @var Post 
     */
    private Post $postResource;

    /**
     * @var ModuleDataSetupInterface 
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * Constructor
     *
     * @param PostFactory $postFactory
     * @param Post $postResource
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        PostFactory $postFactory,
        Post $postResource,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        for ($i = 1; $i < 30; $i++) {
            $postDTO = $this->postFactory->create();
            $postDTO->setPostName("Post_$i")
                ->setUrlKey("Post_$i")
                ->setPostContent("Post_$i content")
                ->setPostTags("Tag_$i")
                ->setPostStatus("Status_$i")
                ->setFeaturedImage("Image_$i")
                ->setCreatedAt("2022-01-10 00:00:00")
                ->setUpdatedAt("2022-01-31 00:00:00");
            $this->postResource->save($postDTO);
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return '1.0.3';
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
