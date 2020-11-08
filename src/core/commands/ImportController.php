<?php

namespace app\core\commands;

use app\core\models\district\District;
use yii\console\Controller;
use yii\db\Connection;

class ImportController extends Controller
{
    public function actionDistrict()
    {
        /* @var $db Connection */
        $db = \Yii::$app->get('sqlite');

        $provinces = $db->createCommand('SELECT * FROM province')->queryAll();

        foreach ($provinces as $province) {
            $provinceDistrict = new District();
            $provinceDistrict->parentId = 0;
            $provinceDistrict->code = $province['code'];
            $provinceDistrict->name = $province['name'];

            $provinceDistrict->save(false);

            $cities = $db->createCommand('SELECT * FROM city WHERE provinceCode = :provinceCode', [':provinceCode' => $provinceDistrict->code])
                ->queryAll();

            foreach ($cities as $city) {
                $cityDistrict = new District();
                $cityDistrict->parentId = $provinceDistrict->id;
                $cityDistrict->code = $city['code'];
                $cityDistrict->name = $city['name'];

                $cityDistrict->save(false);

                $areas = $db->createCommand('SELECT * FROM area WHERE cityCode = :cityCode', [':cityCode' => $cityDistrict->code])
                    ->queryAll();

                foreach ($areas as $area) {
                    $areaDistrict = new District();
                    $areaDistrict->parentId = $cityDistrict->id;
                    $areaDistrict->code = $area['code'];
                    $areaDistrict->name = $area['name'];

                    $areaDistrict->save(false);

                    $streets = $db->createCommand('SELECT * FROM street WHERE areaCode = :areaCode', [':areaCode' => $areaDistrict->code])
                        ->queryAll();

                    foreach ($streets as $street) {
                        $streetDistrict = new District();
                        $streetDistrict->parentId = $areaDistrict->id;
                        $streetDistrict->code = $street['code'];
                        $streetDistrict->name = $street['name'];

                        $streetDistrict->save(false);
                    }
                }
            }

            $this->stdout($provinceDistrict->name . "数据导入成功\n");

            sleep(2);
        }
    }
}
