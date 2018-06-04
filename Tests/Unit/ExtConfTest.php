<?php
namespace StefanFroemken\Essen\Tests\Unit;

/*
 * Copyright (C) 2016  Daniel Siepmann <coding@daniel-siepmann.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

use StefanFroemken\Essen\Configuration\ExtConf;

class ExtConfTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @test
     */
    public function constructorWillSetAllProperties()
    {
        $testArray = [
            'rootUid' => 1,
            'templatePath' => 'EXT:essen/Resources/Private/Templates',
        ];

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['essen'] = serialize($testArray);
        $subject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            ExtConf::class
        );

        $this->assertSame($testArray['rootUid'], $subject->getRootUid());
        $this->assertSame($testArray['templatePath'], $subject->getTemplatePath());
    }
}
