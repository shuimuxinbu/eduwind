<?php
namespace Payum\YiiExtension;

use Payum\Core\Security\AbstractGenericTokenFactory;

class TokenFactory extends AbstractGenericTokenFactory
{

    /**
     * @param string $path
     * @param array $parameters
     *
     * @return string
     */
    protected function generateUrl($path, array $parameters = array())
    {
        $ampersand = '&';
        $schema = '';

        return
            \Yii::app()->getRequest()->getHostInfo($schema).
            \Yii::app()->createUrl(trim($path,'/'),$parameters, $ampersand)
        ;
    }
}