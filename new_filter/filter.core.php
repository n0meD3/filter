<?php
/**
 *
 */
class FilterSupp
{

  function response() {
    global $response;
    $response = new stdClass();
  }

  // function check() {
  //
  //   require_once "db.php";
  //   $red = 'buttred1';
  //   $green = 'button1';
  //   $select = "SELECT state from allfilter where ip = '6.6.6.6'";
  //   $result = mysqli_query($conn, $select);
  //       foreach($result as $row){
  //           $ss = $row['state'];
  //       }
  //   echo $ss;
  //   if($ss == 6) {
  //     $class = $green;
  //     $state = "<input class='button $class' name='state' id='state' type='submit' value='Общий фильтр включен'>";
  //     //$state_json = json_encode($response);
  //     //echo $state_json;
  //     return $state;
  //   } elseif($ss == 0) {
  //     $class = $red;
  //     $state = "<input class='button $class' name='state' id='state' type='submit' value='Общий фильтр выключен'>";
  //     //$state_json = json_encode($response);
  //     //echo $state_json;
  //     return $state;
  //   }
  //
  // }

  function filter() {

    require_once "db.php";
    $date = date("Y-m-d H:i:s");
    $token = "5061699167:AAEk21RrUw1mJRH7QR6PAgkZ-F8yzv8RHyY";
    $chat_id = "241770563";
    $on = "Общий фильтр был активирован ".$date;
    $off = "Общий фильтр был деактивирован ".$date;

	  $select = "SELECT state from allfilter where ip = '6.6.6.6'";
	  $result = mysqli_query($conn, $select);
    foreach($result as $row){
  		    $ss = $row['state'];
    }

	  if($ss == 6){
		    $select = "update allfilter set state=0 where ip='6.6.6.6'";
		    if(mysqli_query($conn, $select)){
			      fopen("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&parse_mode=html&text=".$off,"r");
		     }
         mysqli_close($conn);
        }
    elseif($ss == 0){
		     $select = "update allfilter set state=6 where ip='6.6.6.6'";
		     if(mysqli_query($conn, $select)){
			       fopen("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&parse_mode=html&text=".$on,"r");
		     }
         mysqli_close($conn);
        }
    }

  function add($ip, $res) {

    $ips = '"'.$ip.'"';
    	if(empty($ip)){
        $response->ip[] = "";
        $response->adress[] = "";
        $response->reason[] = "";
        $response->err[] = "Введите ip-адрес оборудования";
        $responseJSON = json_encode($response);
        print_r($responseJSON);
        die();
    	} elseif(empty($res)) {
        $response->ip[] = "";
        $response->adress[] = "";
        $response->reason[] = "";
        $response->err[] = "Выбери причину блокировки";
        $responseJSON = json_encode($response);
        print_r($responseJSON);
        die();
    	}

    require_once "db.php";
    $select = "select address from switchs where ip = $ips";
    $result = mysqli_query($conn1, $select);
    foreach($result as $row){
      $addr = $row['address'];
      //echo $row['address'];
    }

    if(empty($addr)){
      $response->ip[] = "";
      $response->adress[] = "";
      $response->reason[] = "";
      $response->err[] = "Ip не найден. Проверьте Ip и повторите попытку";
      $responseJSON = json_encode($response);
      print_r($responseJSON);
      die();
    }
    // else {
    //   $response->err[] = "ok";
    //   $response->ip[] = $ip;
    //   $response->adress[] = $addr;
    //   $response->reason[] = $res;
    //   $responseJSON = json_encode($response);
    //   print_r($responseJSON);
    // }

    $select1 = "select ip from blocked where ip = $ips";
    $result = mysqli_query($conn, $select1);
    foreach($result as $row){
      $equip = $row['ip'];
    }
    if(isset($equip)){
      $response->ip[] = "";
      $response->adress[] = "";
      $response->reason[] = "";
      $response->err[] = "Данный Ip уже занесён в список";
      $responseJSON = json_encode($response);
      print_r($responseJSON);
      die();
    }

    $select2 = "select id from blocked";
    $result = mysqli_query($conn, $select2);
    while($row = mysqli_fetch_assoc($result)) {
      $genid = $row['id'];
    }
    $aid = $genid + 1;
    //echo $aid;
    $addrs = '"'.$addr.'"';
    $select3 = "insert into blocked(id,ip,name,reason) values($aid, $ips, $addrs, $res)";
    if(mysqli_query($conn, $select3)){

    } else {
      echo "Ошибка: " . mysqli_error($conn);
    }

    mysqli_close($conn);

  }

  function show() {

      require_once "db.php";
      $red = 'buttred1';
      $green = 'button1';
      $select = "SELECT state from allfilter where ip = '6.6.6.6'";
      $result = mysqli_query($conn, $select);
          foreach($result as $row){
              $ss = $row['state'];
          }

      if($ss == 6) {
        $class = $green;
        $state = "<input class='button $class' name='state' id='state' type='submit' value='Общий фильтр включен'>";
      } elseif($ss == 0) {
        $class = $red;
        $state = "<input class='button $class' name='state' id='state' type='submit' value='Общий фильтр выключен'>";
      }

    $response->state = $state;
    $select = "select * from blocked";
    $result = mysqli_query($conn, $select);

    foreach($result as $row){
      $id = $row['id'];
      $response->id[] = $row['id'];
      $response->ip[] = $row['ip'];
      $response->adress[] = $row['name'];
      if ($row['reason'] == 1) {
        $res = "Нет электричества";
      } else {
        $res = "Поломка";
      }
      $response->reason[] = $res;
      $response->del[] =  "<button id='del' name='del' class='buttred buttred1' value='$id'>Удалить</button>";//"<input class='button buttred' name='state' id='state' type='submit' value='Удалить'>";//
      $responseJSON = json_encode($response);
    }
    print_r($responseJSON);
    mysqli_close($conn);
  }

  function delete($id) {

    require_once "db.php";
    $select = "delete from blocked where id = $id";
    if(mysqli_query($conn, $select)){
      print_r(json_encode('ok'));
    }
    mysqli_close($conn);
  }
}
