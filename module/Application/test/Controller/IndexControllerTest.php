<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 24.11.2018
 * Time: 19:45
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../phpunit.config.php',
            include __DIR__ . '/../../../../config/application.config.php'
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class);
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('index');
    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout() {
        $this->dispatch('/', 'GET');
        $this->assertQuery('#task_table');
        $this->assertQuery('.modal');
    }

    public function testInvalidRouteDoesNotCrash() {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
