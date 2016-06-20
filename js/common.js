
//Активация плагина фэнсибокс
$(".new_order").fancybox(
{
 'padding' : ['6','6','6','6'],
  helpers : {
       overlay : {
                 css : {'background' : 'rgba(0,0,0, 0.9)'}
                 }
            }         
});

$(".edit_order").fancybox(
{
 'padding' : ['6','6','6','6'],
  helpers : {
       overlay : {
                 css : {'background' : 'rgba(0,0,0, 0.9)'}
                 }
            }         
});







var sum_orders = 0, // сумма заказов
orders = [], // заказы
goods = [], // товары
count = 0, 
time_goods = [], // временный массив с товарами
itog_zakaz = 0, //сумма товаров
your_choise = "", // выбор для сохранения
id_edit_order; // id редактируемого товара


// подгрузка всех заказов
load_order();

// подгрузка товаров
  $.ajax({
  data : {variant: "good" },
  url : 'php/getdata.php',
  global : false,
  type : "GET",
  dataType : "html",
  async : false}).done(function(result) {
    goods = JSON.parse(result);
  });

//нажатие на кнопку "новый заказ" 
$('.new_order').on('click', function()
{
  your_choise = "new";
});


// добавление нового товара товар
$('#new_good').on('click', function()
{
  var spisok = "";
      time_goods.push({idstroka: count, good_name: goods[0].good_name, idgood: goods[0].idgood, good_price: goods[0].good_price, countgood: 1});
  itog_order(time_goods);
  for (var i = 0; i < goods.length; i++) {
    spisok += "<option value='"+goods[i].idgood+"'>" + goods[i].good_name + "</option>";
  }
  $(".list_view_good table").append("<tr id = '"+ count +"'>"+
    "<td><img class='delete_good' src='img/delete.png'><select class='choise'>" +spisok +"</select></td>"+
    "<td>"+goods[0].good_price+"</td>"+
    "<td><span id='minus'>-</span>     "+ 1 +"    <span id='plus'>+</span></td>"+
    "<tr>");
    count ++;
});



//  редактируемый заказ
$(document).on('click', ".list_view .edit_order", function()
{
  your_choise = "edit";
  var srtroka = $(this).parent().parent().attr("id");
  id_edit_order = srtroka;
for (var i = 0; i < orders.length; i++) {
  if ( "id"+orders[i].idorder === srtroka )
  {
      srtroka = i;
      break;
  }
}

for (var i = 0; i < orders[srtroka].good.length; i++) {
    var spisok = "";
    time_goods.push({idstroka: count, idgood: orders[srtroka].good[i].idgood, 
      good_price: orders[srtroka].good[i].good_price, 
      countgood: orders[srtroka].good[i].countgood,
      good_name: orders[srtroka].good[i].good_name});
    itog_order(time_goods);
    var id_gp = 0;
for (var j = 0; j < goods.length; j++) {
    if ( goods[j].idgood === orders[srtroka].good[i].idgood){
    spisok += "<option selected value='"+goods[j].idgood+"'>" + goods[j].good_name + "</option>"; 
    id_gp = j;
    }
    else spisok += "<option value='"+goods[j].idgood+"'>" + goods[j].good_name + "</option>";
    }
$(".list_view_good table").append("<tr id = '"+ count +"'>"+
  "<td><img class='delete_good' src='img/delete.png'><select class='choise'>" +spisok +"</select></td>"+
  "<td>"+goods[id_gp].good_price+"</td>"+
  "<td><span id='minus'>-</span>     "+ orders[srtroka].good[i].countgood +"    <span id='plus'>+</span></td>"+
  "<tr>");
  count ++;
  }});

// удаление заказа
$(document).on('click', ".list_view .delete_order", function()
{
  var srtroka = $(this).parent().parent().attr("id");

  for (var i = 0; i < orders.length; i++) {
      if ( "id"+orders[i].idorder === srtroka )
      {
        srtroka = i;
        break;
      }
  }
delete_order(orders[srtroka].idorder);
orders.splice(srtroka++,1);
$("tr#id" + +srtroka).remove();
refresh_orders(orders);
});


// ОТМЕНА
$('#close_fan').on('click', function()
{
clear();
});



// сохранение заказа
$(document).on('click', "#save_order", function()
{
  var time_array = [];
  if ( your_choise === "new")
  {
    for (var i = 0; i < time_goods.length; i++) {
      time_array.push(
            {
                good_name : time_goods[i].good_name,
                countgood : time_goods[i].countgood,
                good_price : time_goods[i].good_price,
                idgood: time_goods[i].idgood
            }
          );
    } 
    orders.push(
      {
        idorder: null,
        sum_order: itog_zakaz,
        good : time_array
      });
  }

  if ( your_choise === "edit")
  {
    for (var i = 0; i < time_goods.length; i++) {
      time_array.push(
            {
                good_name : time_goods[i].good_name,
                countgood : time_goods[i].countgood,
                good_price : time_goods[i].good_price,
                idgood: time_goods[i].idgood
            }
          );
    }
    var this_gay;
    for (var i = 0; i < orders.length; i++) {
     if ( "id" + orders[i].idorder === id_edit_order ) 
     {
      this_gay = i; break;
     }
    }
    orders[this_gay].sum_order = itog_zakaz;
    orders[this_gay].good = time_array;
    refresh_orders(orders);
  }
  save_bd();
  clear();
});


