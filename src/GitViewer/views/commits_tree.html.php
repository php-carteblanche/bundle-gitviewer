<?php

if (empty($git_path)) return '';
if (empty($git_history)) $git_history = array();

?>
<table class="gitapi files_tree">
<thead>
    <th>Ref</th>
    <th>Date</th>
    <th>Author</th>
    <th>Commit info</th>
</thead>
<tbody>

<?php foreach($git_history as $_item) : ?>
	<tr class="gitapi_commit_tree gittree_item">
	    <td>
            <a href="<?php echo build_url(array(
    			'controller'=>'gitViewer','action'=>'commit', 'hash'=>$_item['commit-abbrev']
            )); ?>"><?php
                echo $_item['commit-abbrev'];
            ?></a>
	    </td>
	    <td>
            <?php echo $_item['DateTime']->format('F j, Y, g:i a'); ?>
	    </td>
	    <td>
            <a href="<?php echo build_url(array(
    			'controller'=>'gitViewer','action'=>'commiter', 'name'=>$_item['author_name']
            )); ?>"><?php
                echo $_item['author_name'];
            ?></a>
	    </td>
	    <td>
            <strong><?php echo $_item['title']; ?></strong>
            <p><?php echo $_item['message']; ?></p>
            <small><strong>Changes:</strong>&nbsp;
<?php if (!empty($_item['changes'])) {
    $modifs = array();
    if (!empty($_item['changes']['addition'])) $modifs[] = count($_item['changes']['addition']).' new file(s)';
    if (!empty($_item['changes']['deletion'])) $modifs[] = count($_item['changes']['deletion']).' file(s) deleted';
    if (!empty($_item['changes']['rename-edit'])) $modifs[] = count($_item['changes']['rename-edit']).' file(s) renamed';
    if (!empty($_item['changes']['copy-edit'])) $modifs[] = count($_item['changes']['copy-edit']).' file(s) copied';
    if (!empty($_item['changes']['modification'])) $modifs[] = count($_item['changes']['modification']).' file(s) updated';
    if (!empty($_item['changes']['type change'])) $modifs[] = count($_item['changes']['type change']).' file(s) type(s) changed';
    echo join(' - ', $modifs);
}
?>
        </small>
	    </td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
