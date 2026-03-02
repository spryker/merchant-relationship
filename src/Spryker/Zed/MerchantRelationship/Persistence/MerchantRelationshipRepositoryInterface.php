<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Persistence;

use Generated\Shared\Transfer\MerchantRelationshipCollectionTransfer;
use Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer;
use Generated\Shared\Transfer\MerchantRelationshipTransfer;

interface MerchantRelationshipRepositoryInterface
{
    public function getMerchantRelationshipById(int $idMerchantRelationship): ?MerchantRelationshipTransfer;

    public function findMerchantRelationshipByKey(string $merchantRelationshipKey): ?MerchantRelationshipTransfer;

    /**
     * @param int $idMerchantRelationship
     *
     * @return array<int>
     */
    public function getIdAssignedBusinessUnitsByMerchantRelationshipId(int $idMerchantRelationship): array;

    /**
     * @param int $idCompanyBusinessUnit
     *
     * @return array<\Generated\Shared\Transfer\MerchantRelationshipTransfer>
     */
    public function getAssignedMerchantRelationshipsByIdCompanyBusinessUnit(int $idCompanyBusinessUnit): array;

    public function hasKey(string $candidate): bool;

    public function getMaxMerchantRelationshipId(): int;

    public function getMerchantRelationshipCollection(
        MerchantRelationshipCriteriaTransfer $merchantRelationshipCriteriaTransfer
    ): MerchantRelationshipCollectionTransfer;

    /**
     * @param list<int> $merchantRelationshipIds
     *
     * @return array<int, list<\Generated\Shared\Transfer\CompanyBusinessUnitTransfer>>
     */
    public function getAssigneeCompanyBusinessUnitsGroupedByIdMerchantRelationship(array $merchantRelationshipIds): array;
}
