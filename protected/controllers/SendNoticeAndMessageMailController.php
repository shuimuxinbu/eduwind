<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;

class SendNoticeAndMessageMailController extends Controller
{
    protected $domain;
    protected $key;
    protected $from = 'EduWind <noreply@eduwind.org>';

    /**
     *
     */
    public function actionIndex($domain, $key, $from=null)
    {
        if (!isset($domain) || !isset($key)) exit(Yii::t('app','URL请求不正确'));
        $this->domain   =   $domain;
        $this->key      =   $key;
        if(isset($from)) $this->from = $from;

        $users = UserInfo::model()->findAll();
        foreach ($users as $user) {
            $param = $this->getNoticeParam($user);
            // 如果没有私信和提醒，则跳出此次循环
            if (isset($param['nullMailData'])) continue;
            // 发送邮件
            $result = $this->sendMail($param);
            echo $param['html'];
        }
    }

    /**
     *
     */
    private function sendMail($param)
    {
        $mgClient = new Mailgun($this->key);
        $domain = $this->domain;

        $result = $mgClient->sendMessage(
            $domain,
            array(
                'from'    => $this->from,
                'to'      => $param['to'],
                'subject' => $param['subject'],
                'html'    => $param['html']
            )
        );
    }


    /**
     *
     */
    private function getNoticeParam($user)
    {
        $mailData['userName']   =   $user['name'];
        // 未读的私信
        $mailData['messageDataProvider']=   new CArrayDataProvider(
            UserInfo::model()->findByPk($user['id'])->messagesReceived,
            array(
                'keyField'=>'id',
                'pagination'=>array(
                    'pageSize'=>1
                )
            )
        );
        // 未读的提醒
        $mailData['noticeDataProvider'] =   new CArrayDataProvider(
            UserInfo::model()->findByPk($user['id'])->notices,
            array(
                'keyField'=>'id',
                'pagination'=>array(
                    'pageSize'=>3
                )
            )
        );
        // 如果没有私信和提醒
        if (!count($mailData['messageDataProvider']->getData()) && !count($mailData['noticeDataProvider']->getData())) {
            $param['nullMailData'] = 1;
            return $param;
        }
        $param['to']        =   'zhanghooyo@qq.com';
        $param['subject']   =   'test title';
        $param['html']      =   $this->renderPartial('_mail_template', $mailData, true);
        return $param;
    }

}
