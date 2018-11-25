<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 24.11.2018
 * Time: 18:37
 */

namespace Application\Controller;


use Doctrine\ORM\EntityManager;
use Zend\Cache\Storage\StorageInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class BaseController
 *
 * @package Application\Controller
 * @method Request getRequest()
 * @method Response getResponse()
 */
class BaseController extends AbstractActionController {

    protected $entityManager;
    protected $cache;

    public function __construct (EntityManager $entityManager, StorageInterface $storage) {
        $this->entityManager = $entityManager;
        $this->cache = $storage;
    }

    protected function notFoundJson($msg = null) {
        $x = $this->invalidJson($msg ?: 'not found');
        $this->getResponse()->setStatusCode(404);
        return $x;
    }

    protected function invalidJson($msg) {
        $this->getResponse()->setStatusCode(400);
        return new JsonModel([
            'success' => false,
            'errors' => is_array($msg) ? $msg : [$msg]
        ]);
    }
}