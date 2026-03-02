<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Business\Mapper;

use Generated\Shared\Transfer\CompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\MerchantRelationshipTransfer;

interface MerchantRelationshipCompanyBusinessUnitMapperInterface
{
    public function mapCompanyBusinessUnitCollectionTransferToMerchantRelationshipTransfer(
        CompanyBusinessUnitCollectionTransfer $addedCompanyBusinessUnitCollectionTransfer,
        MerchantRelationshipTransfer $merchantRelationshipTransfer
    ): MerchantRelationshipTransfer;
}
