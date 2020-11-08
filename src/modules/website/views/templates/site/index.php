<?php

$data = [];

$mix = [
    '+',
    '-',
    'x',
    '÷'
];

function randNumber()
{
    if (rand(1, 1000) < 100) {
        return 3.14 * 0.1;
    }

    if (rand(1, 1000) < 200) {
        return 3.14 * 10;
    }

    if (rand(1, 1000) < 300) {
        return 3.14 * 1;
    }

    return rand(10, 1000) / 10;
}

for ($i = 0; $i <= 12; $i++) {
    $group = [];
    for ($j = 0; $j <= 4; $j++) {
        $group[] = [
            randNumber(),
            $mix[rand(0, 3)],
            randNumber(),
        ];
    }
    $data[] = $group;
}

?>
<table>
    <?php foreach ($data as $group) { ?>
        <tr>
            <?php foreach ($group as $item) { ?>
                <td style="padding: 10px 0;" width="25%">
                    <?= $item[0] . $item[1] . $item[2] . '=' ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