// Выбор нового товара
$(document).on('change', 'select', function () {
 var id = $(this).val(),
 srtroka = $(this).parent().parent().attr("id");
 for (var i = 0; i < time_goods.length; i++) {
  if (time_goods[i].idstroka === +srtroka)
  {
    time_goods[i].idgood = id;
    srtroka = i;
    break;
  } 
 }
 
 for (var i = 0; i < goods.length; i++)
 {
  if (goods[i].idgood ===  time_goods[srtroka].idgood)
  {
    time_goods[srtroka].good_price = goods[i].good_price;
    break;
  }
 }
 $(this).parent().parent().children().get(1).innerHTML = time_goods[srtroka].good_price;

 itog_order(time_goods);
});


// Удаление товаров
$(document).on('click', ".delete_good" , function () {
var srtroka = $(this).parent().parent().attr("id");
$("tr#" + +srtroka).remove();
for (var i = 0; i < time_goods.length; i++) {
  if (time_goods[i].idstroka === +srtroka)
  {
    srtroka = i;
    break;
  } 
 }
time_goods.splice(srtroka++,1);
itog_order(time_goods);
});


// Увеличение, уменьшение единиц продукции
$(document).on('click', "#goods_table span" , function () {
var srtroka = $(this).parent().parent().attr("id");
for (var i = 0; i < time_goods.length; i++) {
  if (time_goods[i].idstroka === +srtroka)
  {
    srtroka = i;
    break;
  } 
 }
if ($(this).attr("id") === "minus" && time_goods[i].countgood > 1)
{
  time_goods[i].countgood --;
   $(this).parent().parent().children().get(2).innerHTML = "<span id='minus'>-</span>     "+ time_goods[srtroka].countgood +"    <span id='plus'>+</span>"; 
}

if ($(this).attr("id") === "plus")
{
  time_goods[i].countgood ++;
  $(this).parent().parent().children().get(2).innerHTML = "<span id='minus'>-</span>     "+ time_goods[srtroka].countgood +"    <span id='plus'>+</span>";
}

itog_order(time_goods);
});





// Сортировка заказов
function unique(arr) {
  var obj = {};

  for (var i = 0; i < arr.length; i++) {
    var str = arr[i];
    obj[str] = true; 
  }

  return Object.keys(obj); 
}

// обновление списка товаров
function refresh_orders(array)
{
  sum_orders = 0;
  $(".list_view table").html("");
  for (var i = 0; i < array.length; i++) {
  $(".list_view table").append("<tr id = id" + array[i].idorder + ">"+
    "<td> № " + array[i].idorder + "</td>"+
    "<td>" + array[i].sum_order + "</td>"+
    "<td><img src='img/delete.png' class='delete_order'><img href='#order_dialog' src='img/edit.png' class='edit_order'></td>"+
    "</tr>");
    sum_orders += array[i].sum_order;
  }
  $("#sum_orders").html("Сумма по всем заказам: " + sum_orders);
}

// адаптация json массива
function array_adaptation(data,orders)
{
  for (var i = 0; i < data.length; i++) {
      orders.push(data[i].idorder);
  }
  orders = unique(orders);
  for (var i = 0; i < orders.length; i++) {
    
    orders[i] = { idorder : orders[i] };
    var time_array = [],
    sum_order = 0;
    for (var j = 0; j < data.length; j++) {
      if ( orders[i].idorder === data[j].idorder ) 
      {
        time_array.push(
            {
                good_name : data[j].good_name,
                countgood : data[j].countgood,
                good_price : data[j].good_price,
                idgood: data[j].idgood
            }
          );
        sum_order += data[j].good_price * data[j].countgood;
      }
    }
    orders[i].good = time_array;
    orders[i].sum_order = sum_order;
    sum_orders += orders[i].sum_order;
  }
  return orders;
}

// обновление итога одного заказа
function itog_order(array)
{
  itog_zakaz = 0;
  for (var i = 0; i < array.length; i++) {
    itog_zakaz += array[i].good_price * array[i].countgood;
  }
  $("#itog").html("Итого: " + itog_zakaz);
}

// Очистка информации после закрытия фэнсибокс
function clear()
{
count = 0;
itog_zakaz = 0;
time_goods = [];
itog_order(time_goods);
$(".list_view_good table").html("");
$('.fancybox-close').click();
}

// сохранение результатов в БД
function save_bd()
{
var tmp = JSON.stringify(orders);
  $.ajax({
    type: 'POST',
    url: 'php/setdata.php',
    data: {'categories': tmp},
    
    beforeSend: function(){
    $("#imgLoad").css({"display":"inline"});
    },
  
    success: function() {
    load_order();
    }});
}

// загрузка заказов в json 
function load_order()
{
  $.ajax({
  data : { variant: "all" },
  url : 'php/getdata.php',
  global : false,
  type : "GET",
  dataType : "html",
  
  beforeSend: function(){
  $("#imgLoad").css({"display":"inline"});
  },
  
  success: function(result) {
  var data;
  data = JSON.parse(result);
  orders = [];
  orders = array_adaptation(data,orders);
  refresh_orders(orders);
  $("#imgLoad").css({"display":"none"});
  }});
}

// удаление заказа
function delete_order(id)
{
  this.id = id;
  $.ajax({
  data : { idorder : id },
  url : 'php/deletedata.php',
  global : false,
  type : "GET",
  dataType : "html",
  beforeSend: function(){
  $("#imgLoad").css({"display":"inline"});
  },
  
  success: function() {
  $("#imgLoad").css({"display":"none"});
  }});
}



