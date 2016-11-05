<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'StefanFroemken.' . $_EXTKEY,
    'Food',
    array(
        'Food' => 'list, listFast, show, showFast, modifyQuery, new, create',
        'ExtConf' => 'show',
        'Ajax' => 'callAjaxObject',
    ),
    // non-cacheable actions
    array(
        'Food' => 'create',
        'Ajax' => 'callAjaxObject',
    )
);

if (TYPO3_MODE === 'FE') {
    /** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Extbase\Persistence\Generic\Backend::class,
        'beforeGettingObjectData',
        \StefanFroemken\Essen\SignalSlot\ModifyQuery::class,
        'reduceResultSet'
    );
}

if (TYPO3_MODE === 'BE') {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'essen',
        \StefanFroemken\Essen\Dispatch\AjaxRequest::class . '->dispatch'
    );
}

// register eID scripts
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['essen'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('essen') . 'Classes/Ajax/ShowText.php';
