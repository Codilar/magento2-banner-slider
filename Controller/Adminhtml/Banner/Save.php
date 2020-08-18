<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Controller\Adminhtml\Banner;

use Codilar\BannerSlider\Api\BannerRepositoryInterface;
use Codilar\BannerSlider\Model\Banner\ResourcePath\ProcessorPool;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\CacheInterface;
use Magento\PageCache\Model\Cache\Type as PageCache;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Codilar_BannerSlider::banner';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;
    /**
     * @var ProcessorPool
     */
    private $processorPool;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param BannerRepositoryInterface $bannerRepository
     * @param DataPersistorInterface $dataPersistor
     * @param ProcessorPool $processorPool
     * @param PageRepositoryInterface $pageRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param CacheInterface $cacheManager
     */
    public function __construct(
        Action\Context $context,
        BannerRepositoryInterface $bannerRepository,
        DataPersistorInterface $dataPersistor,
        ProcessorPool $processorPool,
        PageRepositoryInterface $pageRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        PageCache $pageCache,
        CacheInterface $cacheManager
    )
    {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->bannerRepository = $bannerRepository;
        $this->processorPool = $processorPool;
        $this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->pageCache = $pageCache;
        $this->cacheManager = $cacheManager;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        try {
            if ($id) {
                $model = $this->bannerRepository->loadById($id);
            } else {
                $model = $this->bannerRepository->create();
            }
            $this->populateModelWithData($model, [
                'slider_id',
                'title',
                'resource_map_id',
                'resource_type',
                'alt_text',
                'link',
                'sort_order',
                'is_enabled'
            ]);
            $resourcePathProcessors = $this->processorPool->getProcessors();
            if (isset($resourcePathProcessors[$model->getResourceType()])) {
                try {
                    $model->setResourcePath($resourcePathProcessors[$model->getResourceType()]->process($this->getRequest()));
                } catch (LocalizedException $e) {
                    $this->dataPersistor->set('bannerslider_banner', $model->getData());
                    throw new CouldNotSaveException(__($e->getMessage()));
                }
            }
            $this->dataPersistor->set('bannerslider_banner', $model->getData());
            $model = $this->bannerRepository->save($model);
            $this->dataPersistor->clear('bannerslider_banner');
            $this->messageManager->addSuccessMessage(__('Banner %1 saved successfully', $model->getEntityId()));
            switch ($this->getRequest()->getParam('back')) {
                case 'continue':
                    $url = $this->getUrl('*/*/edit', ['entity_id' => $model->getEntityId()]);
                    break;
                case 'close':
                    $url = $this->getUrl('*/*');
                    break;
                default:
                    $url = $this->getUrl('*/*');
            }

            $this->cleanCmsPagesCache($model->getData('slider_id'));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $url = $this->getUrl('*/*');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $url = $this->getUrl('*/*/edit', ['entity_id' => $id]);
        }
        return $this->resultRedirectFactory->create()->setUrl($url);
    }

    /**
     * @param \Magento\Framework\DataObject $model
     * @param string[] $fields
     */
    protected function populateModelWithData($model, $fields)
    {
        foreach ($fields as $field) {
            $model->setData($field, $this->getRequest()->getParam($field));
        }
    }

    /**
     * Clean all the CMS Pages which contain this specific slider_id
     *
     * @param int $slider_id
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function cleanCmsPagesCache(int $slider_id)
    {
        $pages = $this->getPagesToPurge($slider_id);
        $pagesIds = array();
        foreach ($pages->getItems() as $page) {
            $pagesIds[] = $page->getId();
        }

        $this->cacheManager->clean($this->getCacheTags($pagesIds));
        $this->pageCache->clean(\Zend_Cache::CLEANING_MODE_MATCHING_TAG, $this->getCacheTags($pagesIds));
    }

    /**
     * Retrieves the pages that have to be purged from cache
     *
     * @param $slider_id
     * @return \Magento\Cms\Api\Data\PageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getPagesToPurge($slider_id)
    {
        $contentFilter = $this->filterBuilder
            ->setField('content')
            ->setValue('%slider_id="' . $slider_id . '"%')
            ->setConditionType('like')
            ->create();

        $this->searchCriteriaBuilder->addFilters([$contentFilter]);

        $criteria = $this->searchCriteriaBuilder->create();
        $pages = $this->pageRepositoryInterface->getList($criteria);

        return $pages;
    }

    /**
     * Return cache tags to flush
     *
     * @param array $pagesIds
     * @return array
     */
    public function getCacheTags(array $pagesIds)
    {
        $tags = array();
        foreach ($pagesIds as $pagesId) {
            $tags[] = \Magento\Cms\Model\Page::CACHE_TAG . '_' . $pagesId;
        }

        return $tags;
    }
}
