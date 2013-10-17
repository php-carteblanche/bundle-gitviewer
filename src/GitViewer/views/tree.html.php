<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_tree)) $git_tree = array();
if (!isset($dir)) $dir = '';
if (!isset($is_subdir)) $is_subdir = false;

?>

<h2>Files tree of the GIT repository <em><?php echo basename($git_path); ?></em></h2>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'menu',array('current'=>'tree')); ?>
<br class="clear" />

<p class="gitapi last_commit">
    Last commit on this repository on 
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

<p class="gitapi last_commit">
    Number of commits for this branch 
    <a href="<?php echo build_url(array(
        'controller'=>'gitViewer','action'=>'history'
    )); ?>" title="See the full repository history">
    <?php echo count($git_history); ?>
    </a>
</p>

<p class="gitapi last_commit">
    Downloads :
	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'export'
	        )); ?>" title="Download a tarball of this repository">tar format</a>
            &nbsp;|&nbsp;
	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'export', 'format'=>'zip'
	        )); ?>" title="Download a zip of this repository">zip format</a>
</p>

<br class="clear" />
<?php
		echo view(
			\GitViewer\Controller\GitViewer::$views_dir.'files_tree',
			array(
				'git_path'=>$git_path,
				'git_history'=>$git_history,
				'git_filesinfos'=>$git_filesinfos,
				'git_tree'=>$git_tree,
                'dir'=>$dir,
				'is_subdir'=>$is_subdir
			)
		);
?>