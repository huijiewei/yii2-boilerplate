<?php

use app\core\models\district\District;

/* @var $this \yii\web\View */
/* @var $context \app\modules\website\Controller */
/* @var $data array */

$context = $this->context;
?>
<?php \app\core\widgets\StyleBlock::begin(); ?>
<style type="text/css">
    .table thead tr th.vertical-center {
        vertical-align: middle;
    }

    .table thead tr td.vertical-center {
        vertical-align: middle;
    }
</style>
<?php \app\core\widgets\StyleBlock::end(); ?>
<table style="margin-top: 15px;" class="table table-bordered">
    <thead>
    <tr>
        <th class="vertical-center" colspan="5">
            <span class="text-muted">总记录数量：<?= count($data); ?></span>
            &nbsp;&nbsp;
            <button id="startBtn" class="btn btn-info">开始处理</button>
            &nbsp;&nbsp;
            <span class="text-muted" id="runInfo"></span>
        </th>
        <th class="text-right">
            <select id="dataFilter" class="form-control">
                <option value="">显示所有记录</option>
                <option value="SUCCESS">成功</option>
                <option value="INSERT-EXIST">新增-地区已存在</option>
                <option value="INSERT-PARENT-NONE">新增-上级地区不存在</option>
                <option value="INSERT-SAME-IN-PARENT">新增-更新同上级同名地区</option>
                <option value="DELETE-SAME-IN-PARENT">删除-同上级地区同名地区</option>
                <option value="DELETE-NO-EXIST">删除-地区不存在</option>
                <option value="UPDATE-SAME-IN-PARENT">更新-同上级地区同名地区</option>
                <option value="UPDATE-NEW-EXIST">更新-跳过地区已存在</option>
                <option value="UPDATE-NO-EXIST">更新-地区不存在</option>
            </select>
        </th>
    </tr>
    <tr>
        <th class="vertical-center text-center">原代码</th>
        <th class="vertical-center text-center">原名称</th>
        <th class="vertical-center text-center">新代码</th>
        <th class="vertical-center text-center">新名称</th>
        <th class="vertical-center text-center">操作</th>
        <th class="vertical-center text-center">运行结果</th>
    </tr>
    </thead>
    <tbody id="updateTable">
    <?php foreach ($data as $item) {
        $code = trim($item[0]);
        $name = trim($item[1]);

        $newCode = trim($item[3]);
        $newName = trim($item[4]);

        if (empty($code) && empty($name)) {
            $mode = "新增";
            $bg = 'success';
        } elseif (empty($newCode) && empty($newName)) {
            $mode = "删除";
            $bg = 'danger';
        } else {
            $mode = "更新";
            $bg = 'info';
        }
        ?>
        <tr class="bg-<?= $bg; ?>" data-status="none"
            data-item="<?= \yii\helpers\Html::encode(\yii\helpers\Json::encode([
                'name' => $name,
                'code' => $code,
                'newName' => $newName,
                'newCode' => $newCode,
            ])) ?>">
            <td class="vertical-center text-nowrap">
                <?= $code; ?>
            </td>
            <td class="vertical-center text-nowrap">
                <?= $name; ?>
            </td>
            <td class="vertical-center text-nowrap">
                <?= $newCode; ?>
            </td>
            <td class="vertical-center text-nowrap">
                <?= $newName; ?>
            </td>
            <td class="vertical-center text-nowrap">
                <?= $mode; ?>
            </td>
            <td class="vertical-center result" width="100%;">

            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php \app\core\widgets\ScriptBlock::begin(); ?>
<script>
    $(document).ready(function() {
        $('#dataFilter').on('change', function() {
            var value = $(this).val()

            if (value == '') {
                $('#updateTable').find('tr').removeClass('hidden')
            } else {
                $('#updateTable').find('tr[data-status!="' + value + '"]').addClass('hidden')
            }
        })

        var doPost = function(idx) {
            if ($('#startBtn').data('status') == 'stopped') {
                return
            }

            var trs = $('#updateTable').find('tr')

            if (trs.length == idx) {
                return
            }

            var tr = $(trs[idx])

            $.post('<?= \yii\helpers\Url::toRoute(['site/dp-ajax']) ?>', tr.data('item'), function(data) {
                tr.attr('data-status', data.status)

                tr.find('.result').html(data.success ? ('<span class="label label-success">' + data.message + '</span>') : ('<span class="label label-default">' + data.message + '</span>'))

                $('#runInfo').html('已处理：' + (idx + 1) + ', 剩余：' + (trs.length - idx))

                setTimeout(function() {
                    doPost(idx + 1)
                }, 300)
            })
        }

        var start = function(btn) {
            btn.data('status', 'running')
            btn.text('停止')

            doPost(0)
        }

        var stop = function(btn) {
            btn.data('status', 'stopped')
            btn.text('开始')
        }

        $('#startBtn').click(function() {
            var btn = $(this)

            if (btn.data('status') == 'running') {
                stop(btn)
            } else {
                start(btn)
            }
        })
    })
</script>
<?php \app\core\widgets\ScriptBlock::end(); ?>
