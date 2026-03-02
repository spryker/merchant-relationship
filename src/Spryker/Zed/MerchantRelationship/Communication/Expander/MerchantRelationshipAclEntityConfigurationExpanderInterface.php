<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Communication\Expander;

use Generated\Shared\Transfer\AclEntityMetadataConfigTransfer;

interface MerchantRelationshipAclEntityConfigurationExpanderInterface
{
    public function expand(AclEntityMetadataConfigTransfer $aclEntityMetadataConfigTransfer): AclEntityMetadataConfigTransfer;
}
