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
namespace Onedrop\PhoneUtil\Eel\Helper;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n;

class PhoneHelper implements ProtectedContextAwareInterface
{
    /**
     * @var I18n\Service
     */
    protected $localizationService;
    /**
     * @var PhoneNumberUtil
     * @Flow\Inject
     */
    protected $phoneUtil;
    /**
     * @var PhoneNumberOfflineGeocoder
     * @Flow\Inject
     */
    protected $geocoder;

    /**
     * @param string $number
     * @param string $locale
     *
     * @return string
     */
    public function toDiallableNumber(string $number, $locale = null) : string
    {
        if ($locale === null) {
            $locale = $this->localizationService->getConfiguration()->getCurrentLocale();
        } else {
            $locale = new I18n\Locale($locale);
        }
        try {
            return $this->phoneUtil->normalizeDiallableCharsOnly(
                $this->phoneUtil->format(
                    $this->phoneUtil->parse($number, $locale->getRegion()),
                    PhoneNumberFormat::INTERNATIONAL
                )
            );
        } catch (\Exception $e) {
            return 'Unknown phone number format';
        }
    }

    /**
     * @param string $number
     * @param string $locale
     *
     * @return string
     */
    public function geocode(string $number, $locale = null): string
    {
        if ($locale === null) {
            $locale = $this->localizationService->getConfiguration()->getCurrentLocale();
        } else {
            $locale = new I18n\Locale($locale);
        }
        try {
            $number = $this->phoneUtil->parse($number, $locale->getRegion());
            return $this->geocoder->getDescriptionForNumber($number, $locale->getRegion());
        } catch (\Exception $e) {
            return 'Unknown phone number format';
        }
    }

    /**
     * @param string $text
     * @param string $locale
     *
     * @return array
     */
    public function extractNumbers(string $text, $locale = null): array
    {
        if ($locale === null) {
            $locale = $this->localizationService->getConfiguration()->getCurrentLocale();
        } else {
            $locale = new I18n\Locale($locale);
        }
        $numbers = [];
        $possibleMatches = $this->phoneUtil->findNumbers($text, $locale->getRegion());
        foreach ($possibleMatches as $possibleMatch) {
            $numbers[] = $possibleMatch->number();
        }
        return $numbers;
    }

    /**
     * @param  string $methodName
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
