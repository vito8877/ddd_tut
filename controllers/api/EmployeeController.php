<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 12:13
 */

namespace app\controllers\api;


use app\services\EmployeeService;
use yii\base\Module;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeService
     */
    private $employeeService;

    public function __construct($id, Module $module, EmployeeService $employeeService, array $config)
    {
        $this->employeeService = $employeeService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $form = new EmployeeCreateForm();
        $form->load(\Yii::$app->request->getBodyParams(), '');

        if (!$form->validate()) {
            return $form;
        }

        try {
            $this->employeeService->create(
                $form->getDto()
            );
            \Yii::$app->response->setStatusCode(201);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage(), 0, $e);
        }
    }
}