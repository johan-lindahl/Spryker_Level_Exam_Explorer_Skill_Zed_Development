<?php

namespace Pyz\Zed\AntelopeLocationGui\Communication\Table;

use Orm\Zed\Antelope\Persistence\PyzAntelopeLocationQuery;
use Orm\Zed\Antelope\Persistence\Map\PyzAntelopeLocationTableMap;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class AntelopeLocationTable extends AbstractTable
{
    protected $antelopeQuery;

    public const COL_ID_LOCATION = 'pyz_antelope_location.id_location';
    public const COL_LOCATION_NAME = 'pyz_antelope_location.location_name';

    public function __construct(PyzAntelopeLocationQuery $antelopeQuery)
    {
        $this->antelopeQuery = $antelopeQuery;
    }

    protected function configure(TableConfiguration $config)
    {
        $config->setHeader([
            static::COL_ID_LOCATION => 'Antelope location ID',
            static::COL_LOCATION_NAME => 'Name',
        ]);

        $config->setSortable([
            static::COL_ID_LOCATION,
            static::COL_LOCATION_NAME
        ]);

        $config->setSearchable([
            PyzAntelopeLocationTableMap::COL_LOCATION_NAME
        ]);

        return $config;
    }

    protected function prepareData(TableConfiguration $config)
    {
        $antelopeEntityCollection = $this->runQuery(
            $this->antelopeQuery,
            $config,
            true
        );

        if (!$antelopeEntityCollection->count()) {
            return [];
        }

        $results = [];
        foreach ($antelopeEntityCollection as $antelopeEntity) {
            $results[] = [
                PyzAntelopeLocationTableMap::COL_ID_LOCATION => $antelopeEntity->getIdLocation(),
                PyzAntelopeLocationTableMap::COL_LOCATION_NAME => $antelopeEntity->getLocationName()
            ];
        }
        return $results;
    }
}
