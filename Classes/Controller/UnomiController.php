<?php
namespace Hb180\DXP\Unomi\Controller;

/*
 * This file is part of the Hb180.DXP.Unomi package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class UnomiController extends ActionController
{

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('foos', array(
            'bar', 'baz'
        ));
    }
}
