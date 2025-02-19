<?php
declare(strict_types=1);

namespace Pyz\Yves\TrainingPage;

use Pyz\Client\Training\TrainingClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;

class TrainingPageFactory extends AbstractFactory
{
    public function getTrainingClient(): TrainingClientInterface
    {
        return $this->getProvidedDependency(TrainingPageDependencyProvider::CLIENT_TRAINING);
    }
}