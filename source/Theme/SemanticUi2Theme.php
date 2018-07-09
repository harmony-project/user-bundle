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
 * Semantic UI 2 theme for HarmonyUserBundle
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class SemanticUi2Theme implements ThemeInterface
{
    public function getTemplatePath(): string
    {
        return dirname(__DIR__) . '/Resources/themes/semantic_2';
    }
}
