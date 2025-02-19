<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Antelope\Persistence;

use Generated\Shared\Transfer\AntelopeCollectionTransfer;
use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeLocationResponseTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\AntelopeTransfer;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Generated\Shared\Transfer\AntelopeLocationConditionTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Orm\Zed\Antelope\Persistence\Base\PyzAntelopeLocationQuery;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * @method \Pyz\Zed\Antelope\Persistence\AntelopePersistenceFactory getFactory()
 */
class AntelopeRepository extends AbstractRepository implements
    AntelopeRepositoryInterface
{
    /**
     * @throws \Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException
     */
    public function getAntelope(
        AntelopeCriteriaTransfer $antelopeCriteriaTransfer,
    ): AntelopeTransfer {
        $antelopeEntity = $this->getFactory()->createAntelopeQuery()->filterByName(
            $antelopeCriteriaTransfer->getName(),
        )->findOne();
        if ($antelopeEntity === null) {
            throw new EntityNotFoundException(sprintf('Antelope %s not found', $antelopeCriteriaTransfer->getName()));
        }

        return (new AntelopeTransfer())->fromArray(
            $antelopeEntity->toArray(),
            true,
        );
    }

    public function getAntelopeLocation(
        AntelopeLocationCriteriaTransfer $antelopeLocationCriteria,
    ): AntelopeLocationResponseTransfer {
        if ($antelopeLocationCriteria->getIdAntelopeLocation() !== null) {
            return $this->getAntelopeLocationById($antelopeLocationCriteria->getIdAntelopeLocation());
        }
        if ($antelopeLocationCriteria->getLocationName() === null) {
            throw new EntityNotFoundException('No Antelope Location given');
        }

        return $this->getAntelopeLocationByName($antelopeLocationCriteria->getLocationName());
    }

    /**
     * @throws \Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException
     */
    public function getAntelopeLocationById(int $idLocation): AntelopeLocationResponseTransfer
    {
        $antelopeLocationEntity = $this->getFactory()
            ->createAntelopeLocationQuery()->findPk($idLocation);

        if ($antelopeLocationEntity === null) {
            throw new EntityNotFoundException(sprintf('Antelope Location %d not found', $idLocation));
        }
        $antelopeLocation = (new AntelopeLocationTransfer())->fromArray(
            $antelopeLocationEntity->toArray(),
            true,
        );
        $antelopeLocationResponseTransfer = new AntelopeLocationResponseTransfer();
        $antelopeLocationResponseTransfer->setIsSuccessFul(true);
        $antelopeLocationResponseTransfer->setAntelopeLocationOrFail($antelopeLocation);

        return $antelopeLocationResponseTransfer;
    }

    /**
     * @throws \Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException
     */
    public function getAntelopeLocationByName(string $antelopeLocationName): AntelopeLocationResponseTransfer
    {
        $antelopeLocationEntity = $this->getFactory()
            ->createAntelopeLocationQuery()->findByLocationName($antelopeLocationName);

        if ($antelopeLocationEntity === null) {
            throw new EntityNotFoundException(sprintf('Antelope Location %d not found', $antelopeLocationEntity));
        }
        $antelopeLocation = (new AntelopeLocationTransfer())->fromArray(
            $antelopeLocationEntity->toArray(),
            true,
        );
        $antelopeLocationResponseTransfer = new AntelopeLocationResponseTransfer();
        $antelopeLocationResponseTransfer->setIsSuccessFul(true);
        $antelopeLocationResponseTransfer->setAntelopeLocationOrFail($antelopeLocation);

        return $antelopeLocationResponseTransfer;
    }

    public function findAntelopeLocationCollection(
        AntelopeLocationCriteriaTransfer $criteriaTransfer,
    ): AntelopeLocationCollectionTransfer {
        return $this->getAntelopeLocations($criteriaTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer $criteriaTransfer
     *
     * @return \Generated\Shared\Transfer\AntelopeLocationCollectionTransfer
     */
    public function getAntelopeLocations(AntelopeLocationCriteriaTransfer $criteriaTransfer): AntelopeLocationCollectionTransfer
    {
        $query = $this->getFactory()->createAntelopeLocationQuery();

        $conditions = $criteriaTransfer->getAntelopeLocationConditions();
        if ($conditions) {
            $this->applyConditions($conditions, $query);
        }

        $pagination = $criteriaTransfer->getPagination();
        if ($pagination) {
            $this->applyPagination($pagination, $query);
        }        

        $sortingCollection = $criteriaTransfer->getSortCollection();
        if ($sortingCollection) {
            $this->applySorting($sortingCollection, $query);
        }        

        $antelopeLocations = $query->find();

        $antelopeLocationMapper = $this->getFactory()->createAntelopeLocationMapper();

        return $antelopeLocationMapper->mapAntelopeLocationEntitiesToCollectionTransfer(
            $antelopeLocations,
        );
    }

    public function getAntelopeCollection(AntelopeCriteriaTransfer $antelopeCriteriaTransfer): AntelopeCollectionTransfer
    {
        $query = $this->getFactory()->createAntelopeQuery();

        if ($antelopeCriteriaTransfer->getName() !== null) {
            $query->filterByName($antelopeCriteriaTransfer->getName());
        }

        $antelopeEntities = $query->find();
        $antelopeMapper = $this->getFactory()->createAntelopeMapper();

        /** @var \Orm\Zed\Antelope\Persistence\PyzAntelope $antelopeEntity */
        foreach ($antelopeEntities as $antelopeEntity)
        {
            $idLocation = $antelopeEntity->getFkAntelopeLocation();
            $antelopeLocationEntity = $this->getFactory()->createAntelopeLocationQuery()->findPk($idLocation);
            $antelopeEntity->setPyzAntelopeLocation($antelopeLocationEntity);
        }

        return $antelopeMapper->mapAntelopeEntityCollectionToAntelopeCollectionTransfer(
            $antelopeEntities,
        );
    }

    public function getAntelopeLocationsCollection(): AntelopeLocationCollectionTransfer
    {
        return $this->getAntelopeLocations(new AntelopeLocationCriteriaTransfer());
    }

    private function applySorting(
        \ArrayObject $sortCollection,
        PyzAntelopeLocationQuery $pyzAntelopeLocationQuery
    ) {
        /** @var \Generated\Shared\Transfer\SortTransfer $sort */
        foreach ($sortCollection as $sort) {
            $pyzAntelopeLocationQuery->orderBy($sort->getField(), $sort->getIsAscending() ? Criteria::ASC : Criteria::DESC);
        }
    }

    private function applyConditions(
        AntelopeLocationConditionTransfer $conditions,
        PyzAntelopeLocationQuery $pyzAntelopeLocationQuery
    ) {

        if ($id = $conditions->getIdAntelopeLocation()) {
            $pyzAntelopeLocationQuery->_or()->filterByIdLocation($id);      
        }
        if ($name = $conditions->getLocationName()) {
            $pyzAntelopeLocationQuery->_or()->filterByLocationName_Like("%$name%");
        }
        if ($ids = $conditions->getAntelopeLocationIds()) {
            $pyzAntelopeLocationQuery->_or()->filterByIdLocation_In($ids); 
        }
    }

    private function applyPagination(
        PaginationTransfer $paginationTransfer,
        PyzAntelopeLocationQuery $pyzAntelopeQuery
    ) {
        if ($paginationTransfer->getOffset() !== null && $paginationTransfer->getLimit() > 0) {
            $paginationTransfer->setNbResults($pyzAntelopeQuery->count());
            $pyzAntelopeQuery->setOffset((int)$paginationTransfer->getOffset());
            $pyzAntelopeQuery->setLimit((int)$paginationTransfer->getLimit());
        } elseif ($paginationTransfer->getPage() !== null && $paginationTransfer->getMaxPerPage()) {
            $pager = $pyzAntelopeQuery->paginate(
                $paginationTransfer->getPage(),
                $paginationTransfer->getMaxPerPage()
            );
            $paginationTransfer
                ->setNbResults($pager->getNbResults())
                ->setFirstIndex($pager->getFirstIndex())
                ->setLastIndex($pager->getLastIndex())
                ->setNextPage($pager->getNextPage())
                ->setPreviousPage($pager->getPreviousPage())
                ->setFirstPage($pager->getFirstPage())
                ->setLastPage($pager->getLastPage());
        }
    }
}
