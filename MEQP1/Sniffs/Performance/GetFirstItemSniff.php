<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MEQP1\Sniffs\Performance;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Class GetFirstItemSniff
 * Detects possible improper usage of 'getFirstItem' method.
 */
class GetFirstItemSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * String representation of warning.
     */
    protected $warningMessage = 'getFirstItem() does not limit the result of collection load to one item.';

    /**
     * Warning violation code.
     */
    protected $warningCode = 'FoundGetFirstItem';

    /**
     * Observed methods.
     *
     * @var array
     */
    protected $methods = ['getFirstItem'];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_STRING];
    }

    /**
     * @inheritdoc
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (!in_array($tokens[$stackPtr]['content'], $this->methods)) {
            return;
        }
        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
        if ($tokens[$prevToken]['code'] !== T_OBJECT_OPERATOR) {
            return;
        }
        $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
    }
}
