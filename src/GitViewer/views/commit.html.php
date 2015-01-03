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
if (empty($git_commit)) $git_commit = array();

?>

<h2>Diff of commit <em><?php echo $git_commit['commit-abbrev']; ?></em> on the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'history')); ?>
<br class="clear" />

<div>
    <p>Commit <strong><?php echo $git_commit['commit-abbrev']; ?></strong> (parent commit <a href="<?php
        echo build_url(array(
    			'controller'=>'gitViewer','action'=>'commit', 'hash'=>$git_commit['parents-abbrev']
        ));
    ?>"><?php
        echo $git_commit['parents-abbrev'];
    ?></a>)</p>
    <p>Authored at <?php echo $git_commit['DateTime']->format('F j, Y, g:i a'); ?>, by <a href="<?php echo build_url(array(
    			'controller'=>'gitViewer','action'=>'commiter', 'name'=>$git_commit['author_name']
            )); ?>"><?php
                echo $git_commit['author_name'];
            ?></a></p>
    <p><strong><?php echo $git_commit['title']; ?></strong></p>
    <p><?php echo $git_commit['message']; ?></p>
    <small><strong>Changes:</strong>&nbsp;
<?php if (!empty($git_commit['changes'])) {
    $modifs = array();
    if (!empty($git_commit['changes']['addition'])) $modifs[] = count($git_commit['changes']['addition']).' new file(s)';
    if (!empty($git_commit['changes']['deletion'])) $modifs[] = count($git_commit['changes']['deletion']).' file(s) deleted';
    if (!empty($git_commit['changes']['rename-edit'])) $modifs[] = count($git_commit['changes']['rename-edit']).' file(s) renamed';
    if (!empty($git_commit['changes']['copy-edit'])) $modifs[] = count($git_commit['changes']['copy-edit']).' file(s) copied';
    if (!empty($git_commit['changes']['modification'])) $modifs[] = count($git_commit['changes']['modification']).' file(s) updated';
    if (!empty($git_commit['changes']['type change'])) $modifs[] = count($git_commit['changes']['type change']).' file(s) type(s) changed';
    echo join(' - ', $modifs);
}
?>
    </small>
</div>

<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'commit_diff',
			array(
				'git_path'=>$git_path,
				'git_commit'=>$git_commit
			)
		);
?>