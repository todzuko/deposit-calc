<?php
if (empty($_POST)){
  echo "Введите данные\n";
  return;
}

//get values
$startDate = $_POST["fopendate"];
$sum = $_POST["famount"];
$term = $_POST["ftermnum"];
$percent = $_POST["finterest"] / 100;
$sumAdd = $_POST["freplamount"];
//validation
if (empty($startDate))
{
  echo "Введите дату создания счета\n";
  return;
}

if (empty($sum) || !(is_numeric($sum) && $sum>=1000 && $sum<=3000000)){
  echo "Введите сумму вклада от 1000 до 3000000\n";
  //echo "Integer A '$int_a' is considered valid (between 0 and 3).\n"
  return;
}

if (empty($term) || !(is_numeric($term)&& $term >=1 && $term<=60 )){
//how do i know if its month or year without js? should i add action?
//should i pass valuses in json when i use js?
  echo "Введите срок вклада от 1 до 60 месяцев (5 лет)\n";
  return;
}

if (empty($percent) || !(is_numeric($percent) && $percent>=0.03 && $percent<=1)){
  echo "Введите процент от 3 до 100";
  return;
}

if (!((is_numeric($sumAdd) && $sum>=0 && $sum<=3000000) || empty($sumAdd))){//, ==''){
  echo "Введите сумму пополнения от 0 до 3000000";
  return;
}
if (empty($sumAdd)){ $sumAdd = 0;}

//calculations
$startMonth = date("m", strtotime($startDate));
$startYear = date("y", strtotime($startDate));
$endMonth = $startMonth + $term;
$daysY = 365;

$sumLast = $sum;
for ($i = $startMonth;$i <= $endMonth;$i++)
{

    if ($i > 12)
    {
        $yearAdd = $i % 12;
        if ($i % 12 == 0)
        {
            $yearAdd -= 1;
        }
        $daysM = cal_days_in_month(CAL_GREGORIAN, ($i - 12) , $startYear + $yearAdd);
    }
    else
    {
        $daysM = cal_days_in_month(CAL_GREGORIAN, $i, $startYear);
    }

    if ($i == $startMonth)
    {
        $daysM = $daysM - date("d", strtotime($startDate));
    }
    else if ($i == $endMonth)
    {
        $daysM = date("d", strtotime($startDate));
    }

    $profit = $sumLast + ($sumLast + $sumAdd) * $daysM * ($percent / $daysY);
    if ($i != $startMonth)
    {
        $sumLast = $profit + $sumAdd;
    }
}

echo round($sumLast);

//sumCurrent = sumLast +(sumLast+sumAdd)*days(currentmonth)*(percent/daysY)
//backend validation
//$sumN = $sumLast+($sumLast+$sumAdd)*$daysN*($percent/$daysY)
//$lastMonth = date("m",strtotime($_POST["startDate"]));
//sumLast
/*$sumAdd
$daysN= current month day or if deposit was opened this month, current - startdate days
$percent
$daysY
/*Калькулятор высчитывает прибыль за месяц по следующей формуле:
sumN = sumN-1 + (sumN-1 + sumAdd) * daysN * (percent / daysY)

где:

sumN – сумма на счете на N месяц (руб)
sumN-1 – сумма на счете на конец прошлого месяца
sumAdd – сумма ежемесячного пополнения
daysN – количество дней в данном месяце, на которые приходился вклад
percent – процентная ставка банка
daysY – количество дней в году*/

?>
