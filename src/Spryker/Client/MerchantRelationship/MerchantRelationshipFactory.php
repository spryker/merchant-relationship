<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MerchantRelationship;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\MerchantRelationship\Dependency\Client\MerchantRelationshipToZedRequestClientInterface;
use Spryker\Client\MerchantRelationship\Zed\MerchantRelationshipStub;
use Spryker\Client\MerchantRelationship\Zed\MerchantRelationshipStubInterface;

class MerchantRelationshipFactory extends AbstractFactory
{
    public function createMerchantRelationshipStub(): MerchantRelationshipStubInterface
    {
        return new MerchantRelationshipStub($this->getZedRequestClient());
    }

    public function getZedRequestClient(): MerchantRelationshipToZedRequestClientInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
