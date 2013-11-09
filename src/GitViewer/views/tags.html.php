<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_tags)) $git_tags = array();

?>

<h2>Tags of the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'tags')); ?>
<br class="clear" />
<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'tags_tree',
			array(
				'git_path'=>$git_path,
				'git_history'=>$git_history,
				'git_filesinfos'=>$git_filesinfos,
				'git_tags'=>$git_tags
			)
		);
?>