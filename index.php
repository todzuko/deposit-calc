<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8">
  <title>deposit calculator</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
  <div class="container">
    <h1 class="title">Депозитный калькулятор</h1>
    <p class="subhead">Калькулятор депозитов позволяет рассчитать выши доходы после внесения суммы на счет в банке по определенному тарифу.</p>
    <br>
    <div class="form-container">
      <form action="" method="post" class="calculator-input" id="calculator-input" name="calculator-input">
        <div class="row">
          <div class="input-box date-box">
            <label for="fopendate">Дата открытия</label>
            <input type="date" id="fopendate" name="fopendate" class="date-input" required>
            <!-- date -->
          </div>
          <div class="input-box">
            <div class="combined-input styled-input">
              <input type="text" id="ftermnum" class="text-input" name="ftermnum" required>
                <label for="ftermnum">Срок вклада</label>
              <select id="fterm" name="fterm">
                <option value="month">месяц</option>
                <option value="year">год</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="input-box styled-input">
            <input type="text" class="text-input" id="famount" name="famount" required>
            <label for="famount">Сумма вклада</label>
          </div>
          <div class="input-box styled-input">
            <input type="text" id="finterest" class="text-input" name="finterest" required>
            <label for="finterest">Процентная ставка, % годовых</label>
          </div>
        </div>
        <div class="row">
          <div class="input-box checkbox-field">
            <input type="checkbox" id="freplenishment" class="checkbox-input" name="freplenishment">
            <label class="checkbox-label" for="freplenishment">Ежемесячное пополнение вклада</label>
          </div>
          <div class="input-box styled-input repl-block">
          <input type="text" id="freplamount" class="text-input" name="freplamount" required>
            <label for="freplamount">Сумма пополнения вклада</label>
          </div>
        </div>
        <button type="submit" id ="submitbtn" class="button">Рассчитать</button>

      </form>
    </div>

    <div class="result">
      <hr>
      <p>Сумма к выплате</p>
      <h1 class="result-amount">250 000 Р</h1>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="./script.js"></script>
</html>

<!--
sumN – сумма на счете на N месяц (руб)
sumN-1 – сумма на счете на конец прошлого месяца
percent – процентная ставка банка

    Постарайся реализовать валидацию на стороне фронта используя jQuery Validation Plugin или другой плагин
    Не забывай про валидацию на Backend
    Правила валидации
        Сумма вклада - число от 1000 до 3000000
        Срок вклада - число от 1 до 60 месяцев (или 1 до 5 лет)
        Сумма пополнения вклада - число от 0 до 3000000
        Процентная ставка, % годовых - целое число от 3 до 100
-->