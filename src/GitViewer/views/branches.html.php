<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_branches)) $git_branches = array();

?>

<h2>Branches of the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'branches')); ?>
<br class="clear" />
<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'branches_tree',
			array(
				'git_path'=>$git_path,
				'git_history'=>$git_history,
				'git_filesinfos'=>$git_filesinfos,
				'git_branches'=>$git_branches
			)
		);
?>