<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 24.11.2018
 * Time: 18:36
 */

namespace Application\Controller;


use Application\Entity\Task;
use Zend\View\Model\JsonModel;

class TaskController extends BaseController {

    const CACHE_KEY = 'tasks';
    public function indexAction () {
        if($taskList = $this->cache->getItem(self::CACHE_KEY)) {
            return new JsonModel([
                'data' => json_decode($taskList, true)
            ]);
        }
        $query = <<< SQL
SELECT id, title, date from task
SQL;
        $taskList = $this->entityManager->getConnection()->executeQuery($query)->fetchAll();
        $this->cache->setItem(self::CACHE_KEY, json_encode($taskList));
        return new JsonModel([
            'data' => $taskList
        ]);
    }

    public function editAction () {
        if(($id = $this->params()->fromRoute('id', null)) === null){
            return $this->invalidJson('no task id provided');
        }
        /** @var Task $task */
        $task = $this->entityManager->find(Task::class, $id);
        if(!$task) {
            return $this->notFoundJson('task not found');
        }
        return new JsonModel([
            'success' => true,
            'task' => json_encode($task->jsonSerialize())
        ]);
    }
}