<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model;


use Codilar\BannerSlider\Api\BannerRepositoryInterface;
use Codilar\BannerSlider\Api\Data\BannerInterfaceFactory as ModelFactory;
use Codilar\BannerSlider\Model\ResourceModel\Banner as ResourceModel;
use Codilar\BannerSlider\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Codilar\BannerSlider\Api\Data\BannerSearchResultInterfaceFactory;
use Psr\Log\LoggerInterface;

class BannerRepository implements BannerRepositoryInterface
{

    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var \Codilar\BannerSlider\Api\Data\BannerInterface[]
     */
    protected $objectCache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var BannerSearchResultInterfaceFactory
     */
    private $bannerSearchResultFactory;

    /**
     * BannerRepository constructor.
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param BannerSearchResultInterfaceFactory $bannerSearchResultFactory
     * @param LoggerInterface $logger
     * @param array $objectCache
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        BannerSearchResultInterfaceFactory $bannerSearchResultFactory,
        LoggerInterface $logger,
        array $objectCache = []
    )
    {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->bannerSearchResultFactory = $bannerSearchResultFactory;
        $this->logger = $logger;
        $this->objectCache = $objectCache;
    }

    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        $cachedObject = $this->getCachedObject('id', $id);
        if ($loadFromCache && $cachedObject) {
            return $cachedObject;
        } else {
            $model = $this->create();
            $this->resourceModel->load($model, $id);
            if (!$model->getEntityId()) {
                throw NoSuchEntityException::singleField('entity_id', $id);
            }
            $this->cacheObject('id', $id, $model);
            return $model;
        }
    }

    /**
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     */
    public function create(): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        return $this->modelFactory->create();
    }

    /**
     * @param \Codilar\BannerSlider\Api\Data\BannerInterface $banner
     * @return \Codilar\BannerSlider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Codilar\BannerSlider\Api\Data\BannerInterface $banner): \Codilar\BannerSlider\Api\Data\BannerInterface
    {
        try {
            $this->resourceModel->save($banner);
            return $this->loadById($banner->getEntityId(), false);
        } catch (AlreadyExistsException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('There was some error saving the banner'));
        }
    }

    /**
     * @param \Codilar\BannerSlider\Api\Data\BannerInterface $banner
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Codilar\BannerSlider\Api\Data\BannerInterface $banner): bool
    {
        try {
            $this->resourceModel->delete($banner);
            $this->cacheObject('id', $banner->getEntityId(), null);
            return true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('There was some eror deleting the banner'));
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->loadById($id));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Codilar\BannerSlider\Api\Data\BannerSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Codilar\BannerSlider\Api\Data\BannerSearchResultInterface $searchResult */
        $searchResult = $this->bannerSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria)
            ->setTotalCount($collection->getSize())
            ->setItems($collection->getItems());
        foreach ($searchResult->getItems() as $item) {
            $this->cacheObject('id', $item->getEntityId(), $item);
        }
        return $searchResult;
    }

    /**
     * @return \Codilar\BannerSlider\Model\ResourceModel\Banner\Collection
     */
    public function getCollection(): \Codilar\BannerSlider\Model\ResourceModel\Banner\Collection
    {
        return $this->collectionFactory->create();
    }

    /**
     * @param string $type
     * @param string $identifier
     * @param \Codilar\BannerSlider\Api\Data\BannerInterface|null $object
     */
    protected function cacheObject($type, $identifier, $object)
    {
        $cacheKey = $this->getCacheKey($type, $identifier);
        $this->objectCache[$cacheKey] = $object;
    }

    /**
     * @param string $type
     * @param string $identifier
     * @return bool|\Codilar\BannerSlider\Api\Data\BannerInterface
     */
    protected function getCachedObject($type, $identifier)
    {
        $cacheKey = $this->getCacheKey($type, $identifier);
        return $this->objectCache[$cacheKey] ?? false;
    }

    protected function getCacheKey($type, $identifier)
    {
        return $type . '_' . $identifier;
    }
}