<?php
declare(strict_types=1);

namespace Pyz\Client\Training;

use Pyz\Client\Training\Stub\TrainingStub;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

class TrainingFactory extends AbstractFactory
{
    public function createTrainingStub(): TrainingStub
    {
        return new TrainingStub(
            $this->getZedRequestClient()
        );
    }
    
    public function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(TrainingDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
