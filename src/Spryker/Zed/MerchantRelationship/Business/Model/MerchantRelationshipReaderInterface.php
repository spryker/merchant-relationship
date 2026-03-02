<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Business\Model;

use Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer;
use Generated\Shared\Transfer\MerchantRelationshipFilterTransfer;
use Generated\Shared\Transfer\MerchantRelationshipTransfer;

interface MerchantRelationshipReaderInterface
{
    public function getMerchantRelationshipById(MerchantRelationshipTransfer $merchantRelationshipTransfer): MerchantRelationshipTransfer;

    public function findMerchantRelationshipByKey(MerchantRelationshipTransfer $merchantRelationshipTransfer): ?MerchantRelationshipTransfer;

    /**
     * @param int $idMerchantRelationship
     *
     * @return array<int>
     */
    public function getIdAssignedBusinessUnitsByMerchantRelationshipId(int $idMerchantRelationship): array;

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipFilterTransfer|null $merchantRelationshipFilterTransfer
     * @param \Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer|null $merchantRelationshipCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipCollectionTransfer|array<\Generated\Shared\Transfer\MerchantRelationshipTransfer>
     */
    public function getMerchantRelationshipCollection(
        ?MerchantRelationshipFilterTransfer $merchantRelationshipFilterTransfer = null,
        ?MerchantRelationshipCriteriaTransfer $merchantRelationshipCriteriaTransfer = null
    );

    public function findMerchantRelationshipById(MerchantRelationshipTransfer $merchantRelationshipTransfer): ?MerchantRelationshipTransfer;
}
