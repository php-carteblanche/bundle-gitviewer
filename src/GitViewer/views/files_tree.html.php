<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_tree)) $git_tree = array();
if (!isset($is_subdir)) $is_subdir = false;
if (!isset($dir)) $dir = '';

?>

<?php echo view(\GitViewer\Controller\GitViewer::$views_dir.'breadcrumb',array('git_path'=>$git_path,'path'=>$dir)); ?>
<br class="clear" />

<table class="gitapi files_tree">
<thead>
    <th>Tree</th>
    <th colspan="2">Last commit</th>
    <th>File size</th>
</thead>
<tbody>

<?php if ($is_subdir) : ?>
    <tr>
        <td>
	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'tree', 'dir'=>substr($git_tree[0]['dirname'], 0, strpos($git_tree[0]['dirname'], '/'))	            
	        )); ?>" title="See parent directory">..</a>
        </td>
        <td colspan="2"></td>
    </tr>
<?php endif; ?>

<?php foreach($git_tree as $_item) : ?>
	<tr class="gitapi_tree gittree_item">
	    <td>
<?php if ($_item['type']==='tree') : ?>
	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'tree', 'dir'=>$_item['path']
	        )); ?>" title="See directory contents">
    	        <?php echo $_item['basename']; ?>
    	    </a>
<?php else: ?>
	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'raw', 'object'=>$_item['object']
	        )); ?>" title="See raw content of this file">
    	        <?php echo $_item['basename']; ?>
    	    </a>
<?php endif; ?>
	    </td>
	    <td>
<?php if (!empty($_item['last_commit'])) : ?>
            <?php echo $_item['last_commit']['DateTime']->format('F j, Y, g:i a'); ?>
<?php endif; ?>
	    </td>
	    <td>
<?php if (!empty($_item['last_commit'])) : ?>
            <?php echo $_item['last_commit']['title']; ?>
            [<a href="<?php echo build_url(array(
    			'controller'=>'gitViewer','action'=>'commiter', 'name'=>$_item['last_commit']['author_name']
            )); ?>"><?php
                echo $_item['last_commit']['author_name'];
            ?></a>]
<?php endif; ?>
	    </td>
        <td><?php echo ($_item['size']==='-' ? '-' : $_item['size'].' bytes'); ?></td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
