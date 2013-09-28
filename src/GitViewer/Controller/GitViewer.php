<?php
/**
 * CarteBlanche - PHP framework package - Git API bundle
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/carte-blanche>
 */

namespace GitViewer\Controller;

use \CarteBlanche\CarteBlanche;
use \CarteBlanche\App\Container;
use \CarteBlanche\App\Abstracts\AbstractController;
use \GitApi\GitApi;
use \GitApi\Repository;

/**
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
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

		return array(self::$views_dir.'tree.htm', array(
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

		return array(self::$views_dir.'raw.htm', array(
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

		return array(self::$views_dir.'history.htm', array(
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

		return array(self::$views_dir.'branches.htm', array(
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

		return array(self::$views_dir.'tags.htm', array(
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

		return array(self::$views_dir.'commiters.htm', array(
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

		return array(self::$views_dir.'commit.htm', array(
			'title'=>'GIT Viewer',
            'git_path'=>$_git->getRepositoryPath(),
            'git_commit'=>$commit,
		));
	}

    public function exportAction($format = 'tar')
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $tarball = $_git->buildTarball(CarteBlanche::getPath('tmp_path'), 'latest', $format);
		$this->getContainer()->get('response')->download( $tarball, $format==='tar' ? 'application/tar' : 'application/zip' );
    }

    public function exportTagAction($tagname, $format = 'tar')
    {
        $_git = GitApi::open($this->_getRepositoryPath());
        $tarball = $_git->buildTagTarball($tagname, CarteBlanche::getPath('tmp_path'), 'auto', $format);
		$this->getContainer()->get('response')->download( $tarball, $format==='tar' ? 'application/tar' : 'application/zip' );
    }

}

// Endfile