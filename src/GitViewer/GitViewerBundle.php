<?php
/**
 * This file is part of the CarteBlanche PHP framework.
 *
 * (c) Pierre Cassat <me@e-piwi.fr> and contributors
 *
 * License Apache-2.0 <http://github.com/php-carteblanche/carteblanche/blob/master/LICENSE>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GitViewer;

use \CarteBlanche\CarteBlanche;

use \Library\Helper\Directory as DirectoryHelper;

class GitViewerBundle
{

    protected static $bundle_config_file = 'gitviewer_config.ini';

    public function __construct()
    {
        $cfgfile = \CarteBlanche\App\Locator::locateConfig(self::$bundle_config_file);
        if (file_exists($cfgfile)) {
            $cfg = CarteBlanche::getContainer()->get('config')
                ->load($cfgfile, true, 'git_viewer')
                ->get('repository');
        }
    }

}

// Endfile