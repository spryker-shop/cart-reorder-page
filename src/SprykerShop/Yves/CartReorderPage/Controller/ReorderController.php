<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartReorderPage\Controller;

use Generated\Shared\Transfer\CartReorderResponseTransfer;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\CartReorderPage\CartReorderPageConfig getConfig()
 * @method \SprykerShop\Yves\CartReorderPage\CartReorderPageFactory getFactory()
 */
class ReorderController extends AbstractController
{
    public function reorderAction(Request $request, string $orderReference): RedirectResponse
    {
        $cartReorderForm = $this->getFactory()
            ->getCartReorderForm()
            ->handleRequest($request);

        if (!$cartReorderForm->isSubmitted() || !$cartReorderForm->isValid()) {
            $this->addErrorMessagesFromForm($cartReorderForm);

            return $this->redirectToFailureUrl();
        }

        $cartReorderResponseTransfer = $this->getFactory()
            ->createCartReorderHandler()
            ->reorder($orderReference, $request);

        $this->handleCartReorderResponseErrors($cartReorderResponseTransfer);

        if ($cartReorderResponseTransfer->getErrors()->count()) {
            return $this->redirectToFailureUrl();
        }

        return $this->redirectToSuccessfulUrl();
    }

    protected function redirectToFailureUrl(): RedirectResponse
    {
        return $this->redirectResponseInternal(
            $this->getFactory()->getConfig()->getReorderFailureRedirectUrl(),
        );
    }

    protected function redirectToSuccessfulUrl(): RedirectResponse
    {
        return $this->redirectResponseInternal(
            $this->getFactory()->getConfig()->getReorderSuccessfulRedirectUrl(),
        );
    }

    protected function addErrorMessagesFromForm(FormInterface $form): void
    {
        /** @var \Symfony\Component\Form\FormErrorIterator<\Symfony\Component\Form\FormError> $errors */
        $errors = $form->getErrors(true);
        foreach ($errors as $error) {
            $this->addErrorMessage($error->getMessage());
        }
    }

    protected function handleCartReorderResponseErrors(CartReorderResponseTransfer $cartReorderResponseTransfer): void
    {
        foreach ($cartReorderResponseTransfer->getErrors() as $errorTransfer) {
            $this->addErrorMessage($errorTransfer->getMessageOrFail());
        }
    }
}
