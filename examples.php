<?php

include('StartSend.php');
require_once('Transliterate.php');
require_once('CountSmsParts.php');


// Код токена вы можете получить здесь: https://app.startsend.ru/user-api/token
$token = ''; // КОД_ВАШЕГО_ТОКЕНА
// Номер телефона для теста
$phone = ''; // НОМЕР ТЕЛ ДЛЯ ТЕСТА



$text    = "Заглавная буква в начале текста";
$comment = "Пример работы транслитерации строки. \"$text\" ";
$translit = Transliterate::getTransliteration($text);
_echo($comment,$translit);

$text    = "прописная буква в начале текста";
$comment = "Пример работы транслитерации строки. \"$text\" ";
$translit = Transliterate::getTransliteration($text);
_echo($comment,$translit);


$string = "Длина этого короткого текста на русском  примерно 70 символов или около того"  ;
$oSize = new CountSmsParts($string);
$res = $oSize->checkTextLength($string);
_echo("Определяем размер сообщения");
_echo("Текст: $string");

_echo("Вызов функции CountSmsParts->checkTextLength:","Частей = ".$res['parts'].", длина=".$res['len']);



// баланс
$sms = new StartSend($token);
$res = $sms->getBalance();
//echo ;
//var_dump ($res);
_echo("Получаем баланс:","Баланс: " . $res->result[0]->balance . " ". $res->currency);


if(false)
{
    _echo("Отправка простого sms-сообщения на номер: $phone");
    /** Отправка простого сообщения: */
    $sms = new StartSend($token);
    $res = $sms->createSMSMessage('Моё сообщение');
    $message_id = $res->message_id;
    $res2 = $sms->sendSms($message_id, $phone);
    if ($res2 == false) {
        _echo ("Во время отправки сообщения произошла ошибка" );
    } else {
        _echo ("Сообщение успешно отправлено, его ID: {$res2->sms_id}");
    }
}



if (false)
{
  _echo("Отправка сообщения с паролем от альфа-имени с ID = 0");
  /** Если у вас пока нет собственного Альфа-имени, то вы можете тестировать от системного Альфа-имени с id=0 */
  $sms = new StartSend($token);
  $alphaname_id = 0;
  $res = $sms->createPasswordObject('both', 5);
  $password_object_id = $res->result->password_object_id;
  $res2 = $sms->sendSmsMessageWithCode('Ваш пароль: %CODE%', $password_object_id, $phone, $alphaname_id);

  if ($res2 == false) {
      _echo ("Во время отправки сообщения произошла ошибка");
  } else {
      _echo ("Сообщение успешно отправлено, его ID: {$res2[0]->sms_id}");
  }
}

if (false)
{
  /**  Получение списка своих сообщений: */
  $sms = new StartSend($token);
  $messages = $sms->getMessagesList();
  echo "<pre>";
  print_r($messages->result);
  echo "</pre>";
}

if (true)
{
  /**  Получение списка Альфа-имен с ID */
  $sms = new StartSend($token);
  $alpha_names = $sms->getAlphaNames();
  echo "<pre>";
  print_r($alpha_names);
  echo "</pre>";
}



if (true)
{
  /**  Получение ID Афьфа имени */
  $sms = new StartSend($token);
  $name = '0'; // Ваше Альфа-имя
  $alphaNameId = $sms->getAlphaNameId($name);
  echo "<pre>";
  print_r($alphaNameId);
  echo "</pre>";

}

function _echo($comment, $result="")
{
    $web = $_SERVER['REQUEST_METHOD'] ?? false;

    if(!$web)
    {
       $d = "\n";
    }
    else {
       $d = "<br />";

    }
    echo "$d";
    echo "Действие: $comment $d" ;

    if(!empty($result))
      echo "Результат: $result $d $d";

}