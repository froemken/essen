<?php

namespace StefanFroemken\Essen\Configuration;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ExtConf implements SingletonInterface
{
    /**
     * root uid for categories.
     *
     * @var int
     */
    protected $rootUid = 0;

    /**
     * templatePath
     *
     * @var string
     */
    protected $templatePath = '';

    /**
     * email from address.
     *
     * @var string
     */
    protected $emailFromAddress = '';

    /**
     * email from name.
     *
     * @var string
     */
    protected $emailFromName = '';

    /**
     * email to address.
     *
     * @var string
     */
    protected $emailToAddress = '';

    /**
     * email to name.
     *
     * @var string
     */
    protected $emailToName = '';

    /**
     * constructor of this class
     * This method reads the global configuration and calls the setter methods.
     */
    public function __construct()
    {
        // get global configuration
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['essen']);
        if (is_array($extConf) && count($extConf)) {
            // call setter method foreach configuration entry
            foreach ($extConf as $key => $value) {
                ObjectAccess::setProperty(
                    $this,
                    $key,
                    $value
                );
            }
        }
    }

    /**
     * getter for rootUid.
     *
     * @return int
     */
    public function getRootUid()
    {
        if (empty($this->rootUid)) {
            return 0;
        } else {
            return $this->rootUid;
        }
    }

    /**
     * setter for rootUid.
     *
     * @param int $rootUid
     */
    public function setRootUid($rootUid)
    {
        $this->rootUid = (int)$rootUid;
    }

    /**
     * Returns the templatePath
     *
     * @return string $templatePath
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * Sets the templatePath
     *
     * @param string $templatePath
     * @return void
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = (string)$templatePath;
    }

    /**
     * getter for email from address.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getEmailFromAddress()
    {
        if (empty($this->emailFromAddress)) {
            $senderMail = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'];
            if (empty($senderMail)) {
                throw new \Exception('You have forgotten to set a sender email address in extension configuration or in install tool');
            } else {
                return $senderMail;
            }
        } else {
            return $this->emailFromAddress;
        }
    }

    /**
     * setter for email from address.
     *
     * @param string $emailFromAddress
     */
    public function setEmailFromAddress($emailFromAddress)
    {
        $this->emailFromAddress = (string)$emailFromAddress;
    }

    /**
     * getter for email from name.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getEmailFromName()
    {
        if (empty($this->emailFromName)) {
            $senderName = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'];
            if (empty($senderName)) {
                throw new \Exception('You have forgotten to set a sender name in extension configuration or in install tool');
            } else {
                return $senderName;
            }
        } else {
            return $this->emailFromName;
        }
    }

    /**
     * setter for emailFromName.
     *
     * @param string $emailFromName
     */
    public function setEmailFromName($emailFromName)
    {
        $this->emailFromName = (string)$emailFromName;
    }

    /**
     * getter for email to address.
     *
     * @return string
     */
    public function getEmailToAddress()
    {
        return $this->emailToAddress;
    }

    /**
     * setter for email to address.
     *
     * @param string $emailToAddress
     */
    public function setEmailToAddress($emailToAddress)
    {
        $this->emailToAddress = (string)$emailToAddress;
    }

    /**
     * getter for email to name.
     *
     * @return string
     */
    public function getEmailToName()
    {
        return $this->emailToName;
    }

    /**
     * setter for emailToName.
     *
     * @param string $emailToName
     */
    public function setEmailToName($emailToName)
    {
        $this->emailToName = (string)$emailToName;
    }
}
