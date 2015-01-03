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
if (empty($git_commit)) $git_commit = array();

?>
<style type="text/css">
table.git_diff td { padding: 0 0.2em; }
table.git_diff td.line-number { text-align: right; }
table.git_diff pre { margin: 0; border: none; padding: 0 0.6em; }
tr.line-type-added pre { color: green; }
tr.line-type-removed pre { color: red; }
</style>
<?php foreach ($git_commit['diff'] as $diff) : ?>
<div class="diff_item">

    <h3><?php echo (
        $diff['type']==='D' ? $diff['from_name'] : $diff['to_name']
    ); ?>
    &nbsp;:&nbsp;<em><?php echo (
        \GitApi\Repository::$file_status_flags[ $diff['type'] ]
    ); ?></em>
    </h3>
    <?php foreach ($diff['diff'] as $change) : 
        $line_original = min($change['from_line'], $change['to_line']);
        $line_left = $change['from_line'];
        $line_right = $change['to_line'];
    ?>
    <table class="git_diff" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>OLD</th>
            <th>NEW</th>
            <th><?php echo $change['git_hunk_header']; ?></th>
        </tr>
    </thead>
    <tbody>

        <?php if (!empty($change['lines'])) foreach ($change['lines'] as $line) : 
            $char = strlen($line) ? $line[0] : '~';
        ?>
        <tr class="line-type-<?php 
            if ($char==='+') echo 'added'; 
            elseif ($char==='-') echo 'removed'; 
            else echo 'neutral'; 
        ?>">
            <td class="line-number line-number-left"><?php 
                echo ($char==='+' ? '' : $line_left++); 
            ?></td>
            <td class="line-number line-number-right"><?php 
                echo ($char==='-' ? '' : $line_right++); 
            ?></td>
            <td class="line-code"><pre><?php echo htmlspecialchars($line); ?></pre></td>
        </tr>
        <?php endforeach; ?>

    </tbody>
    </table>
    <?php endforeach; ?>

</div>
<?php endforeach; ?>