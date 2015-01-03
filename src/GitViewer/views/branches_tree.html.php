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
if (empty($git_branches)) $git_branches = array();

?>
<table class="gitapi branches_tree">
<thead>
    <th>Branch</th>
    <th colspan="2">Last commit</th>
</thead>
<tbody>

<?php foreach($git_branches as $_item) : ?>
	<tr class="gitapi_tree gittree_item">
	    <td>
    	        <?php echo $_item; ?>
	    </td>
	    <td>

	    </td>
	    <td>

	    </td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
