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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

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
     * Save constructor.
     * @param Action\Context $context
     * @param SliderRepositoryInterface $sliderRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        SliderRepositoryInterface $sliderRepository,
        DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
        $this->sliderRepository = $sliderRepository;
        $this->dataPersistor = $dataPersistor;
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
     * @param \Magento\Framework\DataObject $model
     * @param string[] $fields
     */
    protected function populateModelWithData($model, $fields)
    {
        foreach ($fields as $field) {
            $model->setData($field, $this->getRequest()->getParam($field));
        }
    }
}