<?php

//récup de event sur le google agenda
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,'https://www.googleapis.com/calendar/v3/calendars/ LINK CALENDAR');
$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result);

//parcours des events
foreach ($result->items as $event){

  //récupération des id d'evenement deja envoyé
  $calendarIds = json_decode(file_get_contents('calendarIds.json'));
  $alreadySend = false;
  $tokens = json_decode(file_get_contents('tokens.json'));

  //parcours des ids calendar
  foreach ($calendarIds as $calendarId) {
    if($calendarId == $event->id){
      $alreadySend = true;
    }
  }
  //on saute la boucle si il existe
  if($alreadySend){
    continue;
  }

  //notif ios
  $text = explode('|', $event->summary);

  $data = json_encode(array(
    'tokens' => $tokens,
    'profile' => 'notif',
    'notification' => array(
      'title' => $text[0],
      'ios' => array(
        'message' => $text[0],
        'payload' => array(
          'agenda' => 1
        )
      )
    )
  ));

  $ch = curl_init('https://api.ionic.io/push/notifications');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer IONIC API KEY',
    'Content-Type: application/json',
    'Content-Length: '.strlen($data)
  ));
  $result = curl_exec($ch);
  curl_close($ch);

  //notif android
  $text = explode('|', $event->summary);
  $data = json_encode(array(
    'registration_ids' => $tokens,
    'data' => array(
      'title' => $text[0],
      'body' => $text[1],
      'agenda' => 1,
      'image' => 'IMAGE DE L’APP'
    )
  ));

  $ch = curl_init('https://fcm.googleapis.com/fcm/send');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: key=FIREBASE API KEY',
    'Content-Type: application/json',
    'Content-Length: '.strlen($data)
  ));
  $result = curl_exec($ch);
  curl_close($ch);

  //on ajoute l'id
  $calendarIds[]=$event->id;
  file_put_contents('calendarIds.json', json_encode($calendarIds));
}

?>
