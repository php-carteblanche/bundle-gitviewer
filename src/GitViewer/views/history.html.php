<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_tree)) $git_tree = array();

?>

<h2>History of the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'history')); ?>
<br class="clear" />

<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'commits_tree',
			array(
				'git_path'=>$git_path,
				'git_history'=>$git_history
			)
		);
?>