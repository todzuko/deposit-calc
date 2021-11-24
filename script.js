$(document).ready(function() {
  $(".repl-block").hide();
  $(".checkbox-input").click(function() {
    if ($(this).is(":checked")) {
      $(".repl-block").show();
    } else {
      $(".repl-block").hide();
    }
  });

  $('#result').hide();

  $("form[name='calculator-input']").validate({
    rules: {
      fopendate: {
        required: true,
        date: true,
      },

      ftermnum: {
        required: true,
        number: true,
        min: 1,
        max: function(element) {
          if ($("#fterm option:selected").val() === "month") {
            return 60;
          } else {
            return 5;
          }
        }
      },

      famount: {
        required: true,
        number: true,
        min: 1000,
        max: 3000000
      },
      finterest: {
        required: true,
        digits: true,
        min: 3,
        max: 100
      },
      freplamount: {
        required: function(element) {
          return $(".checkbox-input").is(":checked");
        },
        number: true,
        min: 0,
        max: 3000000
      },
    },
    messages: {
      fopendate: {
        required: "Обязательное поле"
      },
      ftermnum: {
        required: "Обязательное поле",
        number: "Введите число",
        max: "Не более 5 лет (60 месяцев)",
      },
      famount: {
        required: "Обязательное поле",
        number: "Введите число",
        min: "Не менее 1000 рублей",
        max: "Не более 3000000 руьлей"
      },
      finterest: {
        required: "Обязательное поле",
        digits: "Введите целое число",
        min: "Не менее 3%",
        max: "Не более 100%"
      },
      freplamount: {
        required: "Обязательное поле",
        number: "Введите число",
        min: "Не менее 0 рублей",
        max: "Не более 3000000 рублей"
      }
    },
  });

  $("#submitbtn").on('click', function(event) {
    if (!$("form[name='calculator-input']").valid()) {
      return;
    }

    event.preventDefault();
    //passing raw data to server side to make all needed changes on server in case js is disables or changed
    let obj = {
      'fopendate': $('#fopendate').val(),
      'famount': $('#famount').val(),
      'ftermnum': $('#ftermnum').val(),
      'fterm': $('#fterm').val(),
      'finterest': $('#finterest').val(),
      'freplenishment': $("#freplenishment").is(":checked"),
      'freplamount': $('#freplamount').val(),
    };

    $.ajax({
      type: "POST",
      url: 'calc.php',
      dataType: 'json',
      data: obj,

      success: function(result) {
        const res = (JSON.parse(result));
        $('#error').hide();
        $('#result').show();
        $('#result-amount').html(`${res} ₽`);
      },
      error: function(ajaxContext) {
        $('#error').show();
        $('#result').hide();
        $('#error').html(`${ajaxContext['responseText']}`);
      }
    });
  });
});
