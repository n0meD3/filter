$( document ).ready(function() {
    $("#filt").click(
		function(){

      var id = document.getElementById("filt").value;

			sendAjaxFormdel('filt', 'ajax_form_del', 'on_off.php');
			return false;
		}
	);
});

function sendAjaxFormdel(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = response;
          var err = document.getElementById("result_err"); // получение переменной имени компании-перевозчика
          err.innerHTML = result.err;
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_err').html('Ошибка. Данные не отправлены.');
    	}
 	});
}

$( document ).ready(function() {
    $("#add").click(
    function(){ // фунция для очистки поля div, в который мы выводим всю информацию
      var ip = document.getElementById("result_ip"); // обращение к полю div с id-шником result_name
      ip.innerHTML = "";

      var adress = document.getElementById("result_adress"); // обращение к полю div с id-шником result_phone
      adress.innerHTML = "";

      var reason = document.getElementById("result_reason"); // обращение к полю div с id-шником result_link
      reason.innerHTML = "";

      var err = document.getElementById("result_err"); // обращение к полю div с id-шником result_link
      err.innerHTML = "";

      sendAjaxForm('result_form', 'ajax_form', 'addjs.php'); // отправка запроса в наш основной файл-обработчик
      return false;
    }
  );
});

function sendAjaxForm(result_form, ajax_form, url) { // функция отправки данных в наш файл-обработчик
    $.ajax({
        url:     "addjs.php", //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response); // распарсим полученные данные

            var ip = document.getElementById("result_ip"); // получение поля для переменной имени компании-перевозчика
            result.ip.forEach(e => ip.innerHTML += "<p>" + e + "</p>"); // перебор циклом foreach, на случай, если будет не одно имя

            var adress = document.getElementById("result_adress"); // получение поля для переменной номера компании-перевозчика
            result.adress.forEach(e => adress.innerHTML += "<p>" + e + "</p>"); // перебор циклом foreach, на случай, если будет не однин номер

            var reason = document.getElementById("result_reason"); // получение переменной имени компании-перевозчика
            result.reason.forEach(e => reason.innerHTML += "<p>"+e+"<p>"); // уже на момент написания коментариев заметил, что тут цикл то не нужен, т.к. ф файле core.php я специально ссылку оставил в единичном экземпляре

            var err = document.getElementById("result_err"); // получение переменной имени компании-перевозчика
            result.err.forEach(e => err.innerHTML += "<p>"+e+"<p>"); // уже на момент написания коментариев заметил, что тут цикл то не нужен, т.к. ф файле core.php я специально ссылку оставил в единичном экземпляре

        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.'); // ошибка получения данных
        }
    });
}


var statusIntervalId = self.setInterval(update, 1000);
function update()
{
var xhr = new XMLHttpRequest();
xhr.open("GET", 'showjs.php');

xhr.onload = function (){
  result = $.parseJSON(xhr.responseText);

  var ip = document.getElementById("result_ip"); // получение поля для переменной имени компании-перевозчика
  ip.innerHTML = "";
  result.ip.forEach(e => ip.innerHTML += "<p>" + e + "</p>"); // перебор циклом foreach, на случай, если будет не одно имя

  var adress = document.getElementById("result_adress"); // получение поля для переменной номера компании-перевозчика
  adress.innerHTML = "";
  result.adress.forEach(e => adress.innerHTML += "<p>" + e + "</p>"); // перебор циклом foreach, на случай, если будет не однин номер

  var reason = document.getElementById("result_reason"); // получение переменной имени компании-перевозчика
  reason.innerHTML = "";
  result.reason.forEach(e => reason.innerHTML += "<p>"+ e +"<p>"); // уже на момент написания коментариев заметил, что тут цикл то не нужен, т.к. ф файле core.php я специально ссылку оставил в единичном экземпляре

  var del = document.getElementById("result_del"); // получение переменной имени компании-перевозчика
  del.innerHTML = "";
  result.del.forEach(e => del.innerHTML += "<p>"+ e +"<p>"); // уже на момент написания коментариев заметил, что тут цикл то не нужен, т.к. ф файле core.php я специально ссылку оставил в единичном экземпляре

  var state = document.getElementById("filt"); // получение переменной имени компании-перевозчика
  state.innerHTML = result.state;
  //$('#filt').html(xhr.responseText);
}

xhr.send();
}
