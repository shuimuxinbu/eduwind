<?php

class SearchController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('*'),
		),
		);
	}
	public function actions()
	{

	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	/**
	 * Lists all models.
	 */
	public function actionIndex($pageSize=10)
	{
		$keyword=isset($_REQUEST['keyword'])?$_REQUEST['keyword']:"";
		$keyword = trim($keyword);
		$type=isset($_REQUEST['type'])?$_REQUEST['type']:"all";
		if($keyword){
			if(!$type || $type=="all"){
				//搜索全部

				$courseDataProvider = $this->searchCourse($keyword,4);
				$postDataProvider = $this->searchPost($keyword,4);
		//		$peopleDataProvider = $this->searchPeople($keyword,4);
		//		$newsDataProvider = $this->searchNews($keyword,4);
		//		$projectDataProvider = $this->searchProject($keyword,4);
				$userDataProvider = $this->searchUser($keyword,6);
				$groupDataProvider = $this->searchGroup($keyword,6);
                $articleDataProvider = $this->searchArticle($keyword, 6);
				$this->render('all',array('courseDataProvider'=>$courseDataProvider,
								  'postDataProvider'=>$postDataProvider,
			//					  'projectDataProvider'=>$projectDataProvider,
				//				  'newsDataProvider'=>$newsDataProvider,
				//				  'peopleDataProvider'=>$peopleDataProvider,
								  'userDataProvider'=>$userDataProvider,
								  'groupDataProvider'=>$groupDataProvider,
                                  'articleDataProvider'=>$articleDataProvider,
								  'keyword'=>$keyword));
			}else{
				if(class_exists(ucfirst($type))){
					$searcher = "search".ucfirst($type);
					$dataProvider = $this->{$searcher}($keyword);
					$this->render("type",array('dataProvider'=>$dataProvider,'type'=>$type,'keyword'=>$keyword));
				}else{
					$this->render('type_error');
				}
			}

		}else{
			$this->render('keyword_empty');
		}

	}


    /**
     *
     */
    public function searchArticle($keyword='', $pageSize=10)
    {
        return Search::like('Article', array('title', 'id', 'keyword'), $keyword, $pageSize);
    }


	/**
	 * Lists all models.
	 */
	public function searchCourse($keyword="",$pageSize=10)
	{
		return Search::like('Course', array('name'), $keyword, $pageSize);
	}


	/**
	 * Lists all models.
	 */
	public function searchUser($keyword="",$pageSize=10)
	{

		return Search::like('UserInfo', array('name','introduction','bio'), $keyword, $pageSize);
	}


	/**
	 * Lists all models.
	 */
	public function searchPost($keyword="",$pageSize=10)
	{
		return Search::like('Post', array('title'), $keyword, $pageSize);
	}

	/**
	 * Lists all models.
	 */
	public function searchQuestion($keyword="",$pageSize=10)
	{
		return Search::like('Question', array('title'), $keyword, $pageSize);
	}

	/**
	 * Lists all models.
	 */
	public function searchGroup($keyword,$pageSize=10)
	{
		return Search::like('Group', array('name'), $keyword, $pageSize);
	}

	/**
	 * Lists all models.
	 */
	public function searchNews($keyword="",$pageSize=10)
	{
		return Search::like('News', array('title','content'), $keyword, $pageSize);
	}

	/**
	 * Lists all models.
	 */
	public function searchProject($keyword="",$pageSize=10)
	{
		return Search::like('Project', array('title','content'), $keyword, $pageSize);
	}

	/**
	 * Lists all models.
	 */
	public function searchPeople($keyword="",$pageSize=10)
	{
		return Search::like('People', array('name','description'), $keyword, $pageSize);
	}

}
