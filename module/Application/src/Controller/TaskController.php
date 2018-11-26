<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 24.11.2018
 * Time: 18:36
 */

namespace Application\Controller;


use Application\Entity\Task;
use Doctrine\DBAL\DBALException;
use Zend\View\Model\JsonModel;

class TaskController extends BaseController {

    const CACHE_KEY = 'tasks';

    /**
     * @return JsonModel
     */
    public function indexAction () {
        if($taskList = $this->cache->getItem(self::CACHE_KEY)) {
            return new JsonModel([
                'data' => json_decode($taskList, true)
            ]);
        }
        $query = /** @lang MySQL */
            "SELECT id, title, date from `task`";
        try {
            $taskList = $this->entityManager->getConnection()->executeQuery($query)->fetchAll();
        } catch (\Exception $e) {
            return new JsonModel([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        if($taskList) {
            $this->cache->setItem(self::CACHE_KEY, json_encode($taskList));
        }
        return new JsonModel([
            'data' => $taskList
        ]);
    }

    /**
     * @return JsonModel
     */
    public function getTaskAction () {
        if(($id = $this->params()->fromRoute('id', null)) === null){
            return $this->invalidJson('no task id provided');
        }
        /** @var Task $task */
        try {
            $task = $this->entityManager->find(Task::class, $id);
        } catch (\Exception $e) {
            return new JsonModel([
                'success' => false,
                'error' => $e->getMessage()
            ]);

        }
        if(!$task) {
            return $this->notFoundJson('task not found');
        }
        return new JsonModel([
            'success' => true,
            'task' => json_encode($task->jsonSerialize())
        ]);
    }
}