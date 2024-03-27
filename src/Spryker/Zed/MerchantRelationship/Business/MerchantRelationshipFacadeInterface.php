<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Business;

use Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer;
use Generated\Shared\Transfer\MerchantRelationshipFilterTransfer;
use Generated\Shared\Transfer\MerchantRelationshipRequestTransfer;
use Generated\Shared\Transfer\MerchantRelationshipTransfer;

interface MerchantRelationshipFacadeInterface
{
    /**
     * Specification:
     * - Requires `MerchantRelationshipTransfer.fkMerchant`, `MerchantRelationshipTransfer.fkCompanyBusinessUnit` transfer properties to be set.
     * - Requires `MerchantRelationshipTransfer.assigneeCompanyBusinessUnits.companyBusinessUnits.idCompanyBusinessUnit` transfer property to be set if `MerchantRelationshipTransfer.assigneeCompanyBusinessUnits` is set.
     * - If `MerchantRelationshipRequestTransfer` is provided, requires `MerchantRelationshipRequestTransfer.merchantRelationship`, `MerchantRelationshipRequestTransfer.merchantRelationship.ownerCompanyBusinessUnit`,
     *   `MerchantRelationshipRequestTransfer.merchantRelationship.ownerCompanyBusinessUnit.idCompanyBusinessUnit`, `MerchantRelationshipRequestTransfer.merchantRelationship.fkCompanyBusinessUnit`,
     *   `MerchantRelationshipRequestTransfer.merchantRelationship.merchant` transfer properties to be set.
     * - If `MerchantRelationshipRequestTransfer` transfer is provided, validates `MerchantRelationshipRequestTransfer.merchantRelationship`
     *   and executes {@link \Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipCreateValidatorPluginInterface} plugin stack.
     * - Creates a new merchant relationship entity.
     * - Uses incoming transfer to set entity fields.
     * - Persists the entity to DB.
     * - Executes post-create plugin stack MerchantRelationshipPostCreatePluginInterface.
     * - Sets ID to the returning transfer.
     * - Creates new assignee relations by AssigneeCompanyBusinessUnitCollection (fk_merchant_relation, fk_company_business_unit).
     * - From next major version (Forward Compatibility): Argument `$merchantRelationshipTransfer` will be removed. The return type will be changed to \Generated\Shared\Transfer\MerchantRelationshipResponseTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer Deprecated: Use {@link \Generated\Shared\Transfer\MerchantRelationshipRequestTransfer} instead.
     * @param \Generated\Shared\Transfer\MerchantRelationshipRequestTransfer|null $merchantRelationshipRequestTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer|\Generated\Shared\Transfer\MerchantRelationshipResponseTransfer
     */
    public function createMerchantRelationship(
        MerchantRelationshipTransfer $merchantRelationshipTransfer,
        ?MerchantRelationshipRequestTransfer $merchantRelationshipRequestTransfer = null
    );

    /**
     * Specification:
     * - Requires `MerchantRelationshipTransfer.idMerchantRelationship`, `MerchantRelationshipTransfer.fkMerchant` and `MerchantRelationshipTransfer.fkCompanyBusinessUnit` transfer properties to be set.
     * - Requires `MerchantRelationshipTransfer.assigneeCompanyBusinessUnits.companyBusinessUnits.idCompanyBusinessUnit` transfer property to be set if `MerchantRelationshipTransfer.assigneeCompanyBusinessUnits` is set.
     * - If `MerchantRelationshipRequestTransfer` is provided, requires `MerchantRelationshipRequestTransfer.merchantRelationship`, `MerchantRelationshipRequestTransfer.merchantRelationship.ownerCompanyBusinessUnit`,
     *  `MerchantRelationshipRequestTransfer.merchantRelationship.idMerchantRelationship`
     * - If `MerchantRelationshipRequestTransfer` transfer is provided, validates `MerchantRelationshipRequestTransfer.merchantRelationship`
     *   and executes {@link \Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipUpdateValidatorPluginInterface} plugin stack.
     * - Finds a merchant record by ID in DB.
     * - Uses incoming transfer to update entity fields.
     * - Persists the entity to DB.
     * - Executes post-update plugin stack MerchantRelationshipPostUpdatePluginInterface.
     * - Removes outdated relations by assigneeCompanyBusinessUnitCollection (fk_merchant_relation, fk_company_business_unit).
     * - Creates new relations by AssigneeCompanyBusinessUnitCollection (fk_merchant_relation, fk_company_business_unit).
     * - Throws MerchantRelationNotFoundException in case a record is not found.
     * - From next major version (Forward Compatibility): Argument `$merchantRelationshipTransfer` will be removed. The return type will be changed to `\Generated\Shared\Transfer\MerchantRelationshipResponseTransfer`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer Deprecated: Use {@link \Generated\Shared\Transfer\MerchantRelationshipRequestTransfer} instead.
     * @param \Generated\Shared\Transfer\MerchantRelationshipRequestTransfer|null $merchantRelationshipRequestTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer|\Generated\Shared\Transfer\MerchantRelationshipResponseTransfer
     */
    public function updateMerchantRelationship(
        MerchantRelationshipTransfer $merchantRelationshipTransfer,
        ?MerchantRelationshipRequestTransfer $merchantRelationshipRequestTransfer = null
    );

