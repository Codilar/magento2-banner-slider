<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Controller\Adminhtml\Slider;


use Codilar\BannerSlider\Api\SliderRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\DataObject;
use Magento\PageCache\Model\Cache\Type as PageCache;
use Magento\Cms\Api\Data\PageSearchResultsInterface;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Codilar_BannerSlider::slider';

    /**
     * @var SliderRepositoryInterface
     */
    private $sliderRepository;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepositoryInterface;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var PageCache
     */
    private $pageCache;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param SliderRepositoryInterface $sliderRepository
     * @param DataPersistorInterface $dataPersistor
     * @param PageRepositoryInterface $pageRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param PageCache $pageCache
     */
    public function __construct(
        Action\Context $context,
        SliderRepositoryInterface $sliderRepository,
        DataPersistorInterface $dataPersistor,
        PageRepositoryInterface $pageRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        PageCache $pageCache
    )
    {
        parent::__construct($context);
        $this->sliderRepository = $sliderRepository;
        $this->dataPersistor = $dataPersistor;
        $this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->pageCache = $pageCache;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        try {
            if ($id) {
                $model = $this->sliderRepository->loadById($id);
            } else {
                $model = $this->sliderRepository->create();
            }
            $this->populateModelWithData($model, [
                'title',
                'is_show_title',
                'is_enabled'
            ]);
            $this->dataPersistor->set('bannerslider_slider', $model->getData());
            $model = $this->sliderRepository->save($model);
            $this->cleanCmsPagesCache($id);
            $this->dataPersistor->clear('bannerslider_slider');
            $this->messageManager->addSuccessMessage(__('Slider %1 saved successfully', $model->getEntityId()));
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
     * @param DataObject $model
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
     * @throws LocalizedException
     */
    protected function cleanCmsPagesCache(int $slider_id)
    {
        $pages = $this->getPagesToPurge($slider_id);
        $pagesIds = array();
        foreach ($pages->getItems() as $page) {
            $pagesIds[] = $page->getId();
        }

        $this->pageCache->clean(\Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG, $pagesIds);
    }

    /**
     * Retrieves the pages that have to be purged from cache
     *
     * @param $slider_id
     * @return PageSearchResultsInterface
     * @throws LocalizedException
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
