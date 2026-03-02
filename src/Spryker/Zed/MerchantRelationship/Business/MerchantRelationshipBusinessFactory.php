<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationship\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MerchantRelationship\Business\Builder\MerchantRelationshipDeleteMailBuilder;
use Spryker\Zed\MerchantRelationship\Business\Builder\MerchantRelationshipDeleteMailBuilderInterface;
use Spryker\Zed\MerchantRelationship\Business\Creator\MerchantRelationshipCompanyBusinessUnitCreator;
use Spryker\Zed\MerchantRelationship\Business\Creator\MerchantRelationshipCompanyBusinessUnitCreatorInterface;
use Spryker\Zed\MerchantRelationship\Business\Creator\MerchantRelationshipCreator;
use Spryker\Zed\MerchantRelationship\Business\Creator\MerchantRelationshipCreatorInterface;
use Spryker\Zed\MerchantRelationship\Business\Deleter\MerchantRelationshipDeleter;
use Spryker\Zed\MerchantRelationship\Business\Deleter\MerchantRelationshipDeleterInterface;
use Spryker\Zed\MerchantRelationship\Business\Expander\MerchantRelationshipExpander;
use Spryker\Zed\MerchantRelationship\Business\Expander\MerchantRelationshipExpanderInterface;
use Spryker\Zed\MerchantRelationship\Business\KeyGenerator\MerchantRelationshipKeyGenerator;
use Spryker\Zed\MerchantRelationship\Business\KeyGenerator\MerchantRelationshipKeyGeneratorInterface;
use Spryker\Zed\MerchantRelationship\Business\Mapper\MerchantRelationshipCompanyBusinessUnitMapper;
use Spryker\Zed\MerchantRelationship\Business\Mapper\MerchantRelationshipCompanyBusinessUnitMapperInterface;
use Spryker\Zed\MerchantRelationship\Business\Mapper\MerchantRelationshipCriteriaMapper;
use Spryker\Zed\MerchantRelationship\Business\Mapper\MerchantRelationshipCriteriaMapperInterface;
use Spryker\Zed\MerchantRelationship\Business\Model\MerchantRelationshipReader;
use Spryker\Zed\MerchantRelationship\Business\Model\MerchantRelationshipReaderInterface;
use Spryker\Zed\MerchantRelationship\Business\Reader\CompanyBusinessUnitReader;
use Spryker\Zed\MerchantRelationship\Business\Reader\CompanyBusinessUnitReaderInterface;
use Spryker\Zed\MerchantRelationship\Business\Reader\MerchantReader;
use Spryker\Zed\MerchantRelationship\Business\Reader\MerchantReaderInterface;
use Spryker\Zed\MerchantRelationship\Business\Sender\MerchantRelationshipDeleteMailNotificationSender;
use Spryker\Zed\MerchantRelationship\Business\Sender\MerchantRelationshipDeleteMailNotificationSenderInterface;
use Spryker\Zed\MerchantRelationship\Business\Updater\MerchantRelationshipCompanyBusinessUnitUpdater;
use Spryker\Zed\MerchantRelationship\Business\Updater\MerchantRelationshipCompanyBusinessUnitUpdaterInterface;
use Spryker\Zed\MerchantRelationship\Business\Updater\MerchantRelationshipUpdater;
use Spryker\Zed\MerchantRelationship\Business\Updater\MerchantRelationshipUpdaterInterface;
use Spryker\Zed\MerchantRelationship\Business\Validator\MerchantRelationshipCreateValidator;
use Spryker\Zed\MerchantRelationship\Business\Validator\MerchantRelationshipUpdateValidator;
use Spryker\Zed\MerchantRelationship\Business\Validator\MerchantRelationshipValidatorInterface;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\AssignedCompanyBusinessUnitAllowedCreateValidatorRule;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\AssignedCompanyBusinessUnitAllowedUpdateValidatorRule;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\MerchantReferenceExistsValidatorRule;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\MerchantRelationshipKeyUniqueValidatorRule;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\MerchantRelationshipValidatorRuleInterface;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\OwnerCompanyBusinessUnitAllowedValidatorRule;
use Spryker\Zed\MerchantRelationship\Business\Validator\ValidatorRule\OwnerCompanyBusinessUnitExistsValidatorRule;
use Spryker\Zed\MerchantRelationship\Dependency\Facade\MerchantRelationshipToCompanyBusinessUnitFacadeInterface;
use Spryker\Zed\MerchantRelationship\Dependency\Facade\MerchantRelationshipToLocaleFacadeInterface;
use Spryker\Zed\MerchantRelationship\Dependency\Facade\MerchantRelationshipToMailFacadeInterface;
use Spryker\Zed\MerchantRelationship\Dependency\Facade\MerchantRelationshipToMerchantFacadeInterface;
use Spryker\Zed\MerchantRelationship\MerchantRelationshipDependencyProvider;

