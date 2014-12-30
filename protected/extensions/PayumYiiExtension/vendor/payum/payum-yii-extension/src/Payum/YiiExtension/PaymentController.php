<?php
namespace Payum\YiiExtension;

use Payum\Core\Exception\LogicException;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Reply\ReplyInterface;
use Payum\Core\Request\Capture;

class PaymentController extends \CController
{
    public function init()
    {
        parent::init();

        \Yii::app()->attachEventHandler('onException', array($this, 'handleException'));
    }

    public function actionCapture()
    {
        $token = $this->getPayum()->getHttpRequestVerifier()->verify($_REQUEST);
        $payment = $this->getPayum()->getRegistry()->getPayment($token->getPaymentName());

        $payment->execute($capture = new Capture($token));

        $this->getPayum()->getHttpRequestVerifier()->invalidate($token);

        $this->redirect($token->getAfterUrl());
    }

    public function actionAuthorize()
    {
        throw new \LogicException('Not Implemented');
    }

    public function actionNotify()
    {
        throw new \LogicException('Not Implemented');
    }

    public function handleException(\CExceptionEvent $event)
    {
        if (false == $event->exception instanceof ReplyInterface) {
            return;
        }

        $reply = $event->exception;

        if ($reply instanceof HttpRedirect) {
            $this->redirect($reply->getUrl(), true);
            $event->handled = true;

            return;
        }

        $ro = new \ReflectionObject($reply);

        $event->exception = new LogicException(
            sprintf('Cannot convert reply %s to Yii response.', $ro->getShortName()),
            null,
            $reply
        );
    }

    /**
     * @return \Payum\YiiExtension\PayumComponent
     */
    protected function getPayum()
    {
        return \Yii::app()->payum;
    }
} 