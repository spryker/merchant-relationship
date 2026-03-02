<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\MerchantRelationshipTransfer;
use Generated\Shared\Transfer\MerchantRelationshipValidationErrorCollectionTransfer;
use Spryker\Zed\MerchantRelationship\Dependency\Facade\MerchantRelationshipToCompanyBusinessUnitFacadeInterface;
use Spryker\Zed\MerchantRelationship\Persistence\MerchantRelationshipRepositoryInterface;

class OwnerCompanyBusinessUnitAllowedValidatorRule extends AbstractMerchantRelationshipValidatorRule
{
    public function __construct(
        MerchantRelationshipRepositoryInterface $merchantRelationshipRepository,
        MerchantRelationshipToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
    ) {
        $this->merchantRelationshipRepository = $merchantRelationshipRepository;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
    }

    public function validate(
        MerchantRelationshipTransfer $merchantRelationshipTransfer,
        MerchantRelationshipValidationErrorCollectionTransfer $merchantRelationshipValidationErrorCollectionTransfer
    ): MerchantRelationshipValidationErrorCollectionTransfer {
        if ($merchantRelationshipTransfer->getIdMerchantRelationship() === null) {
            return $merchantRelationshipValidationErrorCollectionTransfer;
        }

        $requestedOwnerCompanyBusinessUnitTransfer = $merchantRelationshipTransfer->getOwnerCompanyBusinessUnit();
        if (!$requestedOwnerCompanyBusinessUnitTransfer || !$requestedOwnerCompanyBusinessUnitTransfer->getIdCompanyBusinessUnit()) {
            return $merchantRelationshipValidationErrorCollectionTransfer;
        }

        $existingMerchantRelationshipTransfer = $this->findMerchantRelationship($merchantRelationshipTransfer->getIdMerchantRelationshipOrFail());

        if (!$existingMerchantRelationshipTransfer) {
            return $merchantRelationshipValidationErrorCollectionTransfer;
        }

        $existingOwnerCompanyBusinessUnit = $existingMerchantRelationshipTransfer->getOwnerCompanyBusinessUnitOrFail();
        if ($this->isSameCompanyBusinessUnit($existingOwnerCompanyBusinessUnit, $requestedOwnerCompanyBusinessUnitTransfer)) {
            return $merchantRelationshipValidationErrorCollectionTransfer;
        }

        if (
            $this->isRequestedOwnerCompanyBusinessUnitAssignedToSameCompanyAsExisting(
                $existingOwnerCompanyBusinessUnit,
                $requestedOwnerCompanyBusinessUnitTransfer,
            )
        ) {
            return $merchantRelationshipValidationErrorCollectionTransfer;
        }

        $merchantRelationshipErrorTransfer = $this->createMerchantRelationshipErrorTransfer(
            'idBusinessUnitOwner',
            sprintf('Can not find related company business unit by id "%s".', $requestedOwnerCompanyBusinessUnitTransfer->getIdCompanyBusinessUnit()),
        );

        return $merchantRelationshipValidationErrorCollectionTransfer->addError($merchantRelationshipErrorTransfer);
    }

    protected function isRequestedOwnerCompanyBusinessUnitAssignedToSameCompanyAsExisting(
        CompanyBusinessUnitTransfer $existingOwnerCompanyBusinessUnitTransfer,
        CompanyBusinessUnitTransfer $requestedOwnerCompanyBusinessUnitTransfer
    ): bool {
        $companyBusinessUnitCollectionTransfer = $this->getCompanyBusinessUnitCollection(
            $existingOwnerCompanyBusinessUnitTransfer->getCompanyOrFail()->getIdCompanyOrFail(),
        );

        foreach ($companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits() as $companyBusinessUnitTransfer) {
            if ($this->isSameCompanyBusinessUnit($companyBusinessUnitTransfer, $requestedOwnerCompanyBusinessUnitTransfer)) {
                return true;
            }
        }

        return false;
    }

    protected function isSameCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        CompanyBusinessUnitTransfer $requestedCompanyBusinessUnitTransfer
    ): bool {
        return $companyBusinessUnitTransfer->getIdCompanyBusinessUnitOrFail() === $requestedCompanyBusinessUnitTransfer->getIdCompanyBusinessUnitOrFail();
    }
}
