<?php
/**
 * CarteBlanche - PHP framework package - Simple Viewer bundle
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License Apache-2.0 <http://www.apache.org/licenses/LICENSE-2.0.html>
 * Sources <http://github.com/php-carteblanche/carteblanche>
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