/**
 * @method \Spryker\Zed\MerchantRelationship\Persistence\MerchantRelationshipRepositoryInterface getRepository()
 * @method \Spryker\Zed\MerchantRelationship\Persistence\MerchantRelationshipEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantRelationship\MerchantRelationshipConfig getConfig()
 */
class MerchantRelationshipBusinessFactory extends AbstractBusinessFactory
{
    public function createMerchantRelationshipCreator(): MerchantRelationshipCreatorInterface
    {
        return new MerchantRelationshipCreator(
            $this->getEntityManager(),
            $this->createMerchantRelationshipCreateValidator(),
            $this->createMerchantRelationshipKeyGenerator(),
            $this->createMerchantRelationshipCompanyBusinessUnitCreator(),
            $this->getMerchantFacade(),
            $this->getMerchantRelationshipPostCreatePlugins(),
        );
    }

    public function createMerchantRelationshipCompanyBusinessUnitCreator(): MerchantRelationshipCompanyBusinessUnitCreatorInterface
    {
        return new MerchantRelationshipCompanyBusinessUnitCreator($this->getEntityManager());
    }

    public function createMerchantRelationshipUpdater(): MerchantRelationshipUpdaterInterface
    {
        return new MerchantRelationshipUpdater(
            $this->getEntityManager(),
            $this->createMerchantRelationshipUpdateValidator(),
            $this->createMerchantRelationshipKeyGenerator(),
            $this->createMerchantRelationshipCompanyBusinessUnitUpdater(),
            $this->getMerchantRelationshipPostUpdatePlugins(),
        );
    }

    public function createMerchantRelationshipDeleter(): MerchantRelationshipDeleterInterface
    {
        return new MerchantRelationshipDeleter(
            $this->getEntityManager(),
            $this->createMerchantRelationshipReader(),
            $this->getMerchantRelationshipPreDeletePlugins(),
            $this->getMerchantRelationshipPostDeletePlugins(),
        );
    }

    public function createMerchantRelationshipCompanyBusinessUnitUpdater(): MerchantRelationshipCompanyBusinessUnitUpdaterInterface
    {
        return new MerchantRelationshipCompanyBusinessUnitUpdater(
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createMerchantRelationshipCompanyBusinessUnitMapper(),
        );
    }

    public function createMerchantRelationshipCompanyBusinessUnitMapper(): MerchantRelationshipCompanyBusinessUnitMapperInterface
    {
        return new MerchantRelationshipCompanyBusinessUnitMapper();
    }

    public function createMerchantRelationshipReader(): MerchantRelationshipReaderInterface
    {
        return new MerchantRelationshipReader(
            $this->getRepository(),
            $this->createMerchantRelationshipExpander(),
            $this->createMerchantRelationshipCriteriaMapper(),
            $this->getMerchantRelationshipExpanderPlugins(),
        );
    }

    public function createMerchantRelationshipCriteriaMapper(): MerchantRelationshipCriteriaMapperInterface
    {
        return new MerchantRelationshipCriteriaMapper();
    }

    public function createMerchantRelationshipKeyGenerator(): MerchantRelationshipKeyGeneratorInterface
    {
        return new MerchantRelationshipKeyGenerator($this->getRepository());
    }

    public function createMerchantRelationshipExpander(): MerchantRelationshipExpanderInterface
    {
        return new MerchantRelationshipExpander($this->getRepository());
    }

    public function createMerchantRelationshipCreateValidator(): MerchantRelationshipValidatorInterface
    {
        return new MerchantRelationshipCreateValidator(
            [
                $this->createMerchantRelationshipKeyUniqueValidatorRule(),
                $this->createMerchantReferenceExistsValidatorRule(),
                $this->createOwnerCompanyBusinessUnitExistsValidatorRule(),
                $this->createAssignedCompanyBusinessUnitAllowedCreateValidatorRule(),
            ],
            $this->getMerchantRelationshipCreateValidatorPlugins(),
        );
    }