    /**
     * Specification:
     * - Removes related business units by assigneeCompanyBusinessUnitCollection.
     * - Executes pre-delete plugin stack MerchantRelationshipPreDeletePluginInterface.
     * - Finds a merchant relationship record by ID in DB.
     * - Removes the merchant relationship record.
     * - Executes a stack of {@link \Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipPostDeletePluginInterface} plugins.
     * - From next major version (Forward Compatibility): Argument `$merchantRelationshipTransfer` will be removed.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer Deprecated: Use {@link \Generated\Shared\Transfer\MerchantRelationshipRequestTransfer} instead.
     * @param \Generated\Shared\Transfer\MerchantRelationshipRequestTransfer|null $merchantRelationshipRequestTransfer
     *
     * @return void
     */
    public function deleteMerchantRelationship(
        MerchantRelationshipTransfer $merchantRelationshipTransfer,
        ?MerchantRelationshipRequestTransfer $merchantRelationshipRequestTransfer = null
    ): void;

    /**
     * Specification:
     * - Returns a merchant relationship by merchant relationship id in provided transfer.
     * - Throws an exception in case a record is not found.
     * - Populates name in transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer
     */
    public function getMerchantRelationshipById(MerchantRelationshipTransfer $merchantRelationshipTransfer): MerchantRelationshipTransfer;

    /**
     * Specification:
     * - Returns a merchant relationship by merchant relationship key in provided transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer|null
     */
    public function findMerchantRelationshipByKey(MerchantRelationshipTransfer $merchantRelationshipTransfer): ?MerchantRelationshipTransfer;

    /**
     * Specification:
     * - Returns merchant relations.
     * - Filters by merchant relationship IDs when provided.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.merchantRelationshipIds` to filter by merchant relationship IDs.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.merchantIds` to filter by merchant IDs.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.companyIds` to filter by company IDs.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.ownerCompanyBusinessUnitIds` to filter by owner company business unit IDs.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.isActiveMerchant` to filter by merchant active status.
     * - Uses `MerchantRelationshipCriteriaTransfer.pagination.{page, maxPerPage}` to paginate results with page and maxPerPage.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.rangeCreatedAt.from` to specify the starting date for filtering by the creation date of the entity.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipConditions.rangeCreatedAt.to` to specify the ending date for filtering by the creation date of the entity.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipSearchConditions.ownerCompanyBusinessUnitName` to search by owner company business unit name.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipSearchConditions.ownerCompanyBusinessUnitCompanyName` to search by owner company business unit company name.
     * - Uses `MerchantRelationshipCriteriaTransfer.merchantRelationshipSearchConditions.assigneeCompanyBusinessUnitName` to search by assignee company business unit names.
     * - Hydrate owner company business unit and merchant.
     * - Populates name in transfer.
     * - Executes a stack of {@link \Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipExpanderPluginInterface} plugins.
     * - From next major version (Forward Compatibility): Argument `$merchantRelationshipFilterTransfer` will be removed. The return type will be changed to `\Generated\Shared\Transfer\MerchantRelationshipResponseTransfer`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipFilterTransfer|null $merchantRelationshipFilterTransfer Deprecated: Use {@link \Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer} instead.
     * @param \Generated\Shared\Transfer\MerchantRelationshipCriteriaTransfer|null $merchantRelationshipCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipCollectionTransfer|array<\Generated\Shared\Transfer\MerchantRelationshipTransfer>
     */
    public function getMerchantRelationshipCollection(
        ?MerchantRelationshipFilterTransfer $merchantRelationshipFilterTransfer = null,
        ?MerchantRelationshipCriteriaTransfer $merchantRelationshipCriteriaTransfer = null
    );

    /**
     * Specification:
     * - Finds a merchant relationship by merchant relationship id in provided transfer.
     * - Returns MerchantRelationshipTransfer if found, NULL otherwise.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer|null
     */
    public function findMerchantRelationshipById(MerchantRelationshipTransfer $merchantRelationshipTransfer): ?MerchantRelationshipTransfer;

    /**
     * Specification:
     * - Requires `MerchantRelationship.fkMerchant` to be set.
     * - Requires `MerchantRelationship.ownerCompanyBusinessUnit.idCompanyBusinessUnit` to be set.
     * - Requires `MerchantRelationship.assigneeCompanyBusinessUnits' to be set.
     * - Expects `MerchantRelationship.assigneeCompanyBusinessUnits.companyBusinessUnits' to be set.
     * - Requires `MerchantRelationship.assigneeCompanyBusinessUnits.companyBusinessUnits.idCompanyBusinessUnit' to be set.
     * - Does nothing when merchant's owner company business unit don't have email address.
     * - Adds assignee company business unit email addresses as recipients BCC.
     * - Sends a notification email about deleted merchant relationships to company business units.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return void
     */
    public function sendMerchantRelationshipDeleteMailNotification(MerchantRelationshipTransfer $merchantRelationshipTransfer): void;
}
