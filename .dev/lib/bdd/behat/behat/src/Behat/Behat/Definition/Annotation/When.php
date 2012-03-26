<?php

namespace Behat\Behat\Definition\Annotation;

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * When type step definition.
 *
 * @author      Konstantin Kudryashov <ever.zet@gmail.com>
 */
class When extends Definition
{
    /**
     * @see     Behat\Behat\Definition\DefinitionInterface::getType()
     */
    public function getType()
    {
        return 'When';
    }
}
