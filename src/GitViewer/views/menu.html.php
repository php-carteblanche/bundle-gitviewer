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

if (empty($current)) $current = 'tree';
?>
<div class="menu">
	<ul>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'tree'
		)); ?>" title="See this repository contents"<?php
		    if ($current==='tree') echo ' class="active"'; 
		?>>Files tree</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'history'
		)); ?>" title="See this repository history"<?php
		    if ($current==='history') echo ' class="active"'; 
		?>>History</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'branches'
		)); ?>" title="See this repository branches list"<?php
		    if ($current==='branches') echo ' class="active"'; 
		?>>Branches</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'tags'
		)); ?>" title="See this repository tags"<?php
		    if ($current==='tags') echo ' class="active"'; 
		?>>Tags</a></li>
		<li><a href="<?php echo build_url(array(
			'controller'=>'gitViewer','action'=>'commiter'
		)); ?>" title="See this repository commiters"<?php
		    if ($current==='commiters') echo ' class="active"'; 
		?>>Commiters</a></li>
	</ul>
</div>
