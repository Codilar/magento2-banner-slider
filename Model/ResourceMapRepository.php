<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Model;


use Codilar\BannerSlider\Api\ResourceMapRepositoryInterface;
use Codilar\BannerSlider\Api\Data\ResourceMapInterfaceFactory as ModelFactory;
use Codilar\BannerSlider\Model\ResourceModel\ResourceMap as ResourceModel;
use Codilar\BannerSlider\Model\ResourceModel\ResourceMap\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Codilar\BannerSlider\Api\Data\ResourceMapSearchResultInterfaceFactory;
use Psr\Log\LoggerInterface;

class ResourceMapRepository implements ResourceMapRepositoryInterface
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
     * @var \Codilar\BannerSlider\Api\Data\ResourceMapInterface[]
     */
    protected $objectCache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ResourceMapSearchResultInterfaceFactory
     */
    private $resourceMapSearchResultFactory;

    /**
     * ResourceMapRepository constructor.
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ResourceMapSearchResultInterfaceFactory $resourceMapSearchResultFactory
     * @param LoggerInterface $logger
     * @param array $objectCache
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ResourceMapSearchResultInterfaceFactory $resourceMapSearchResultFactory,
        LoggerInterface $logger,
        array $objectCache = []
    )
    {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->resourceMapSearchResultFactory = $resourceMapSearchResultFactory;
        $this->logger = $logger;
        $this->objectCache = $objectCache;
    }

    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Codilar\BannerSlider\Api\Data\ResourceMapInterface
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
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     */
    public function create(): \Codilar\BannerSlider\Api\Data\ResourceMapInterface
    {
        return $this->modelFactory->create();
    }

    /**
     * @param \Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap): \Codilar\BannerSlider\Api\Data\ResourceMapInterface
    {
        try {
            $this->resourceModel->save($resourceMap);
            return $this->loadById($resourceMap->getEntityId(), false);
        } catch (AlreadyExistsException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('There was some error saving the resource map'));
        }
    }

    /**
     * @param \Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Codilar\BannerSlider\Api\Data\ResourceMapInterface $resourceMap): bool
    {
        try {
            $this->resourceModel->delete($resourceMap);
            $this->cacheObject('id', $resourceMap->getEntityId(), null);
            return true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('There was some eror deleting the resource map'));
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
     * @return \Codilar\BannerSlider\Api\Data\ResourceMapSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Codilar\BannerSlider\Api\Data\ResourceMapSearchResultInterface $searchResult */
        $searchResult = $this->resourceMapSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria)
            ->setTotalCount($collection->getSize())
            ->setItems($collection->getItems());
        foreach ($searchResult->getItems() as $item) {
            $this->cacheObject('id', $item->getEntityId(), $item);
        }
        return $searchResult;
    }

    /**
     * @return \Codilar\BannerSlider\Model\ResourceModel\ResourceMap\Collection
     */
    public function getCollection(): \Codilar\BannerSlider\Model\ResourceModel\ResourceMap\Collection
    {
        return $this->collectionFactory->create();
    }

    /**
     * @param string $type
     * @param string $identifier
     * @param \Codilar\BannerSlider\Api\Data\ResourceMapInterface|null $object
     */
    protected function cacheObject($type, $identifier, $object)
    {
        $cacheKey = $this->getCacheKey($type, $identifier);
        $this->objectCache[$cacheKey] = $object;
    }

    /**
     * @param string $type
     * @param string $identifier
     * @return bool|\Codilar\BannerSlider\Api\Data\ResourceMapInterface
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