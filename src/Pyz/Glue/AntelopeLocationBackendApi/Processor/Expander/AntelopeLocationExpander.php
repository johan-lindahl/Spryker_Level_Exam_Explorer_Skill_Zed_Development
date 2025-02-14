<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Expander;

use Generated\Shared\Transfer\AntelopeLocationConditionTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\AntelopeLocationBackendApiConfig;

class AntelopeLocationExpander implements AntelopeLocationExpanderInterface
{
    public function expandWithFilters(
        AntelopeLocationConditionTransfer $antelopeLocationConditionTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): AntelopeLocationConditionTransfer {
        foreach ($glueRequestTransfer->getFilters() as $filter) {
            if ($filter->getResource() !== AntelopeLocationBackendApiConfig::RESOURCE_ANTELOPE_LOCATION) {
                return $antelopeLocationConditionTransfer;
            }
            $filterField = $filter->getField();
            $filterValue = $filter->getValue();
            if (!$filterValue) {
                continue;
            }
            switch ($filterField) {
                case AntelopeLocationConditionTransfer::ID_ANTELOPE_LOCATION:
                    $antelopeLocationConditionTransfer->setIdAntelopeLocation((int)$filterValue);

                    break;
                case AntelopeLocationConditionTransfer::LOCATION_NAME:
                    $antelopeLocationConditionTransfer->setLocationName($filterValue);

                    break;
                case AntelopeLocationConditionTransfer::ANTELOPE_LOCATION_IDS:
                    $ids = $this->getIds($filterValue);
                    $antelopeLocationConditionTransfer->setAntelopeLocationIds($ids);

                    break;
            }
        }

        return $antelopeLocationConditionTransfer;
    }

    /**
     * @param array<string>|string $filterValue
     *
     * @return array<int>
     */
    private function getIds(string|array $filterValue): array
    {
        if (is_string($filterValue)) {
            $filterValue = explode(',', $filterValue);
        }

        return array_map(
            'intval',
            array_filter(
                $filterValue,
                static fn (string $item) => is_numeric(trim($item))
            ),
        );
    }
}
