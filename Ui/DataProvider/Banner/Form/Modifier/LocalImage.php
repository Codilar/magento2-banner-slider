<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Ui\DataProvider\Banner\Form\Modifier;

use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class LocalImage implements ModifierInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Mime
     */
    private $mime;

    /**
     * LocalImage constructor.
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Mime $mime
     */
    public function __construct(
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Mime $mime
    )
    {
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
        $this->mime = $mime;
    }

    /**
     * @param array $data
     * @return array
     * @since 100.1.0
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function modifyData(array $data)
    {
        foreach ($data as &$item) {
            $item = $this->processRow($item);
        }
        return $data;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function processRow($data) {
        $resourcePath = $data['resource_path'] ?? null;
        $resourceType = $data['resource_type'];
        if ($resourcePath && $resourceType === 'local_image') {
            /** @var \Magento\Store\Model\Store $store */
            $store = $this->storeManager->getStore();
            $url = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $resourcePath;
            $fileName = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath($resourcePath);
            if (file_exists($fileName)) {
                $resourcePathData = [
                    'name' => basename($fileName),
                    'url' => $url,
                    'size' => filesize($fileName),
                    'type' => $this->mime->getMimeType($fileName)
                ];
                unset($data['resource_path']);
                $data['resource_path_local_image'][0] = $resourcePathData;
            }
        }
        return $data;
    }

    /**
     * @param array $meta
     * @return array
     * @since 100.1.0
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}