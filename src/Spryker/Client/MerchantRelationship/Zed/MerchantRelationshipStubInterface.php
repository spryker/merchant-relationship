<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MerchantRelationship\Zed;

use Generated\Shared\Transfer\MerchantRelationshipCollectionTransfer;
use Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer;

interface MerchantRelationshipStubInterface
{
    public function getMerchantRelationshipCollection(
        MerchantRelationshipCriteriaTransfer $merchantRelationshipCriteriaTransfer
    ): MerchantRelationshipCollectionTransfer;
}
