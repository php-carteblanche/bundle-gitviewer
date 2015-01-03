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
if (empty($git_last)) $git_last = array();
if (empty($file_raw)) $file_raw = '';
if (empty($file_path)) $file_path = '';
if (!isset($is_img)) $is_img = false;
if (!isset($img_data)) $img_data = '';

?>

<h2>Raw content of file <em><?php echo $file_path; ?></em> from the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'tree')); ?>
<br class="clear" />

<p class="gitapi last_commit">
    Last commit on this file on 
    <?php echo $git_last['DateTime']->format('F j, Y, g:i a'); ?>
     by  
    <a href="<?php echo build_url(array(
        'controller'=>'gitViewer','action'=>'commiter', 'name'=>$git_last['author_name']
    )); ?>">
    <?php echo $git_last['author_name']; ?>
    </a>
    &nbsp;:&nbsp;
    <em><?php echo $git_last['title']; ?></em>
</p>

<br class="clear" />

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'breadcrumb',array('git_path'=>$git_path,'path'=>dirname($file_path))); ?>
<br class="clear" />

<?php if (0!==$is_img) : ?>
    <img src="<?php echo $img_data; ?>" alt="<?php echo $file_path; ?>" />
<?php else: ?>
<pre class="code">
<?php echo htmlspecialchars($file_raw); ?>
</pre>
<?php endif; ?>