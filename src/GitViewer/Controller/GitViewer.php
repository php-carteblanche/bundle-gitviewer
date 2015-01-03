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

namespace GitViewer\Controller;

use \CarteBlanche\CarteBlanche;
use \CarteBlanche\App\Container;
use \CarteBlanche\Abstracts\AbstractController;
use \GitApi\GitApi;
use \GitApi\Repository;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class GitViewer extends AbstractController
{

    /**
     * The GIT repository path for tests
     */
    var $test_repository_path = '/Users/pierrecassat/Sites/GitHub_projects/carte-blanche';

    /**
     * The GIT repository path
     */
    var $repository_path;

    /**
     * The directory where to search the views files
     */
    static $views_dir = 'GitViewer/views/';

    protected function _getRepositoryPath()
    {
        if (empty($this->repository_path)) {
            $_git_path = $this->getContainer()->get('request')->getUrlArg('git_path');

            if (empty($_git_path)) {
                $_git_path = $this->getContainer()->get('session')->get('gitviewer_path');
            }

            $cfg = CarteBlanche::getContainer()->get('config')
                ->get('repository');
            if (empty($_git_path) && !empty($cfg)) {
                $_git_path = isset($cfg['default']) ? $cfg['default'] : null;
            }

            if (empty($_git_path)) $_git_path = $this->test_repository_path;
            $this->repository_path = $_git_path;
        }
        return $this->repository_path;
    }

    /**
     */
    public function indexAction()
    {
        return $this->treeAction();
    }

    public function treeAction($dir = null)
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $history = $_git->getCommitsHistory();
        $infos = $_git->getFilesInfo();
        $last = $_git->getLastCommitInfos();

        $tree = $_git->getTree('HEAD', $dir);
        foreach ($tree as $i=>$entry) {
            if (!empty($entry['path']) && !isset($entry['last_commit'])) {
                $tree[$i]['last_commit'] = $_git->getLastCommitInfos($entry['path']);
            }
        }

        return array(self::$views_dir.'tree', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_history'=>$history,
            'git_filesinfos'=>$infos,
            'git_last'=>$last,
            'git_tree'=>$tree,
            'dir'=>$dir,
            'is_subdir'=>!empty($dir),
        ));
    }

    public function rawAction($object = null)
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $history = $_git->getCommitsHistory();
        $infos = $_git->getFilesInfo();
        $tree = $_git->getRecursiveTree();

        $raw = $_git->getRaw($object);

        $file_path = $last = null;
        foreach($tree as $item) {
            if ($item['object']===$object) {
                $file_path = $item['path'];
            }
        }
        if (isset($infos[$file_path]) && isset($history[$infos[$file_path]])) {
            $last = $history[$infos[$file_path]];
        }

        return array(self::$views_dir.'raw', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'file_raw'=>$raw,
            'is_img'=>$_git->isImageContent($raw),
            'img_data'=>$_git->getRawImageData($raw),
            'file_path'=>$file_path,
            'git_history'=>$history,
            'git_last'=>$last
        ));
    }

    public function historyAction()
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $history = $_git->getCommitsHistory();
        $infos = $_git->getFilesInfo();
        $tree = $_git->getTree();
        $last = $_git->getLastCommitInfos();

        foreach ($history as $i=>$entry) {
            if (!isset($history[$i]['changes'])) {
                $history[$i]['changes'] = $_git->getCommitChanges($i);
            }
        }

        return array(self::$views_dir.'history', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_history'=>$history,
            'git_filesinfos'=>$infos,
            'git_last'=>$last,
            'git_tree'=>$tree
        ));
    }

    public function branchesAction()
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $history = $_git->getCommitsHistory();
        $infos = $_git->getFilesInfo();
        $last = $_git->getLastCommitInfos();
        $branches = $_git->getBranchesList();

        return array(self::$views_dir.'branches', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_history'=>$history,
            'git_filesinfos'=>$infos,
            'git_last'=>$last,
            'git_branches'=>$branches
        ));
    }

    public function tagsAction()
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $history = $_git->getCommitsHistory();
        $infos = $_git->getFilesInfo();
        $last = $_git->getLastCommitInfos();
        $tags = $_git->getTagsList();

        return array(self::$views_dir.'tags', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_history'=>$history,
            'git_filesinfos'=>$infos,
            'git_last'=>$last,
            'git_tags'=>$tags
        ));
    }

    public function commiterAction($name = null)
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $history = $_git->getCommitsHistory();
        $infos = $_git->getFilesInfo();
        $commiters = $_git->getCommitersList();

        if (!empty($name)) {
            foreach($history as $i=>$item) {
                if (!isset($item['author_name']) || $item['author_name']!==$name)
                    unset($history[$i]);
            }
        }

        return array(self::$views_dir.'commiters', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_history'=>$history,
            'git_filesinfos'=>$infos,
            'git_commiters'=>$commiters,
            'commiter_name'=>$name
        ));
    }

    public function commitAction($hash)
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $commit = $_git->getCommitInfos($hash);

        return array(self::$views_dir.'commit', array(
            'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_commit'=>$commit,
        ));
    }

    public function exportAction($format = 'tar')
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $tarball = $_git->buildTarball(CarteBlanche::getFullPath('web_tmp_dir'), 'latest', $format);
        $this->getContainer()->get('response')->download( $tarball, $format==='tar' ? 'application/tar' : 'application/zip' );
    }

    public function exportTagAction($tagname, $format = 'tar')
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $tarball = $_git->buildTagTarball($tagname, CarteBlanche::getFullPath('web_tmp_dir'), 'auto', $format);
        $this->getContainer()->get('response')->download( $tarball, $format==='tar' ? 'application/tar' : 'application/zip' );
    }

}

// Endfile