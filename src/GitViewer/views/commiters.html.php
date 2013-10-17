<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_commiters)) $git_commiters = array();
if (empty($commiter_name)) $commiter_name = false;

?>

<h2>Commiters of the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'commiters')); ?>
<br class="clear" />
<?php if (!empty($commiter_name)) : ?>
<p>Activity of commiter <a href="mailto:<?php
    echo $git_commiters[$commiter_name]['email'];
?>"><?php echo $git_commiters[$commiter_name]['name']; ?></a> : <?php echo $git_commiters[$commiter_name]['commits']; ?> commits.</p>
<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'commits_tree',
			array(
				'git_path'=>$git_path,
				'git_history'=>$git_history
			)
		);
?>
<?php else : ?>
<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'commiters_tree',
			array(
				'git_path'=>$git_path,
				'git_history'=>$git_history,
				'git_filesinfos'=>$git_filesinfos,
                'git_commiters'=>$git_commiters
			)
		);
?>
<?php endif; ?>