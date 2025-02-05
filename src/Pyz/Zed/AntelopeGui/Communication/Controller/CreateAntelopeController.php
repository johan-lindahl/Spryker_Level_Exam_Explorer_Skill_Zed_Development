<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeGui\Communication\Controller;

use Generated\Shared\Transfer\AntelopeTransfer;
use Pyz\Zed\AntelopeGui\Communication\AntelopeGuiCommunicationFactory;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method AntelopeGuiCommunicationFactory getFactory()
 */
class CreateAntelopeController extends AbstractController
{
    protected const string URL_ANTELOPE_OVERVIEW = '/antelope-gui';

    protected const string MESSAGE_ANTELOPE_CREATED_SUCCESS = 'Antelope was successfully created.';

    /**
     * @param Request $request
     * @return RedirectResponse|array<string,mixed>
     */
    public function indexAction(Request $request): RedirectResponse|array
    {
        $antelopeCreateForm = $this->getFactory()
            ->createAntelopeCreateForm(new AntelopeTransfer())
            ->handleRequest($request);

        if ($antelopeCreateForm->isSubmitted() && $antelopeCreateForm->isValid()) {
            return $this->createAntelope($antelopeCreateForm);
        }

        return $this->viewResponse([
            'antelopeCreateForm' => $antelopeCreateForm->createView(),
            'backUrl' => $this->getAntelopeOverviewUrl(),
        ]);
    }

    protected function createAntelope(FormInterface $antelopeCreateForm
    ): RedirectResponse {
        /** @var AntelopeTransfer|null $antelopeTransfer */
        $antelopeTransfer = $antelopeCreateForm->getData();

        $this->getFactory()
            ->getAntelopeFacade()
            ->createAntelope($antelopeTransfer);

        $this->addSuccessMessage(static::MESSAGE_ANTELOPE_CREATED_SUCCESS);

        return $this->redirectResponse($this->getAntelopeOverviewUrl());
    }

    protected function getAntelopeOverviewUrl(): string
    {
        return (string)Url::generate(static::URL_ANTELOPE_OVERVIEW);
    }
}
