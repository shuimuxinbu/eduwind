<?php

class IndexController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
    /**
     * @var TabMenu 视图文件名
     */
    public $viewMenuName = '_view_menu_nopay';

    /**
     * @var 头部 视图文件名
     */
    public $viewHeaderName = '_view_header_nopay';


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
			'actions'=>array('viewRate','index','view', 'posts','lesson','category','rates','counter','alipayNotify'),
			'users'=>array('*'),
			),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
			'actions'=>array('update','setFace','upload','userfollowedcreated',
                'viewPost', 'createRate',
				'userfollowedrecommended','topicfollowed','applypublish',
				'updatetopics','fileUpload','imageUpload','imageList','subCategory',
				'progress','alipayVerify','alipayReturn','addComment',
				'rates','addRate','toggleRate','toggleCollect','lesson','join','buy','rebuy','showRebuy','alipayVerify','alipayReturn'),
			'users'=>array('@'),
			),
		array('allow',
			'actions'=>array('create'),
			'roles'=>array('teacher')),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
			'actions'=>array('admin','delete'),
			'users'=>array('admin'),
			),
		array('deny',  // deny all users
			'users'=>array('*'),
			),
		);
}

    /**
     *
     *
     */
    public function actionCreateRate($id)
    {
        $model = $this->loadModel($id);

        $Rate = new Rate;
        $Rate->attributes = $_POST['Rate'];
        $Rate->userId = Yii::app()->user->id;
        $Rate->rateableEntityId = $model->entityId;
        $Rate->addTime = $Rate->upTime = time();

        if (!isset($_POST['Rate']['score'])) {
            // Case: 没有打分
            $rateDataProvider = $model->getRateDataProvider(array('criteria'=>array('order'=>'addTime DESC')));
            $html = $this->renderPartial(
                '_viewRate_panel_rate',
                array(
                    'rateDataProvider'  =>  $rateDataProvider,
                ),
                true
            );
            $html .= '<script>alert("请给课程打分，再一起发表评价");</script>';
            echo json_encode(array('html'=>$html, 'error'=>1));
        } else {
            // Case: 有打分
            if ($Rate->save()) {
                $rateDataProvider = $model->getRateDataProvider(array('criteria'=>array('order'=>'addTime DESC')));
                $html = $this->renderPartial(
                    '_viewRate_panel_rate',
                    array(
                        'rateDataProvider'  =>  $rateDataProvider,
                    ),
                    true
                );
                echo json_encode(array('html'=>$html, 'error'=>0));
            }

        }
    }

    /**
     * 课程评价页
     */
    public function actionViewRate($id)
    {
        $model = $this->loadModel($id);

        // 教师数据提供者
        $teacherDataProvider = new CActiveDataProvider(
            'CourseMember',
            array(
                'criteria' => array(
                    'condition' => 'find_in_set("teacher",roles) and courseId='.$model->id
                )
            )
        );

        // 回复光荣榜数据提供者
        $memberDataProvider = new CActiveDataProvider(
            'CourseMember',
            array(
                'criteria' => array(
                    'condition' =>  'commentNum>0',
                    'order'     =>  'commentNum DESC'
                ),
                'pagination' => array(
                    'pageSize' => 5
                ),
            )
        );

        // 评价数据提供者
        $rateDataProvider = $model->getRateDataProvider(array('criteria'=>array('order'=>'addTime DESC')));

        // CourseMember 对象
        if (!Yii::app()->user->isGuest) {
            $courseMember =  CourseMember::model()->findByAttributes(array('courseId'=>$model->id,'userId'=>Yii::app()->user->id));
        } else {
			$courseMember = new CourseMember;
        }
        // 用户是否购买课程，使用不同的header视图
        if (
            Yii::app()->user->checkAccess('courseOwner', array('course'=>$model))
            ||
            ($courseMember && $courseMember->inRoles(array('superAdmin','admin','member','teacher','student')))
        ) {
            $this->viewMenuName = '_view_menu';
            $this->viewHeaderName = '_view_header';
        }

        $this->render(
            'viewRate',
            array(
                'model' =>  $model,
                'teacherDataProvider'   =>  $teacherDataProvider,
                'memberDataProvider'    =>  $memberDataProvider,
                'rateDataProvider'      =>  $rateDataProvider,
            	'courseMember'=>$courseMember,
            )
        );
    }

    /**
     * 课程主页 课程列表
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        // 教师数据提供者
        $teacherDataProvider = new CActiveDataProvider(
            'CourseMember',
            array(
                'criteria' => array(
                    'condition' => 'find_in_set("teacher",roles) and courseId='.$model->id
                )
            )
        );

        // 学生数据提供者
        $studentDataProvider = new CActiveDataProvider(
            'CourseMember',
            array(
                'criteria' => array(
                    'condition'=>'find_in_set("student",roles) and courseId='.$model->id,
                    'order'=>'startTime desc'
                ),
                'pagination' => array(
                    'pageSize' => 9
                ),
            )
        );

        // 课时数据提供者
        $lessonDataProvider = $model->getLessonDataProvider();

        // CourseMember 对象
        if (!Yii::app()->user->isGuest) {
            $courseMember =  CourseMember::model()->findByAttributes(array('courseId'=>$model->id,'userId'=>Yii::app()->user->id));
        } else {
            $courseMember = new CourseMember;
        }
        // 用户是否购买课程，使用不同的header视图
        if (
            Yii::app()->user->checkAccess('courseOwner', array('course'=>$model))
            ||
            ($courseMember && $courseMember->inRoles(array('superAdmin','admin','member','teacher','student')))
        ) {
            $this->viewMenuName = '_view_menu';
            $this->viewHeaderName = '_view_header';
        }

        $this->render(
            'view',
            array(
                'model' =>  $model,
                'courseMember'          =>  $courseMember,
                'teacherDataProvider'   =>  $teacherDataProvider,
                'studentDataProvider'   =>  $studentDataProvider,
                'lessonDataProvider'    =>  $lessonDataProvider,
				'courseMember'=>$courseMember,
            )
        );
    }



            public function actionProgress($id,$userId=0){
            	$course = $this->loadModel($id);
            	if(!$userId) $userId=Yii::app()->user->id;
            	$user = UserInfo::model()->findByPk($userId);
            	if(!$user)
            		throw new CHttpException(404,'The requested page does not exist.');

            	$criteria = new CDbCriteria();
            	$criteria->condition = "courseId=:courseId and status=:status and chapterId=0";
            	$criteria->params = array(':courseId'=>$course->id,':status'=>Lesson::STATUS_PUBLIC);
            	$criteria->order = "weight asc";
            	$lessons = Lesson::model()->findAll($criteria);

            	$criteria->condition = "courseId=:courseId";
            	$criteria->params = array(':courseId'=>$course->id);

            	$chapters = Chapter::model()->findAll($criteria);

            	$lessonsAndChapters = array_merge($lessons,$chapters);

            	usort($lessonsAndChapters,array(new LessonSorter,'sortByWeight'));

            	if($userId)
            		$member =  CourseMember::model()->findByAttributes(array('courseId'=>$course->id,'userId'=>$userId));
            	else
            		$member = new CourseMember;
            	$lessonTotalCount = $course->lessonCount;
            	$lessonLearnedCount = LessonLearn::model()->lessonCount($userId, $course->id);

            	$nextLesson = LessonLearn::model()->nextLesson($course->id, $userId);
            	$this->render('progress',array('lessonsAndChapters'=>$lessonsAndChapters,
            		'course'=>$course,
            		'member'=>$member,
            		'lessonTotalCount'=>$lessonTotalCount,
            		'lessonLearnedCount'=>$lessonLearnedCount,
            		'user'=>$user,
            		'percent'=>($lessonTotalCount>0?100*$lessonLearnedCount/$lessonTotalCount:0),
            		'nextLesson'=>$nextLesson));
            }



	/**
	 * 选修课程（未完成，付费）
	 * @param unknown_type $id
	 */
	public function actionJoin($id){
		$course = $this->loadModel($id);
		if($course->addMember(Yii::app()->user->id)){
			Yii::app()->user->setFlash('success',Yii::t('app','选课成功！'));
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','抱歉，选课失败！'));
		}
		$this->redirect(array('view','id'=>$id));
	}

	/*	public function actionProgress($id,$userId=0){
		$course = $this->loadCourse($id);
		if(!$userId) $userId==Yii::app()->user->id;
		if($userId!=Yii::app()->user->id){
		$memberVisitor = $course->findMember(Yii::app()->user->id);
		if(!$memberVisitor->inRoles(array('admin','superAdmin')))
		throw new CHttpException(404,'not allowed!.');
		}

	}*/
	/**added by liang 20130809*/
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Course;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			$model->addTime = time();
			$model->userId = Yii::app()->user->id;
			$model->status = Course::STATUS_OK;
			if($model->save()){
				$member = new CourseMember();
				$member->userId= Yii::app()->user->id;
				$member->courseId = $model->getPrimaryKey();
				$member->startTime = time();
				$member->arrRoles = array('superAdmin','admin','teacher');
				$member->save();
				Yii::app()->user->setFlash('success',Yii::t('app','课程创建成功，请继续完善课程'));
				$this->redirect(array('manage/lesson/index','courseId'=>$model->id));
			}else{
				Yii::app()->user->setFlash('error', Yii::t('app','课程创建失败'));
			}
		}

		$categorys = Category::model()->findAll(array('condition'=>'type="course"','order'=>'weight asc'));
		$this->render('create',array(
			'model'=>$model,
			'categorys'=>$categorys,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->courseId));
		}
		$cates = CourseCategory::model()->findAll(array('condition'=>'referid=0'));

		$this->render('update',array(
			'model'=>$model,
			'cates'=>$cates,
			));
	}

	/**
	 * 列举所有rates
	 */
	public function actionRates($id){
		$course = $this->loadModel($id);
		$rateDataProvider = $course->getRateDataProvider();
		$myRate = $course->findRate(array('userId'=>Yii::app()->user->id));
		$this->layout = "//layouts/nonav_column1";
		$this->render('rates_fancy',array('rateDataProvider'=>$rateDataProvider,
			'myRate'=>$myRate,
			'course'=>$course));

	}
	/**
	 * 添加或修改rate
	 */
	public function actionToggleRate($id){

		$course = $this->loadModel($id);
		$rate = new Rate;
		if(isset($_POST['Rate'])){
			$rate->attributes = $_POST['Rate'];
			$rate->userId = Yii::app()->user->id;
			if($course->toggleRate($rate)){
				Yii::app()->user->setFlash('success',Yii::t('app','评价成功!'));
				$this->redirect(array('rates','id'=>$course->id));
				Yii::app()->end();
			}
		}
		$myRate = $course->findRate(array('userId'=>Yii::app()->user->id));
		$this->layout = "//layouts/nonav_column1";
		$this->render('toggle_rate',array('myRate'=>$myRate,'course'=>$course));
	}



	/**
	 * 关注或取消关注
	 * @param unknown_type $id
	 */
	public function actionToggleCollect($id){
		$course = $this->loadModel($id);
		if($course->toggleCollect(Yii::app()->user->id)){
			Yii::app()->user->setFlash('success',Yii::t('app','收藏成功！'));
		}else{
			Yii::app()->user->setFlash('success',Yii::t('app','取消收藏成功！'));
		}
		$this->redirect(array('view','id'=>$id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($order="student",$categoryId=0)
	{
		$hotDataProvider=new CActiveDataProvider('Course',array(
			'criteria'=>array('with'=>array('user'),'order'=>'viewNum desc','condition'=>'t.status='.Course::STATUS_OK),
			'pagination'=>array(
				'pageSize'=>8,
				)));
		$newDataProvider=new CActiveDataProvider('Course',array(
			'criteria'=>array('with'=>array('user'),'order'=>'t.addTime desc','condition'=>'t.status='.Course::STATUS_OK),
			'pagination'=>array(
				'pageSize'=>8,
				)));

		$criteria = new CDbCriteria();
		$criteria->with = "category";
		if($categoryId){
			$criteria->condition = "(categoryId=$categoryId or category.parentId=$categoryId) and category.type='course'";
		}else{
			$criteria->condition = "category.type='course'";
		}
		if($order=="student"){
			$criteria->order = "t.memberNum desc";
		}else if($order=="time"){
			$criteria->order="t.addTime desc";
		}else if($order=="fee"){
			$criteria->order="t.fee asc";
		}
		$dataProvider = new CActiveDataProvider("Course",array('criteria'=>$criteria,'pagination'=>array('pageSize'=>32)));

		$firstCategoies = Category::model()->findAllByAttributes(array('type'=>'course','parentId'=>0));
		$secondCategoies = null;
		$category = new Category();
		$category->id = 0;
		if($categoryId!=0){
			$category = Category::model()->findByAttributes(array('type'=>'course','id'=>$categoryId));
			if($category->parentId!=0){
				$firstCategoryId = $category->parentId;
				$secondCategoyId = $category->id;
			}else{
				$firstCategoryId = $category->id;
				$secondCategoyId = 0;
			}
			$secondCategoies = Category::model()->findAllByAttributes(array('type'=>'course','parentId'=>$firstCategoryId));
			//	$dataProvider = Course::model()->getDataProviderByCategory();
		}else{
			$firstCategoryId=0;
			$secondCategoyId=0;
		}
		$this->render('index',array(
			'hotDataProvider'=>$hotDataProvider,
			'newDataProvider'=>$newDataProvider,
			'dataProvider'=>$dataProvider,
			'firstCategories'=>$firstCategoies,
			'secondCategories'=>$secondCategoies,
			'category'=>$category,
			'firstCategoryId'=>$firstCategoryId,
			'secondCategoryId'=>$secondCategoyId,
			'order'=>$order,
			));

	}



	public function actionCategory($id=0,$sort="new"){
		$category = Category::model()->findByPk($id);
		if($sort=="new")
			$order = 't.addTime desc';
		else
			$order = "t.memberNum desc";
		if($id!=0)
		//	$dataProvider = new CActiveDataProvider('Course');
			$dataProvider=new CActiveDataProvider('Course',array('pagination'=>array('pageSize'=>32),
				'criteria'=>array(
					'with'=>array('user'),
					'condition'=>'t.status='. Course::STATUS_OK .' and categoryId='.$id,
					'order'=>$order)));
		else
			$dataProvider=new CActiveDataProvider('Course');

		$this->render('category',array(
			'dataProvider'=>$dataProvider,
			'category'=>$category,
			'sort'=>$sort
			));
	}

	public function actionAddComment($commentableEntityId){
		$comment = new Comment;
		//$model = $this->loadModel($id?$id:$lessonId);
		$entity = Entity::model()->findByPk($commentableEntityId);
		$model = $entity->getModel();
		if(isset($_POST['Comment'])){
			$comment->attributes = $_POST['Comment'];
			if($model->addComment($comment)){
				Yii::app()->user->setFlash('success',Yii::t('app','发表成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉，发表失败！'));
			}
			if($model instanceof Lesson){
				$course = $model->course;
			}else{
				$course = $model;
			}
			//if($model->addComment($comment)){
			$commentDataProvider = $course->getCommentDataProvider();
			//	var_dump($commentDataProvider->getData());
			$this->renderPartial('_comments',array('commentDataProvider'=>$commentDataProvider,'course'=>$course),false,true);
			//	}
		}

	}
	public function actionBuy($id){
		global $sysSettings;
		$model = $this->loadModel($id);
		if(isset($sysSettings['payment']['means'])
			&& ($sysSettings['payment']['means']=='aliGuaran' || $sysSettings['payment']['means']=='aliDual' || $sysSettings['payment']['means']=='ali' || $sysSettings['payment']['means']=='aliDirect')
			&& $model->fee>0){
			$order = new Order();
		$order->userId = Yii::app()->user->id;
			// modidied buy wzh
			$order->status = Order::ORDER_WAIT_PAY;
			$order->produceEntityId = $model->entityId;
			$order->meansOfPayment = "ali";
			$order->addTime = time();
			$order->price = $model->fee;
			$order->subject = Yii::t('app','购买课程《{name}》',array("{name}"=>$model->name));
			$order->save();

		$alipay = new Alipay($sysSettings['payment']['aliPartner'],$sysSettings['payment']['aliKey']);
		if($sysSettings['payment']['means']=='aliDirect'){
			$alipay->service = "create_direct_pay_by_user";
		}else{
			$alipay->service = "trade_create_by_buyer";
		}
		$alipay->seller_email = $sysSettings['payment']['aliSellerAccount'];
		$alipay->subject = $order->subject;
		$alipay->out_trade_no = $order->id;
		$alipay->price = $model->fee;

		$alipay->notify_url = Yii::app()->createAbsoluteUrl('course/index/alipayNotify');
		$alipay->return_url = Yii::app()->createAbsoluteUrl('course/index/alipayReturn');
		echo $alipay->submit();
		Yii::app()->end();
			//$this->render('buy',array('htmlText'=>$htmlText));
	}else{
		$member = CourseMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'courseId'=>$model->id));
		if($member) {
			$this->redirect(array('rebuy','id'=>$model->id));
			Yii::app()->end();
			//$this->render('buy',array('htmlText'=>$htmlText));
		}else if( (isset($sysSettings['payment']['means']))
			&&	($sysSettings['payment']['means'] == 'stripe') && $model->fee>0){
			if(isset($_POST['stripeToken'])) {
				$token  = $_POST['stripeToken'];
				try{
					$order = new Order();
					$order->status = Order::ORDER_WAIT_PAY;
					$order->produceEntityId = $model->entityId;
					$order->meansOfPayment = "stripe";
					$order->addTime = time();
					$order->price = $model->fee;
					$order->subject = Yii::t('app','购买课程《{name}》',array("{name}"=>$model->name));
					$order->save();
					Yii::import('ext.stripe.lib.Stripe');
					Stripe::setApiKey($sysSettings['payment']['stripeSecretKey']);

					$charge = Stripe_Charge::create(array(
						"amount"=>intval($model->fee*100),
						"currency" =>"usd",
						"card" => $token,
					));
					if($charge->paid == true)
					{
						$order->status = Order::ORDER_PAID;
						$order->save();
						Yii::app()->user->setFlash('success',Yii::t('app','欢迎加入课程'));
						$this->redirect('view',array('id'=>$model->id));
					}
				}catch (Stripe_CardError $e){
					Yii::app()->setFlash('error',Yii::t('app','抱歉！支付失败。'));
					$this->redirect('view',array('id'=>$model->id));
				}
			}
			$this->render('form',array(
			'model'=>$model,
			'key' => Yii::app()->controller->module->public_key
			));
			//$this->render('buy',array('htmlText'=>$htmlText));
		}else {
			//$member = new CourseMember;
			//$member->userId = Yii::app()->user->id;
			//$member->courseId = $model->id;
			//$member->startTime = time();
			//$member->arrRoles = array('student');
			//if($member->save()){
			//	Yii::app()->user->setFlash('success',Yii::t('app','加入成功！'));
			//}else{
			//	Yii::app()->user->setFlash('error',Yii::t('app','错误，加入失败！'));
			//}
			$this->redirect(array('view','id'=>$id));
		}
	}
}

public function actionRebuy($id){
	global $sysSettings;
	$model = $this->loadModel($id);
		//	var_dump($model);
	$courseMember = CourseMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'courseId'=>$model->id));
		//	echo '$courseMember';
		//    var_dump($courseMember->orderId);
		//    var_dump($courseMember->endTime);
	if($model !== null && $courseMember !== null && time()>$courseMember->endTime){
		if(isset($sysSettings['payment']['means'])
			&& ($sysSettings['payment']['means']=='aliGuaran' || $sysSettings['payment']['means']=='aliDual' || $sysSettings['payment']['means']=='ali' || $sysSettings['payment']['means']=='aliDirect')
			&& $model->renewFee>0){
			$order = new Order();
		$order->userId = Yii::app()->user->id;
		$order->status = Order::ORDER_WAIT_PAY;
		$order->produceEntityId = $model->entityId;
		$order->meansOfPayment = "ali";
		$order->addTime = time();
				// modified by wzh
				$order->price = $model->renewFee;
				$order->subject = Yii::t('app','购买课程《{name}》',array('{name}'=>$model->name));
				$order->save();

		$alipay = new Alipay($sysSettings['payment']['aliPartner'],$sysSettings['payment']['aliKey']);
		if($sysSettings['payment']['means']=='aliDirect'){
			$alipay->service = "create_direct_pay_by_user";
		}else{
			$alipay->service = "trade_create_by_buyer";
		}
		$alipay->seller_email = $sysSettings['payment']['aliSellerAccount'];
		$alipay->subject = $order->subject;
		$alipay->out_trade_no = $order->id;
				// modified by wzh
		$alipay->price = $model->renewFee;

		$alipay->notify_url = Yii::app()->createAbsoluteUrl('course/index/alipayNotifyRenewFee');
		$alipay->return_url = Yii::app()->createAbsoluteUrl('course/index/alipayReturn');
		echo $alipay->submit();
		Yii::app()->end();
				//$this->render('buy',array('htmlText'=>$htmlText));
			}else if(isset($sysSettings['payment']['means'])
			&& ($sysSettings['payment']['means']=='aliGuaran' || $sysSettings['payment']['means']=='aliDual' || $sysSettings['payment']['means']=='ali' || $sysSettings['payment']['means']=='aliDirect')
			&& $model->renewFee>0){
				//$order = new Order();
				//$order->userId = Yii::app()->user->id;
				//$order->status = Order::ORDER_WAIT_PAY;
				//$order->produceEntityId = $model->entityId;
				//$order->meansOfPayment = "ali";
				//$order->addTime = time();
				//// modified by fbl
				//$order->price = $model->renewFee;
				//$order->subject = Yii::t('app','购买课程《{name}》',array('{name}'=>$model->name));
				//$order->save();
				$this->redirect(array('pay/default/form'));

			}else{
				$member = new CourseMember;
				$member->userId = Yii::app()->user->id;
				$member->courseId = $model->id;
				$member->startTime = time();
				$member->arrRoles = array('student');
				if($member->save()){
					Yii::app()->user->setFlash('success',Yii::t('app','加入成功！'));
				}else{
					Yii::app()->user->setFlash('error',Yii::t('app','错误，加入失败！'));
				}
				$this->redirect(array('view','id'=>$id));
			}

}

}



	public function actionShowRebuy($id){
		$model = $this->loadModel($id);
		$member = CourseMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'courseId'=>$model->id));
		Yii::app()->clientScript->scriptMap['*.js'] = false;
		if($member->status==CourseMember::STATUS_INVALID){
			$this->renderPartial('show_rebuy',array('course'=>$model));
		}
	}


	public function actionAlipayNotifyRenewFee(){
		error_log("ok");
		error_log(print_r($_POST,true));
		//ali验证不允许有多余参数
	if(isset($_GET['r']))unset($_GET['r']);
	global $sysSettings;
	$alipay = new Alipay($sysSettings['payment']['aliPartner'],$sysSettings['payment']['aliKey']);

		if($alipay->verifyNotify()) {//验证成功

			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];

			$order = Order::model()->findByPk($out_trade_no);
			$course = Course::model()->findByAttributes(array('entityId'=>$order->produceEntityId));
			$user = UserInfo::model()->findByPk($order->userId);

			if($trade_status == 'WAIT_BUYER_PAY') {
				//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
				echo "success";		//请不要修改或删除
			}
			else if(//$trade_status == 'WAIT_SELLER_SEND_GOODS' ||
				$trade_status == 'WAIT_BUYER_CONFIRM_GOODS'
				|| $trade_status== 'WAIT_BUYER_CONFIRM_GOODS'
				|| $trade_status =='TRADE_FINISHED'
				|| $trade_status=='TRADE_SUCCESS') {

				$order->status = Order::ORDER_PAID;
				$order->tradeNo = $trade_no;
				$order->save();
				$member = CourseMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'courseId'=>$course->id));
				if($member){
					// add by wzh
					$member->endTime = time() + $course->validTime;
					$member->save();
				}
				$courseMemberOrder = new CourseMemberOrder;
				$courseMemberOrder->memberId = $member->id;
				$courseMemberOrder->orderId = $order->id;
				$courseMemberOrder->addTime = time();
				$courseMemberOrder->save();

				echo "success";		//请不要修改或删除
			}
			else {
				//其他状态判断
				echo "success";
			}
		}
		else {
			//验证失败
			echo "fail";
		}
	}


	public function actionAlipayNotify(){
		//		error_log("ok");
		//		error_log(print_r($_POST,true));
		//ali验证不允许有多余参数
		if(isset($_GET['r']))unset($_GET['r']);
		global $sysSettings;
		$alipay = new Alipay($sysSettings['payment']['aliPartner'],$sysSettings['payment']['aliKey']);

		if($alipay->verifyNotify()) {//验证成功

			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];

			$order = Order::model()->findByPk($out_trade_no);
			$course = Course::model()->findByAttributes(array('entityId'=>$order->produceEntityId));
			$user = UserInfo::model()->findByPk($order->userId);

			if($trade_status == 'WAIT_BUYER_PAY') {
				//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
				echo "success";		//请不要修改或删除
			}
			else if(//$trade_status == 'WAIT_SELLER_SEND_GOODS' ||
				$trade_status == 'WAIT_BUYER_CONFIRM_GOODS'
				|| $trade_status== 'WAIT_BUYER_CONFIRM_GOODS'
				|| $trade_status =='TRADE_FINISHED'
				|| $trade_status=='TRADE_SUCCESS') {

				$order->status = Order::ORDER_PAID;
				$order->tradeNo = $trade_no;
				$order->save();
				$member = CourseMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'courseId'=>$course->id));
				if(!$member){
					$member = new CourseMember;
					$member->userId = $user->id;
					$member->courseId = $course->id;
					$member->arrRoles = array('student');
					$member->startTime = time();
					$member->save();
				}else{
					$member->startTime = time();
					$member->save();
				}

				echo "success";		//请不要修改或删除
			}
			else {
				//其他状态判断
				echo "success";
			}
		}
		else {
			//验证失败
			echo "fail";
		}
	}

	public function actionAlipayReturn(){
		//ali验证不允许有多余参数
		if(isset($_GET['r']))unset($_GET['r']);

		$out_trade_no=$_GET['out_trade_no'];
		$trade_no=$_GET['trade_no'];
		$trade_status=$_GET['trade_status'];

		global $sysSettings;
		$alipay = new Alipay($sysSettings['payment']['aliPartner'],$sysSettings['payment']['aliKey']);
		if($alipay->verifyReturn()){
			$order = Order::model()->findByPk($out_trade_no);
			$course = Course::model()->findByAttributes(array('entityId'=>$order->produceEntityId));
			// modified by wzh
			if($order->status==Order::ORDER_PAID){
				Yii::app()->user->setFlash('success','购买成功！你已经成功选上课程');
			}
			$this->redirect(array('view','id'=>$course->id));
		}else{
			throw new CHttpException(404,'验证错误！');
		}
	}

	public function actionApplyPublish($courseId){
		$course = $this->loadModel($courseId);
		if($course->userId == Yii::app()->user->id){
			$course->status = "applying";
			if($course->save()){
				//通知#1用户
				$notice = new Notice;
				$notice->userId = 1;
				$notice->type="apply_publish_course";
				$notice->setData(array('courseId'=>$courseId));
				$notice->save();
				echo true;
			}
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Course the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Course::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param Course $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
