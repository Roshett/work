<?php

if (!isset($_REQUEST)) {
    return;
}

include('inc/db_connect.php');
include('inc/request.php');
include('config.php');

$data = json_decode(file_get_contents('php://input'));
if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
    return;
switch ($data->type) {
  case 'confirmation':
    echo $confirmationToken;
    break;

  case 'message_new':
    $userId = $data->object->user_id;
    $message = $data->object->body;
    $check = 'SELECT numgroup FROM users WHERE userid = '.$userId;
    $check = $pdo->query($check);
    $check = $check->fetch();
    $group = $check['numgroup'];
    if ($group != ''){
    include('inc/timetable.php');
    switch ($message) {
      case 'Понедельник':
        send_msg($monday, $userId, $token);
      break;
      case 'Вторник':
        send_msg($tuesday, $userId, $token);
      break;
      case 'Среда':
        send_msg($wensday, $userId, $token);
      break;
      case 'Четверг':
        send_msg($thursday, $userId, $token);
      break;
      case 'Пятница':
        send_msg($friday, $userId, $token);
      break;
      case 'Суббота':
        send_msg($saturday, $userId, $token);
      break;
      default:
        $message = 'Твоя группа = '.$group;
        send_msg($message, $userId, $token);
      break;
      }
    }else if ($group == ''){
      switch ($message) {
        case '3ВТИ-3ДБ-040':
          $sql = "INSERT INTO users VALUES ('', '$userId', '$message')";
          $message = 'Твоя группа = '.$message;
          $rs = $pdo->query($sql);
          send_msg($message, $userId, $token);
          break;
        case '1МТМ-3ДБ-035':
          $sql = "INSERT INTO users VALUES ('', '$userId', '$message')";
          $message = 'Твоя группа = '.$message;
          $rs = $pdo->query($sql);
          send_msg($message, $userId, $token);
          break;
        default:
          $message = 'Напиши номер своей группы 3ВТИ-*ДБ-***';
          send_msg($message, $userId, $token);
          break;
      }
    }
    break;
  case 'group_join':
    $userId = $data->object->user_id;
    send_msg('Приветики!', $userId, $token);
    break;

  case 'group_leave':
    $userId = $data->object->user_id;
    send_msg('Пока', $userId, $token);
    break;
}
?>