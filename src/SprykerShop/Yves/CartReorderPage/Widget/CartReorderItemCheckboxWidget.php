<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartReorderPage\Widget;

use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\CartReorderPage\CartReorderPageFactory getFactory()
 */
class CartReorderItemCheckboxWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_ITEM = 'item';

    /**
     * @var string
     */
    protected const PARAMETER_ATTRIBUTE_NAME = 'attributeName';

    /**
     * @var string
     */
    protected const PARAMETER_ATTRIBUTE_VALUE = 'attributeValue';

    /**
     * @var string
     */
    protected const PARAMETER_ATTRIBUTE_DISABLED = 'attributeDisabled';

    /**
     * @var string
     */
    protected const ATTRIBUTE_NAME_SALES_ORDER_ITEM_IDS = 'sales-order-item-ids';

    public function __construct(ItemTransfer $itemTransfer)
    {
        $attributes = $this->executeCartReorderItemCheckboxAttributeExpanderPlugins(
            $this->buildDefaultAttributes($itemTransfer),
            $itemTransfer,
        );

        $this->addItemParameter($itemTransfer);
        $this->addAttributeNameParameter($attributes[static::PARAMETER_ATTRIBUTE_NAME]);
        $this->addAttributeValueParameter($attributes[static::PARAMETER_ATTRIBUTE_VALUE]);
        $this->addAttributeDisabledParameter($attributes[static::PARAMETER_ATTRIBUTE_DISABLED]);
    }

    public static function getName(): string
    {
        return 'CartReorderItemCheckboxWidget';
    }

    public static function getTemplate(): string
    {
        return '@CartReorderPage/views/cart-reorder-item-checkbox/cart-reorder-item-checkbox.twig';
    }

    protected function addItemParameter(ItemTransfer $itemTransfer): void
    {
        $this->addParameter(static::PARAMETER_ITEM, $itemTransfer);
    }

    protected function addAttributeNameParameter(string $attributeName): void
    {
        $this->addParameter(static::PARAMETER_ATTRIBUTE_NAME, $attributeName);
    }

    protected function addAttributeValueParameter(string $value): void
    {
        $this->addParameter(static::PARAMETER_ATTRIBUTE_VALUE, $value);
    }

    protected function addAttributeDisabledParameter(bool $disabled): void
    {
        $this->addParameter(static::PARAMETER_ATTRIBUTE_DISABLED, $disabled);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array<string, mixed>
     */
    protected function buildDefaultAttributes(ItemTransfer $itemTransfer): array
    {
        return [
            static::PARAMETER_ATTRIBUTE_NAME => static::ATTRIBUTE_NAME_SALES_ORDER_ITEM_IDS,
            static::PARAMETER_ATTRIBUTE_VALUE => $itemTransfer->getIdSalesOrderItem() ? (string)$itemTransfer->getIdSalesOrderItemOrFail() : null,
            static::PARAMETER_ATTRIBUTE_DISABLED => false,
        ];
    }

    /**
     * @param array<string, mixed> $attributes
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array<string, mixed>
     */
    protected function executeCartReorderItemCheckboxAttributeExpanderPlugins(array $attributes, ItemTransfer $itemTransfer): array
    {
        foreach ($this->getFactory()->getCartReorderItemCheckboxAttributeExpanderPlugins() as $cartReorderItemCheckboxAttributeExpanderPlugin) {
            $attributes = $cartReorderItemCheckboxAttributeExpanderPlugin->expand($attributes, $itemTransfer);
        }

        return $attributes;
    }
}
