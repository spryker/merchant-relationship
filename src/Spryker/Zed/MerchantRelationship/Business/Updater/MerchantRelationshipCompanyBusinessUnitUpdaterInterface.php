<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Business\Updater;

use Generated\Shared\Transfer\MerchantRelationshipTransfer;

interface MerchantRelationshipCompanyBusinessUnitUpdaterInterface
{
    public function updateMerchantRelationshipCompanyBusinessUnitRelations(
        MerchantRelationshipTransfer $merchantRelationshipTransfer
    ): MerchantRelationshipTransfer;
}
