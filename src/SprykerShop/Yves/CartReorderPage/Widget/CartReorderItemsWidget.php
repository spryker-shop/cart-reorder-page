<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartReorderPage\Widget;

use ArrayObject;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\CartReorderPage\CartReorderPageFactory getFactory()
 */
class CartReorderItemsWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_FORM = 'form';

    /**
     * @var string
     */
    protected const PARAMETER_ORDER = 'order';

    /**
     * @var string
     */
    protected const PARAMETER_SHIPMENT_GROUPS = 'shipmentGroups';

    /**
     * @var string
     */
    protected const PARAMETER_ORDER_SHIPMENT_EXPENSES = 'orderShipmentExpenses';

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ShipmentGroupTransfer>|null $shipmentGroups
     * @param array<\Generated\Shared\Transfer\ExpenseTransfer> $orderShipmentExpenses
     */
    public function __construct(
        OrderTransfer $orderTransfer,
        ?ArrayObject $shipmentGroups = null,
        array $orderShipmentExpenses = []
    ) {
        $this->addFormParameter();
        $this->addOrderParameter($orderTransfer);
        $this->addShipmentGroupsParameter($shipmentGroups);
        $this->addOrderShipmentExpensesParameter($orderShipmentExpenses);
    }

    public static function getName(): string
    {
        return 'CartReorderItemsWidget';
    }

    public static function getTemplate(): string
    {
        return '@CartReorderPage/views/cart-reorder-items/cart-reorder-items.twig';
    }

    protected function addFormParameter(): void
    {
        $this->addParameter(static::PARAMETER_FORM, $this->getFactory()->getCartReorderForm()->createView());
    }

    protected function addOrderParameter(OrderTransfer $orderTransfer): void
    {
        $this->addParameter(static::PARAMETER_ORDER, $orderTransfer);
    }

    /**
     * @param array<\Generated\Shared\Transfer\ExpenseTransfer> $orderShipmentExpenses
     *
     * @return void
     */
    protected function addOrderShipmentExpensesParameter(array $orderShipmentExpenses = []): void
    {
        $this->addParameter(static::PARAMETER_ORDER_SHIPMENT_EXPENSES, $orderShipmentExpenses);
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ShipmentGroupTransfer>|null $shipmentGroups
     *
     * @return void
     */
    protected function addShipmentGroupsParameter(?ArrayObject $shipmentGroups = null): void
    {
        $this->addParameter(static::PARAMETER_SHIPMENT_GROUPS, $shipmentGroups);
    }
}
