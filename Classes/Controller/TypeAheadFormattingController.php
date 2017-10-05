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
namespace Onedrop\PhoneUtil\Controller;

use libphonenumber\PhoneNumberUtil;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Mvc\View\JsonView;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n;

/**
 * @Flow\Scope("singleton")
 */
class TypeAheadFormattingController extends ActionController
{
    /**
     * @var string
     */
    protected $defaultViewObjectName = JsonView::class;
    /**
     * @var I18n\Service
     * @Flow\Inject
     */
    protected $localizationService;
    /**
     * @var PhoneNumberUtil
     * @Flow\Inject
     */
    protected $phoneNumberUtil;

    /**
     * @param string $value
     * @param string $locale
     */
    public function asYouTypeAction(string $value, $locale = null)
    {
        if ($locale === null) {
            $locale = $this->localizationService->getConfiguration()->getCurrentLocale();
        } else {
            $locale = new I18n\Locale($locale);
        }
        $fmt = $this->phoneNumberUtil->getAsYouTypeFormatter($locale->getRegion());
        $result = '';
        for ($i = 0; $i < strlen($value); ++$i) {
            $result = $fmt->inputDigit($value[$i]);
        }
        $this->view->assign('value', $result);
    }
}
