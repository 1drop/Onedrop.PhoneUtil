<?php
/*
 * This file is part of the Onedrop.PhoneUtil package.
 *
 * (c) Onedrop GmbH & Co KG 2017
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
namespace Onedrop\PhoneUtil\Validation\Validator;

use libphonenumber\PhoneNumberUtil;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Flow\I18n;

/**
 * Validator for phone numbers
 * @Flow\Scope("singleton")
 */
class PhoneNumberValidator extends AbstractValidator
{
    /**
     * @var array
     */
    protected $supportedOptions = [
        'locale' => [null, 'The locale that should be used to validate the phone number', 'string'],
    ];
    /**
     * @var I18n\Service
     */
    protected $localizationService;
    /**
     * @var PhoneNumberUtil
     * @Flow\Inject
     */
    protected $phoneNumberUtil;

    /**
     * Check if $value is a parsable phone number either in international
     * format or according to a given locale.
     *
     * @param string $value
     *
     * @return void
     */
    protected function isValid($value)
    {
        if ($this->options['locale'] === null) {
            $locale = $this->localizationService->getConfiguration()->getCurrentLocale();
        } else {
            $locale = new I18n\Locale($this->options['locale']);
        }
        try {
            $phoneNumber = $this->phoneNumberUtil->parse($value, $locale->getRegion());
            if (!$this->phoneNumberUtil->isValidNumber($phoneNumber)) {
                $this->addError('The phone number is not valid', 1507186970);
            }
        } catch (\Exception $e) {
            $this->addError('The format of the phone number could not be recognised', 1507185973);
        }
    }
}
