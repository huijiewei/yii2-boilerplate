<?php

namespace app\modules\website\controllers;

use app\core\models\district\District;
use app\modules\website\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\Response;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        return $this->render('error', [
            'exception' => \Yii::$app->getErrorHandler()->exception
        ]);
    }

    public function actionDp()
    {
        $data = IOFactory::load(\Yii::getAlias('@app/../database/2020.xlsx'))->getActiveSheet()->toArray('');

        return $this->render('dp', [
            'data' => $data
        ]);
    }

    public $enableCsrfValidation = false;

    public function actionDpAjax()
    {
        $item = \Yii::$app->getRequest()->post();

        $code = trim($item['code']);
        $name = trim($item['name']);

        $newCode = trim($item['newCode']);
        $newName = trim($item['newName']);

        $error = '成功';
        $status = 'SUCCESS';

        if (empty($code) && empty($name)) {
            $result = $this->operateInsert($newName, $newCode, $error, $status);
        } elseif (empty($newCode) && empty($newName)) {
            $result = $this->operateDelete($name, $code, $error, $status);
        } else {
            $result = $this->operateUpdate($name, $code, $newName, $newCode, $error, $status);
        }

        if (!$result) {
            $file = \Yii::getAlias('@app/../database/next.csv');

            file_put_contents($file, $code . ',' . $name . ',' . $newCode . ',' . $newName . PHP_EOL, FILE_APPEND);
        }

        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        return [
            'success' => $result,
            'message' => $error,
            'status' => $status,
        ];
    }

    function operateInsert($name, $code, &$error, &$status)
    {
        if (District::find()->where(['name' => $name, 'code' => $code])->exists()) {
            $error = $name . ' (' . $code . ')' . ' 已存在';
            $status = 'INSERT-EXIST';

            return false;
        }

        $parentCode = substr($code, 0, 6);

        /* @var $parent District|null */
        $parent = District::find()->where(['code' => $parentCode])->one();

        if ($parent == null) {
            $error = '上级地区 (' . $parentCode . ')' . '不存在';
            $status = 'INSERT-PARENT-NONE';

            return false;
        }

        /* @var $district District|null */
        $district = District::find()
            ->where(['name' => $name, 'parentId' => $parent->id])
            ->one();

        if ($district != null) {
            $error = '同上级地区同名地区：' . $district->name . ' (' . $district->code . ') 存在，更新成功';
            $status = 'INSERT-SAME-IN-PARENT';
        } else {
            $district = new District();
            $district->parentId = $parent->id;
        }

        $district->name = $name;
        $district->code = $code;

        $district->save(false);

        return true;
    }

    function operateDelete($name, $code, &$error, &$status)
    {
        /* @var $district District|null */
        $district = District::find()->where(['name' => $name, 'code' => $code])->one();

        if ($district == null) {
            $parentCode = substr($code, 0, 6);

            /* @var $district District|null */
            $district = District::find()
                ->where(['name' => $name, 'parentId' => District::find()->where(['code' => $parentCode])->select('id')])
                ->one();

            if ($district != null) {
                $error = '严格匹配不存在，删除同上级地区同名地区成功：' . $district->name . ' (' . $district->code . ')';
                $status = 'DELETE-SAME-IN-PARENT';
            }
        }

        if ($district == null) {
            $error = $name . ' (' . $code . ')' . ' 不存在';
            $status = 'DELETE-NO-EXIST';

            return false;
        }

        $district->delete();

        return true;
    }

    function operateUpdate($name, $code, $newName, $newCode, &$error, &$status)
    {
        /* @var $district District|null */
        $district = District::find()->where(['name' => $name, 'code' => $code])->one();

        if ($district == null) {
            $parentCode = substr($code, 0, 6);

            /* @var $district District|null */
            $district = District::find()
                ->where(['name' => $name, 'parentId' => District::find()->where(['code' => $parentCode])->select('id')])
                ->one();

            if ($district != null) {
                $error = '严格匹配不存在，更新同上级地区同名地区成功：' . $district->name . ' (' . $district->code . ')';
                $status = 'UPDATE-SAME-IN-PARENT';
            }
        }

        if ($district == null) {
            /* @var $newDistrict District|null */
            $newDistrict = District::find()->where(['name' => $newName, 'code' => $newCode])->one();

            if ($newDistrict) {
                $error = '更新后的地区已存在，成功跳过：' . $newDistrict->name . ' (' . $newDistrict->code . ')';

                $status = 'UPDATE-NEW-EXIST';

                return true;
            }

            $error = $name . ' (' . $code . ')' . ' 不存在';
            $status = 'UPDATE-NO-EXIST';

            return false;
        }

        $district->name = $newName;
        $district->code = $newCode;
        $district->save(false);

        return true;
    }
}
