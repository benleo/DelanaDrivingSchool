<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.27.9
 * Time: 20:04
 */

use Phalcon\Mvc\View;
use library\SharedService;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class NewsController extends \ControllerBase
{

    public function addAction()
    {
        $this->view->disable();

        if (!SharedService::isAdminLogged()) {
            $this->forwardTo404();
            return false;
        }

        $new = $this->request->getPost('new');

        if ($new && $this->request->isAjax()) {

           $new = json_decode($new, true);

           $createResult = (new News())->create($new);

           die(json_encode(['result' => $createResult]));
        }
    }

    public function deleteAction()
    {
        $this->view->disable();

        if(!SharedService::isAdminLogged()){
            $this->forwardTo404();
            return false;
        }

        $newId = $this->request->get('newId');

        if($newId && $this->request->isAjax()) {

            $newToDelete = News::findFirst($newId);

            if (!$newToDelete) {
                $deleteResult = 'Извините, произошла ошибка в процессе удаления!';
            } else {
                $deleteResult = $newToDelete->delete();
            }

            die(json_encode(['result'   =>  $deleteResult]));
        }

    }

}