    public function createMerchantRelationshipUpdateValidator(): MerchantRelationshipValidatorInterface
    {
        return new MerchantRelationshipUpdateValidator(
            [
                $this->createOwnerCompanyBusinessUnitAllowedValidatorRule(),
                $this->createAssignedCompanyBusinessUnitAllowedUpdateValidatorRule(),
            ],
            $this->getMerchantRelationshipUpdateValidatorPlugins(),
        );
    }

    public function createMerchantReferenceExistsValidatorRule(): MerchantRelationshipValidatorRuleInterface
    {
        return new MerchantReferenceExistsValidatorRule(
            $this->getMerchantFacade(),
        );
    }

    public function createMerchantRelationshipKeyUniqueValidatorRule(): MerchantRelationshipValidatorRuleInterface
    {
        return new MerchantRelationshipKeyUniqueValidatorRule($this->createMerchantRelationshipReader());
    }

    public function createOwnerCompanyBusinessUnitExistsValidatorRule(): MerchantRelationshipValidatorRuleInterface
    {
        return new OwnerCompanyBusinessUnitExistsValidatorRule(
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    public function createOwnerCompanyBusinessUnitAllowedValidatorRule(): MerchantRelationshipValidatorRuleInterface
    {
        return new OwnerCompanyBusinessUnitAllowedValidatorRule(
            $this->getRepository(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    public function createAssignedCompanyBusinessUnitAllowedUpdateValidatorRule(): MerchantRelationshipValidatorRuleInterface
    {
        return new AssignedCompanyBusinessUnitAllowedUpdateValidatorRule(
            $this->getRepository(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    public function createAssignedCompanyBusinessUnitAllowedCreateValidatorRule(): MerchantRelationshipValidatorRuleInterface
    {
        return new AssignedCompanyBusinessUnitAllowedCreateValidatorRule(
            $this->getRepository(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    public function createMerchantRelationshipDeleteMailNotificationSender(): MerchantRelationshipDeleteMailNotificationSenderInterface
    {
        return new MerchantRelationshipDeleteMailNotificationSender(
            $this->createCompanyBusinessUnitReader(),
            $this->createMerchantReader(),
            $this->createMerchantRelationshipDeleteMailBuilder(),
            $this->getMailFacade(),
        );
    }

    public function createMerchantRelationshipDeleteMailBuilder(): MerchantRelationshipDeleteMailBuilderInterface
    {
        return new MerchantRelationshipDeleteMailBuilder(
            $this->getConfig(),
            $this->getLocaleFacade(),
        );
    }

    public function createMerchantReader(): MerchantReaderInterface
    {
        return new MerchantReader($this->getMerchantFacade());
    }

    public function createCompanyBusinessUnitReader(): CompanyBusinessUnitReaderInterface
    {
        return new CompanyBusinessUnitReader($this->getCompanyBusinessUnitFacade());
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipPreDeletePluginInterface>
     */
    public function getMerchantRelationshipPreDeletePlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_PRE_DELETE);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipPostCreatePluginInterface>
     */
    public function getMerchantRelationshipPostCreatePlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_POST_CREATE);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipPostUpdatePluginInterface>
     */
    public function getMerchantRelationshipPostUpdatePlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_POST_UPDATE);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipCreateValidatorPluginInterface>
     */
    public function getMerchantRelationshipCreateValidatorPlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_CREATE_VALIDATOR);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipUpdateValidatorPluginInterface>
     */
    public function getMerchantRelationshipUpdateValidatorPlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_UPDATE_VALIDATOR);
    }

    public function getMerchantFacade(): MerchantRelationshipToMerchantFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::FACADE_MERCHANT);
    }

    public function getCompanyBusinessUnitFacade(): MerchantRelationshipToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    public function getMailFacade(): MerchantRelationshipToMailFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::FACADE_MAIL);
    }

    public function getLocaleFacade(): MerchantRelationshipToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipExpanderPluginInterface>
     */
    public function getMerchantRelationshipExpanderPlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_EXPANDER);
    }

    /**
     * @return list<\Spryker\Zed\MerchantRelationshipExtension\Dependency\Plugin\MerchantRelationshipPostDeletePluginInterface>
     */
    public function getMerchantRelationshipPostDeletePlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_POST_DELETE);
    }
}
