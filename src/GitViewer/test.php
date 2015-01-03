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

echo '<pre>';
$a = \GitApi\GitApi::open('/Applications/MAMP/htdocs/GitHub_projects/jQuery-AccessKey');
echo '<br />new GitApi object : '.$a->getRepositoryPath();
echo '<br />';
var_export($a);

echo '<br />';
echo '<br />getCommitersList : ';
var_export($a->getCommitersList());

echo '<br />';
echo '<br />getBranchesList : ';
$branches = $a->getBranchesList();
var_export($branches);

echo '<br />';
echo '<br />getCommitsList : ';
$history = $a->getCommitsList();
var_export($history);

echo '<br />';
echo '<br />getCommitInfos for commit : dfdc1f17336deb5aae8d0438098479b328d773fb<br />';
var_export($a->getCommitInfos('dfdc1f17336deb5aae8d0438098479b328d773fb'));

echo '<br />';
echo '<br />getCurrentBranch : ';
$br = $a->getCurrentBranch();
var_export($br);

echo '<br />';
echo '<br />getDescription : ';
var_export($a->getDescription());

echo '<br />';
echo '<br />getTagsList : ';
var_export($a->getTagsList());

echo '<br />';
echo '<br />getLastCommitInfos : ';
var_export($a->getLastCommitInfos());

echo '<br />';
echo '<br />getTree : ';
var_export($a->getTree());

echo '<br />';
$first_dir = null;
foreach($a->getTree() as $item) {
    if ($item['type']==='tree') {
        $first_dir = $item['path'];
        break;
    }
}
echo '<br />getTree for first dir: "'.$first_dir.'" : ';
var_export($a->getTree('HEAD', $first_dir));

echo '<br />';
echo '<br />getFilesInfo : ';
var_export($a->getFilesInfo());

echo '<br />';
echo '<br />getRecursiveTree : ';
var_export($a->getRecursiveTree());

echo '<br />';
echo '<br />getCommitsHistory : ';
var_export($a->getCommitsHistory());

echo '<br />';
echo '<hr />';
echo '<br />commands cache : ';
var_export($a->getGitConsole()->getCache());


$b = \GitApi\GitApi::open('https://github.com/PieroWbmstr/Extended_Markdown.git');
var_export($b);

exit('yo');
