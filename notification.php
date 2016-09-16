<?php
define('FORMKEY','CLE FORMULAIRE');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //post de recup de token
  $token = json_decode(file_get_contents('tokens.json'));

  if(!empty($_GET['token'])){
    $token[] = $_GET['token'];
    file_put_contents('tokens.json', json_encode($token));
  }

  //post de l'envoi de notif
  elseif(!empty($_POST['key'])&&!empty($_POST['title'])&&$_POST['key']==FORMKEY){

    //ios
    $data = json_encode(array(
      'tokens' => $token,
      'profile' => 'notif',
      'notification' => array(
        'title' => $_POST['title'],
        'message' => $_POST['body'],
        'ios' => array(
          'message' => $_POST['body'],
          'payload' => array(
            'actualite' => $_POST['actualiteId']
          )
        )
      )
    ));

    $ch = curl_init('https://api.ionic.io/push/notifications');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer IONIC KEY API',
      'Content-Type: application/json',
      'Content-Length: '.strlen($data)
    ));
    $result = curl_exec($ch);
    curl_close($ch);

    //android
    $data = json_encode(array(
      'registration_ids' => $token,
      'data' => array(
        'title' => $_POST['title'],
        'body' => $_POST['body'],
        'actualite' => $_POST['actualiteId'],
        'image' => 'ICONE DE L’APP'
      )
    ));

    $ch = curl_init('https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: key=FIREBASE KEY API',
      'Content-Type: application/json',
      'Content-Length: '.strlen($data)
    ));
    $result = curl_exec($ch);
    curl_close($ch);

  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Notification Sender</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="page-header">
      <h1>Mobile Notification Sender</h1>
    </div>
    <br/>
    <?php if(isset($result)&&$result):?>
      <div class="alert alert-success" role="alert">La notification a bien été envoyée !</div>
    <?php elseif(isset($result)):?>
      <div class="alert alert-danger" role="alert">Il y a eu un problème lors de l'envoi de votre notification !</div>
    <?php endif;?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label>Clé *</label>
        <input type="password" class="form-control" placeholder="Entrer la clé" name="key" required>
      </div>

      <div class="form-group <?php if(isset($_POST['key'])&&$_POST['key']!==FORMKEY) echo 'error'; ?>">
        <label>Titre *</label>
        <input type="text" class="form-control" placeholder="Entrer un titre" name="title" required>
      </div>

      <div class="form-group">
        <label>Message</label>
        <textarea class="form-control" rows="3" name="body"></textarea>
      </div>

      <div class="form-group">
        <label>Actualité ID</label>
        <input type="number" class="form-control" placeholder="Entrer un id Actualité" name="actualiteId">
      </div>

      <button type="submit" class="btn btn-primary">Envoyer la notification</button>
    </form>
  </div>
</body>
</html>
