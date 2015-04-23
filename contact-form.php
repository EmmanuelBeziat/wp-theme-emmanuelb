<?php
/**
 * Handles contact form to WordPress
 *
 * @package WordPress
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

session_start();

/**
 * [Sécurise les champs du formulaire qui ne doivent pas contenir de html]
 * @param  [string] $champ [champ brut envoyé par le formulaire]
 * @return [string]        [chaine de caractères sécurisée]
 */
function mailCleanChamps($champ) {
	return htmlentities(trim(strip_tags(stripslashes($champ))), ENT_NOQUOTES, "UTF-8");
}

/**
 * [Sécurise les champs de texte du formulaire susceptibles de contenir du html (textareas)]
 * @param  [string] $champ [champ brut envoyé par le formulaire]
 * @return [string]        [chaine de caractères sécurisée]
 */
function mailCleanMessage($champ) {
	return strip_tags(htmlentities(trim(stripslashes($champ)), ENT_NOQUOTES, "UTF-8"));
}

/**
 * [Vérifie le token de sécurité du formulaire]
 * @param  [type] $tokenID [description]
 * @return [bool]          [description]
 */
function mailCheckToken($tokenID) {
	if ($tokenID === null || !isset($_SESSION['tokenID']) || !isset($tokenID) || $_SESSION['tokenID'] !== $tokenID)
		return false;
	else
		return true;
}

$contactNom = isset($_POST['name']) ? mailCleanChamps($_POST['name']) : null;
$contactEmail = isset($_POST['email']) ? mailCleanChamps($_POST['email']) : null;
$contactMessage = isset($_POST['message']) ? mailCleanMessage($_POST['message']) : null;
$contactAntispam = isset($_POST['firstname']) ? mailCleanChamps($_POST['firstname']) : null;
$tokenID = isset($_POST['tokenID']) ? mailCleanChamps($_POST['tokenID']) : null;

$_SESSION['mailChamps'] = [
	'name' => $contactNom,
	'email' => $contactEmail,
	'message' => $contactMessage
];

$retour = array();

// Antispam
if (!empty($contactAntispam) || preg_match('#<a href#i', $contactMessage) || preg_match('#boobs#i', $contactMessage) || preg_match('#Д#i', $contactMessage))
	exit('Fonction antispam');

// Si le champ nom est vide
if (empty($contactNom)) :

	$retour = array(
		'error' => true,
		'title' => 'Champ manquant',
		'content' => 'Veuillez remplir le champ « Nom ».',
		'type' => 'alert'
	);

// Si le champ message est vide
elseif (empty($contactMessage)) :

	$retour = array(
		'error' => true,
		'title' => 'Champ manquant',
		'content' => 'Veuillez remplir le champ « Message ».',
		'type' => 'alert'
	);

// Si le champ email est vide ou ne correspond pas à la syntaxe requise de type xxxx@xxxx.xxx
elseif (empty($contactEmail) || !filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) :

	$retour = array(
		'error' => true,
		'title' => 'Champ manquant',
		'content' => 'Votre adresse e-mail n\'est pas complète ou contient des caractéres invalides.',
		'type' => 'alert'
	);

// Token de sécurité
elseif (mailCheckToken($tokenID) === false) :
	$retour = array(
		'error' => true,
		'title' => 'Erreur de sécurité',
		'content' => 'Le jeton de sécurité CSRF est invalide.',
		'type' => 'alert'
	);

endif;

$fomulaireErreurs = array_filter($retour);
if (empty($fomulaireErreurs)) :

	$mailDestinataire  = 'emm_beziat@hotmail.com';

	$mailContenu = array();
	$mailContenu[] = 'Nom : '.$contactNom.'<br />';
	$mailContenu[] = 'Mail : '.$contactEmail.'<br />';
	$mailContenu[] = '<br />Message : <br />'.$contactMessage;
	$mailContenu = join($mailContenu);

	$mailObjet = 'Emmanuel B. - Nouveau mail de '.$contactNom;

	$mailHeaders  = 'From: Emmanuel B.<contact@emmanuelbeziat.com>'."\n";
	$mailHeaders .= 'Reply-To: '.$contactEmail."\n";
	$mailHeaders .= 'MIME-Version: 1.0'."\n";
	$mailHeaders .= 'Content-type: text/html; charset="utf-8"'."\n";
	$mailHeaders .= 'Content-Transfer-Encoding: 8bit'."\n";

	// Envoi du mail
	if (mail($mailDestinataire, $mailObjet, $mailContenu, $mailHeaders)) :
		$retour = array(
			'title' => 'Envoi réussi',
			'content' => 'Merci '.$contactNom.' ! Votre e-mail a été correctement envoyé. Vous recevrez une réponse sous 48h !',
			'type' => 'success'
		);
		unset($_SESSION['mailChamps']);
	else :
		$retour = array(
			'title' => 'Erreur d\'envoi',
			'content' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Merci de me signaler le problème via Twitter.',
			'type' => 'alert'
		);
	endif;
endif;

echo json_encode($retour);