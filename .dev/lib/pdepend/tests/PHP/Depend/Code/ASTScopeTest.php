<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2011, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 */

require_once 'PHP/Depend/Code/ASTNodeTest.php';

require_once 'PHP/Depend/Code/ASTScope.php';

/**
 * Test case for the {@link PHP_Depend_Code_ASTScope} class.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.pdepend.org/
 */
class PHP_Depend_Code_ASTScopeTest extends PHP_Depend_Code_ASTNodeTest
{
    /**
     * Tests that the scope-statement has the expected start line value.
     *
     * @return void
     * @covers PHP_Depend_Parser
     * @covers PHP_Depend_Code_ASTScope
     * @covers PHP_Depend_Builder_Default
     * @group pdepend
     * @group pdepend::ast
     * @group unittest
     */
    public function testScopeHasExpectedStartLine()
    {
        $stmt = $this->_getFunctionScope(__METHOD__);
        $this->assertEquals(3, $stmt->getStartLine());
    }

    /**
     * Tests that the scope-statement has the expected start column value.
     *
     * @return void
     * @covers PHP_Depend_Parser
     * @covers PHP_Depend_Code_ASTScope
     * @covers PHP_Depend_Builder_Default
     * @group pdepend
     * @group pdepend::ast
     * @group unittest
     */
    public function testScopeHasExpectedStartColumn()
    {
        $stmt = $this->_getFunctionScope(__METHOD__);
        $this->assertEquals(1, $stmt->getStartColumn());
    }

    /**
     * Tests that the scope-statement has the expected end line value.
     *
     * @return void
     * @covers PHP_Depend_Parser
     * @covers PHP_Depend_Code_ASTScope
     * @covers PHP_Depend_Builder_Default
     * @group pdepend
     * @group pdepend::ast
     * @group unittest
     */
    public function testScopeHasExpectedEndLine()
    {
        $stmt = $this->_getFunctionScope(__METHOD__);
        $this->assertEquals(8, $stmt->getEndLine());
    }

    /**
     * Tests that the scope-statement has the expected end column value.
     *
     * @return void
     * @covers PHP_Depend_Parser
     * @covers PHP_Depend_Code_ASTScope
     * @covers PHP_Depend_Builder_Default
     * @group pdepend
     * @group pdepend::ast
     * @group unittest
     */
    public function testScopeHasExpectedEndColumn()
    {
        $stmt = $this->_getFunctionScope(__METHOD__);
        $this->assertEquals(1, $stmt->getEndColumn());
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     *
     * @return PHP_Depend_Code_ASTScope
     */
    private function _getFunctionScope($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase, PHP_Depend_Code_ASTScope::CLAZZ
        );
    }
}