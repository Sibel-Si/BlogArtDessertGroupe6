<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../functions/global.inc.php';
require_once __DIR__ . '/../../functions/ctrlSaisies.php';

//Il y a eu un beug sur le reCAPTCHA du mercredi 04 février le matin au jeudi 05 février, je le met en commentaire car aucunes solutions n'a aboutie pour le rendre fonctionnel
// if (!isset($_POST['pseudoMemb'], $_POST['passMemb'], $_POST['g-recaptcha-response'])) {
//     header('Location: /views/backend/security/login.php');
//     exit;
// }

$pseudo = ctrlSaisies($_POST['pseudoMemb']);
$pass   = ctrlSaisies($_POST['passMemb']);
//$captchaRes = $_POST['g-recaptcha-response'];

if ($pseudo === '' || $pass === '') {
    $_SESSION['login_error'] = "Champs obligatoires manquants.";
    header('Location: /views/backend/security/login.php');
    exit;
}

//Il y a eu un beug sur le reCAPTCHA du mercredi 04 février le matin au jeudi 05 février, je le met en commentaire car aucunes solutions n'a aboutie pour le rendre fonctionnel
//Dans la matinée du jeudi 05 février, Florian et Gwendal ont essayé de m'aider en rajoutant des balises (celles qui sont ci-dessous) c'est pour celà que le code n'est plus similaire aux autres fichiers qui contiennent le reCAPTCHA 

// $secretKey = "6LcBgWAsAAAAAPOCwFqU7RpKNOrAZV6tagbaKL5S";
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    //'secret'   => $secretKey,
    //'response' => $captchaRes
//]));
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($ch);

//if(curl_error($ch)) {
   //$error_msg = curl_error($ch);
   //var_dump($error_msg); exit();
//}

//curl_close($ch);

//$captchaSuccess = json_decode($response);

//var_dump($captchaRes);
//var_dump($response); exit();

//if (!$captchaSuccess->success || $captchaSuccess->score < 0.5) {
    //$_SESSION['login_error'] = "Vérification reCAPTCHA échouée.";
    //header('Location: /views/backend/security/login.php');
    //exit;
//}

$membre = sql_select(
    'membre',
    '*',
    "pseudoMemb = '$pseudo'"
);

// Check if user exists
if (!$membre || count($membre) !== 1) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// CHECK HASH HERE
if (!password_verify($pass, $membre[0]['passMemb'])) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// 7. Success → Create session
$_SESSION['id_user'] = $membre[0]['numMemb'];

header('Location: /');
exit;