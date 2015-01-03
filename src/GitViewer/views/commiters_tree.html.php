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
if (empty($git_commiters)) $git_commiters = array();

?>
<table class="gitapi commiters_tree">
<thead>
    <th>Name</th>
    <th>Email</th>
    <th>Number of commits</th>
</thead>
<tbody>

<?php foreach($git_commiters as $_item) : ?>
	<tr class="gitapi_commit_tree gittree_item">
	    <td>
            <a href="<?php echo build_url(array(
                'controller'=>'gitViewer', 'action'=>'commiter', 'name'=>$_item['name']
            )); ?>" title="See this commiter activity">
            <?php echo $_item['name']; ?>
            </a>
	    </td>
	    <td>
            <a href="mailto:<?php echo $_item['email']; ?>"><?php
                echo $_item['email'];
            ?></a>
	    </td>
	    <td>
            <?php echo $_item['commits']; ?>
	    </td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
