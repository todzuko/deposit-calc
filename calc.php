<?php
if (empty($_POST)) {
    echo "Введите данные\n";
    return;
}

//get values
$startDate = $_POST["fopendate"];
$sum = $_POST["famount"];
$term = $_POST["ftermnum"];
$termisMonth = $_POST["fterm"];
$percent = $_POST["finterest"] / 100;
$sumAdd = $_POST["freplamount"];

//get value of replenish
$replenish = false;
if (array_key_exists("freplenishment", $_POST)) {
    //no key if js disabled, but always key when pass json from js
    if (
        $_POST["freplenishment"] == "true" ||
        $_POST["freplenishment"] == "on"
    ) {
        $replenish = true;
    }
}

//validation
if (empty($startDate)) {
    die("Введите дату создания счета\n");
    return;
}
if (empty($sum) || !(is_numeric($sum) && $sum >= 1000 && $sum <= 3000000)) {
    die("Введите сумму вклада от 1000 до 3000000\n");
    return;
}
if (empty($term) || !(is_numeric($term) && $term >= 1 && $term <= 60)) {
    die("Введите срок вклада от 1 до 60 месяцев (5 лет)\n");
    return;
}

if (
    empty($percent) ||
    !(is_numeric($percent) && $percent >= 0.03 && $percent <= 1)
) {
    die("Введите процент от 3 до 100");
    return;
}
if ($replenish == true) {
    if (
        empty($sumAdd) ||
        !(is_numeric($sumAdd) && $sum >= 0 && $sum <= 3000000)
    ) {
        die("Введите сумму пополнения от 0 до 3000000");
        return;
    }
}
if ($termisMonth === "year") {
    $term = $term * 12;
}

if (empty($sumAdd)) {
    $sumAdd = 0;
}
$totalProfit = 0;
$profit=0;
//calculations
$startMonth = date("m", strtotime($startDate));
$startYear = date("y", strtotime($startDate));
$currentYear = $startYear;
$endMonth = $startMonth + $term;
$sumLast = $sum;

for ($i = $startMonth; $i <= $endMonth; $i++) {
    $currentM = $i;
    if ($i > 12) {
        if (($i - 1) % 12 == 0) {
            $currentYear += 1;
        }
        $currentM = $i - 12 * ($currentYear - $startYear);
        $daysM = cal_days_in_month(CAL_GREGORIAN, $currentM, $currentYear);
    } else {
        $daysM = cal_days_in_month(CAL_GREGORIAN, $currentM, $startYear);
    }

    if ($i == $startMonth) {
        $daysM = $daysM - date("d", strtotime($startDate));
    } elseif ($i == $endMonth) {
        $daysM = date("d", strtotime($startDate));
    }
    if (date("L", mktime(0, 0, 0, 1, 1, $currentYear)) === "1") {
        $daysY = 366;
    } else {
        $daysY = 365;
    }

    if ($i == $startMonth) {
        $profit = round(($sumLast) * $daysM * ($percent / $daysY),2);
    }
    else{
        $profit = round(($sumLast + $sumAdd) * $daysM * ($percent / $daysY),2);
        $sumLast += $sumAdd;
    }
    $totalProfit += $profit;
}
//result is different from result on figma.
//Profit is not added to account and calculated separately
//first month profit includes no additional replenishment
echo round($totalProfit);
?>
