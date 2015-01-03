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
if (empty($git_history)) $git_history = array();
if (empty($git_filesinfos)) $git_filesinfos = array();
if (empty($git_tags)) $git_tags = array();

?>
<table class="gitapi tags_tree">
<thead>
    <th>Tag</th>
    <th>Message</th>
    <th>Download</th>
</thead>
<tbody>

<?php foreach($git_tags as $_tag) : ?>
	<tr class="gitapi_tree gittree_item">
	    <td>
    	    <strong><?php echo $_tag['tag_name']; ?></strong>
	    </td>
	    <td>
	        <?php echo $_tag['message']; ?>
	    </td>
	    <td>

	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'exportTag', 'tagname'=>$_tag['tag_name']
	        )); ?>" title="Download a tarball of this tag">tar format</a>
            &nbsp;|&nbsp;
	        <a href="<?php echo build_url(array(
	            'controller'=>'gitViewer', 'action'=>'exportTag', 'tagname'=>$_tag['tag_name'], 'format'=>'zip'
	        )); ?>" title="Download a zip of this tag">zip format</a>

	    </td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
