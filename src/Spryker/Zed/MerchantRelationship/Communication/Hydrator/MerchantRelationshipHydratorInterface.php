<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Communication\Hydrator;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface MerchantRelationshipHydratorInterface
{
    public function hydrate(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer;
}
