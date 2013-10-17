<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_tree)) $git_tree = array();

?>

<h2>Overview of the GIT repository <em><?php echo $git_path; ?></em></h2>

<div class="menu">
	<ul>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'tree'
		)); ?>" title="See this repository contents">Files tree</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'history'
		)); ?>" title="See this repository history">History</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'commiters'
		)); ?>" title="See this repository commiters">Commiters</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'tags'
		)); ?>" title="See this repository tags">Tags</a></li>
	</ul>
</div>

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

