<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 11:52
 */

namespace app\controllers;


use app\forms\EmployeeCreateForm;
use app\services\EmployeeService;
use yii\base\Module;
use yii\web\Controller;

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
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->employeeService->create($form->getDto());
                \Yii::$app->session->setFlash('success', 'Employee is created');
                $this->redirect(['index']);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', \Yii::t('errors', $e->getMessage()));
            }
        }

        return $this->render('create', [
            'form' => $form,
        ]);
    }
}