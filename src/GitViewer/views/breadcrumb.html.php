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

if (empty($git_path)) return '';
if (empty($path)) $path = '';

$pathes = explode('/', $path);
$basepath = '';

?>
<div class="git breadcrumb">
    <a href="<?php echo build_url(array(
	    'controller'=>'gitViewer', 'action'=>'tree'
    )); ?>"><?php echo basename($git_path); ?></a>
<?php foreach ($pathes as $_path) : ?>
    <?php if (!empty($_path) && $_path!=='.') : ?>

    <?php $basepath .= (strlen($basepath) ? '/' : '').$_path; ?>
    &nbsp;/&nbsp;
    <a href="<?php echo build_url(array(
	    'controller'=>'gitViewer', 'action'=>'tree', 'dir'=>$basepath
    )); ?>"><?php echo $_path; ?></a>

    <?php endif; ?>
<?php endforeach; ?>
</div>
