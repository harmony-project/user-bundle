<?php
/*
 * This file is part of the Harmony package.
 *
 * (c) Tim Goudriaan <tim@harmony-project.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\UserBundle\Theme;

/**
 * Interface for theme definitions
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
interface ThemeInterface
{
    /**
     * Returns the location of the theme templates
     */
    public function getTemplatePath(): string;
}
