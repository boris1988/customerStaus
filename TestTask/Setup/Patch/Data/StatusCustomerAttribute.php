<?php


namespace Pereviazko\TestTask\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class StatusCustomerAttribute implements DataPatchInterface, PatchRevertableInterface
{
    private const ATTRIBUTE_NAME = "customer_status";
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetup
     */
    private $customerSetupFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): StatusCustomerAttribute
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            self::ATTRIBUTE_NAME, //attribute name
            [
                'type' => 'varchar',
                'label' => 'Customer Status',
                'input' => 'text',
                'source' => '',
                'required' => false,
                'visible' => true,
                'system' => false,
                'backend' => ''
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::ATTRIBUTE_NAME)
            ->addData([
            'used_in_forms' => [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]
        ]);

        $this->attributeRepository->save($attribute);
        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->removeAttribute(Customer::ENTITY, self::ATTRIBUTE_NAME);

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
