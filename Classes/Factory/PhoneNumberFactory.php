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
namespace Onedrop\PhoneUtil\Factory;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class PhoneNumberFactory
{
    /**
     * @return PhoneNumberUtil
     */
    public function getUtilInstance()
    {
        return PhoneNumberUtil::getInstance();
    }

    /**
     * @return PhoneNumberOfflineGeocoder
     */
    public function getOfflineGeocoderInstance()
    {
        return PhoneNumberOfflineGeocoder::getInstance();
    }
}
