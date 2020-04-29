<?php

function checkloggedin()
{ //simple vérification de la concordance des deux variables
  global $logged_in;
  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != $logged_in) {
    session_destroy();
    header('Location:./?page=login');
  } else {
    return true;
  }
}

function normalize($string)
{
  $table = array(
    'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'd' => 'd', 'Ž' => 'Z', 'ž' => 'z', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c',
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
    'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
    'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
    'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
    'ÿ' => 'y', 'R' => 'R', 'r' => 'r',
  );

  return strtr($string, $table);
}

function conv_prix_eu($prix)
{
  $prix = str_replace('.', ',', $prix);
  return $prix;
}
function conv_prix_sql($prix)
{
  $prix = str_replace(',', '.', $prix);
  return $prix;
}

function date_humain_unix($date_humain)
{
  $date = DateTime::createFromFormat('d/m/Y', $date_humain);
  return ($date->format('Y-m-d'));
}
function date_unix_humain($date_unix)
{
  $date = new DateTime($date_unix);
  return ($date->format('d/m/Y'));
}
function date_unix_humain_tirets($date_unix)
{
  $date = new DateTime($date_unix);
  return ($date->format('d-m-Y'));
}

function jour_date($date_unix)
{
  $date = new DateTime($date_unix);
  $date_dow = $date->format('w');
  $jours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
  return $jours[$date_dow];
}

function num_jour_date($date_unix)
{
  $date = new DateTime($date_unix);
  $jour_num = $date->format('d');
  return $jour_num;
}

function mois_date($date_unix)
{
  $date = new DateTime($date_unix);
  $mois_num = ltrim($date->format('m'), '0') - 1;
  $mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
  return $mois[$mois_num];
}

function annee_date($date_unix)
{
  $date = new DateTime($date_unix);
  $annee = $date->format('Y');
  return $annee;
}

function h_humain($hunix)
{
  $heure = new DateTime($hunix);
  return $heure->format('H\h');
}

function logThis($texte)
{
  $file = __DIR__ . '/../files/log.txt';
  if (!file_exists($file)) {
    fopen($file, 'w');
  }
  // Ouvre un fichier pour lire un contenu existant
  $current = file_get_contents($file);
  $current .= date('d-m-Y H:i') . ' ';
  $current .= $texte;
  $current .= "\n";
  // Écrit le résultat dans le fichier
  file_put_contents($file, $current);
  //
}

function age($date_naissance)
{
  $date_naissance = new DateTime($date_naissance);
  $now = new DateTime();
  $intervalle = $now->diff($date_naissance);
  return $intervalle->y;
}

function secondes_convert($sec)
{
  $seconds = $sec;
  $hours = floor($seconds / 3600);
  $seconds -= $hours * 3600;
  $minutes = floor($seconds / 60);
  $seconds -= $minutes * 60;

  return $minutes.'\''.$seconds.'"'; //24'15"
}

function filesize_formatted($file)
{
    $bytes = filesize($file);

    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' o';
    } elseif ($bytes == 1) {
        return '1 o';
    } else {
        return '0 o';
    }
}

