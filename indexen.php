<?php
session_start();

try
{
  //prod
	$db = new PDO('mysql:host=andreuxbdd.mysql.db;dbname=andreuxbdd;charset=utf8', 'andreuxbdd', 'anCISM893dd');
  //dev
  //$db = new PDO('mysql:host=localhost;dbname=portfolio;charset=utf8', 'guillaume', 'myCISM893ql');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$catStatement = $db->prepare('SELECT * FROM portfolio_categorie');
$catStatement->execute();
$categories = $catStatement->fetchAll();

$utilisateurStatement = $db->prepare('SELECT * FROM portfolio_utilisateur WHERE id=1');
$utilisateurStatement->execute();
$utilisateurs = $utilisateurStatement->fetchAll();

$competencesStatement = $db->prepare('SELECT * FROM portfolio_competence');
$competencesStatement->execute();
$competences = $competencesStatement->fetchAll();

$outilsStatement = $db->prepare('SELECT * FROM portfolio_outil');
$outilsStatement->execute();
$outils = $outilsStatement->fetchAll();

$languesStatement = $db->prepare('SELECT nom, portfolio_niveauLangue.niveau AS niveau FROM portfolio_langue INNER JOIN portfolio_niveauLangue ON idNiveau = portfolio_niveauLangue.id');
$languesStatement->execute();
$langues = $languesStatement->fetchAll();

$parcoursProsStatement = $db->prepare('SELECT *, CASE MONTH(debut)
        WHEN 1 THEN "January"
         WHEN 2 THEN "February"
         WHEN 3 THEN "March"
         WHEN 4 THEN "April"
         WHEN 5 THEN "May"
         WHEN 6 THEN "June"
         WHEN 7 THEN "July"
         WHEN 8 THEN "August"
         WHEN 9 THEN "September"
         WHEN 10 THEN "October"
         WHEN 11 THEN "November"
         ELSE "December"
        END  AS moisDebut
         , YEAR(debut) AS anneeDebut, CASE MONTH(fin) WHEN 1 THEN "January"
         WHEN 2 THEN "February"
         WHEN 3 THEN "March"
         WHEN 4 THEN "April"
         WHEN 5 THEN "May"
         WHEN 6 THEN "June"
         WHEN 7 THEN "July"
         WHEN 8 THEN "August"
         WHEN 9 THEN "September"
         WHEN 10 THEN "October"
         WHEN 11 THEN "November"
         ELSE "December"
        END AS moisFin, YEAR(fin) AS anneeFin FROM portfolio_parcoursPro');
$parcoursProsStatement->execute();
$parcoursPros = $parcoursProsStatement->fetchAll();

$formationsStatement = $db->prepare('SELECT * FROM portfolio_formation ORDER BY annee DESC');
$formationsStatement->execute();
$formations = $formationsStatement->fetchAll();

$realisationsStatement = $db->prepare('SELECT * FROM portfolio_realisation');
$realisationsStatement->execute();
$realisations = $realisationsStatement->fetchAll();

$reseauxStatement = $db->prepare('SELECT * FROM portfolio_reseauxSociaux');
$reseauxStatement->execute();
$reseaux = $reseauxStatement->fetchAll();

$hebergementsStatement = $db->prepare('SELECT * FROM portfolio_hebergement WHERE id =1');
$hebergementsStatement->execute();
$hebergements = $hebergementsStatement->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio</title>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/technology-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    // function AfficheAge() {
    //   var date_day = new Date();
    //   jour_day = date_day.getDate();
    //   mois_day = date_day.getMonth() + 1;
    //   annee_day = date_day.getFullYear();

    //   //calcul de l'âge
    //   var ans;
    //   ((mois_day > 5) || ((mois_day == 5) && (jour_day >= 24))) ? ans = annee_day - 1976 : ans = (annee_day - 1976) - 1;
    //   document.getElementById('age').innerHTML += ans + ' ans ';
    // }


  </script>
  <script src="https://kit.fontawesome.com/3cad3f921f.js" crossorigin="anonymous"></script>
  <!-- <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : 'your_site_key'
        });
      };
    </script> -->

</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <?php foreach ($utilisateurs as $utilisateur): ?>
        <img src="<?php echo $utilisateur['logo']; ?>" alt="" width="50" height="45">
        <?php endforeach; ?>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php foreach ($categories as $categorie): ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#<?= $categorie['idCss']; ?>"><?= $categorie['nomCategorie']; ?></a>
          </li>
            <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </nav>
  <section id="presentation" class="d-flex py-2">
    <div class="container">
      
    <?php foreach ($utilisateurs as $utilisateur): ?>
      <h1 class="my-5 pb-2 text-center"><?php echo $utilisateur['metier']; ?></h1>
      <div class="d-flex flex-wrap flex-sm-nowrap align-items-start justify-content-center">
        <div class="card mb-2 me-2 flex-grow-0 flex-shrink-0">
          <img src="<?php echo $utilisateur['photo']; ?>" class="card-img-top" alt="">
          <div class="card-body">
            <h2 class="card-title text-center"><?= $utilisateur['nom']; ?></h2>
            <p id="age" class="card-text text-center">
            <?php 
            $dateOfBirth = $utilisateur['dateNaissance'];
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            echo $diff->format('%y')." years old"; ?>
            </p>
          </div>
        </div>
        <p class="textPresentation">
          <img class="d-none d-md-inline float-md-end ms-2" src="images/webresponsive-reflet-small.png" alt="" width="150">
          <?= $utilisateur['presentation']; ?>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
  <section id="competences" class="d-flex py-2">
    <div class="container">
      <h1 class="border-bottom border-white border-2 pb-2">Professional skills</h1>
      <div class="row d-flex flex-wrap gx-3">
        <div class="col col-12 col-md-6">
          <h2>Technical skills</h2>
          <ul class="d-flex flex-wrap bgOrange roundedSkill">
          <?php foreach ($competences as $competence): ?>
            <li><i class="<?= $competence['icone']; ?>"></i> <?= $competence['nom']; ?></li>
          <?php endforeach; ?>
          </ul>
        </div>
        <div class="col col-12 col-md-6">
          <h2>Tools</h2>
          <ul class="d-flex flex-wrap bgOrange roundedSkill">
          <?php foreach ($outils as $outil): ?>
            <li><i class="<?= $outil['icone']; ?>"></i></i> <?= $outil['nom']; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="col col-12 col-md-6">
          <h2>Languages</h2>
          <ul class="d-flex flex-wrap bgOrange roundedSkill">
          <?php foreach ($langues as $langue): ?>
            <li><?= $langue['nom']; ?> (<?= $langue['niveau']; ?>)</li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section id="parcours" class="d-flex py-2">
    <div class="container">
      <h1 class="border-bottom border-white border-2 pb-2">Career path</h1>
      <?php foreach ($parcoursPros as $parcoursPro): ?>
      <article class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-start bgBlue bgWhite roundedDate">
        <p><?php echo $parcoursPro['moisDebut']." ".$parcoursPro['anneeDebut']."<br/>".$parcoursPro['moisFin']." ".$parcoursPro['anneeFin']; ?></p>
        <div>
          <img class="float-end" src="<?= $parcoursPro['image']; ?>" alt="">
          <h2><?= $parcoursPro['poste']; ?></h2>
          <p><?php echo $parcoursPro['entreprise']." - ".$parcoursPro['lieu']; ?></p>
          <ul>
          <?= $parcoursPro['contenu']; ?>
          </ul>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>
  <section id="formations" class="d-flex py-2">
    <div class="container">
      <h1 class="border-bottom border-white border-2 pb-2">Trainings</h1>
      <?php foreach ($formations as $formation): ?>
      <article class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-start bgOrange bgWhite roundedDate">
        <p><?= $formation['annee']; ?></p>
        <div>
          <img class="float-end" src="<?= $formation['logo']; ?>" alt="">
          <h2><?= $formation['diplome']; ?></h2>
          <p><?= $formation['organisme']; ?></p>
          <ul>
          <?= $formation['description']; ?>
          </ul>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>
  <section id="realisations" class="d-flex py-2">
    <div class="container">
      <h1 class="border-bottom border-white border-2 pb-2">Achievements</h1>
      <div class="d-flex flex-wrap justify-content-center justify-content-md-between">
      <?php foreach ($realisations as $realisation): ?>
        <div class="card mb-2">
          <img src="<?= $realisation['image']; ?>" class="card-img-top" alt="...">
          <div class="card-body d-flex flex-column flex-nowrap">
            <h2 class="card-title"><?= $realisation['titre']; ?></h2>
            <?= $realisation['description']; ?>
            <?php if ($realisation['lien'] == null) { ?>
              <a href="#" target="_blank" class="btn btn-primary disabled mt-auto">This website is no longer online</a>
            <?php } else { ?>
              <a href="<?= $realisation['lien']; ?>" target="_blank" class="btn btn-primary mt-auto">Visit the website <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            <?php } ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <section id="contact" class="d-flex py-2">
  <!-- <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script> -->
    <div class="container">
      <h1 class="border-bottom border-white border-2 pb-2">Contact</h1>
      
      <?php
      
      if(isset($_POST) && isset($_POST["envoimail"]) && isset($_POST['captcha'])) {
        
          if($_POST['captcha']==$_SESSION['captcha']) {
            $destinataire = "guillaume@andreux.fr";
            $sujet = "Message depuis le site CV";
            $message = nl2br("Nom : ".$_POST['nom']."\r\n" ."Adresse courriel : ".$_POST['email']."\r\n" . "Message : ".$_POST['message']."\r\n");
            $entete = nl2br('MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=utf-8' . "\r\n".'From: webmaster@andreux.fr'."\r\n".'Reply-To: '.$_POST['email']."\r\n".'X-Mailer: PHP/'.phpversion());

            mail($destinataire, $sujet, $message, $entete);
            echo "<script>alert('Votre message a bien été envoyé. Je vous repondrai dans les plus brefs délais.');</script>";
          } else { 
            
            echo "<script>alert('Votre message n'a pas été envoyé. Les chiffres entrés ne sont pas les bons.');</script>";
          }
      }
      ?>
      <article class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-start bgOrange bgWhite roundedDate">
        <div>
          <h2>Email</h2>
          <p>guillaume@andreux.fr</p>
          <h2>Phone</h2>
          <p>+33675026732</p>
        </div>
      </article>
      <!--<form method="POST">-->
        <!-- <div class="g-recaptcha" data-sitekey="6LfY0c0gAAAAAJj5KqXpprdGzugVwMkJFVinwHm1"></div> -->
        <!-- reCaptcha secret key : 6LfY0c0gAAAAADi9LCvy0HxL0Afq0bK5YsjRMMe8 -->
       <!--<div class="form-group mb-3">
          <label for="nom" class="form-label">Votre nom *</label>
          <input type="text" class="form-control" id="nom" name="nom" placeholder="Jean Martin" required>
        </div>
        <div class="form-grou mb-3">
          <label for="email" class="form-label">Votre courriel *</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
        </div>
        <div class="form-group mb-3">
          <label for="message" class="form-label">Votre message *</label>
          <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
        </div>-->
        <!-- Captcha -->
        <!--<div class="form-group mb-3">
            <label class="form-label" for="captcha"><img src="captcha.php" alt="captcha" /></label>
            <input type="text" name="captcha" id="captcha" class="form-control" placeholder="Copier ces chiffres ici..." required/>
        </div>
        <div>
        <button type="submit" name="envoimail" class="btn btn-info"><span class="glyphicon glyphicon-send"></span> Envoyer</button>
        <button type="reset"  class="btn btn-info "><span class="glyphicon glyphicon-remove"></span> Effacer</button>
        </div>
      </form>-->
      

      <h2 class="text-center  m-3">Follow me!</h2>
      <p class="text-center  m-3">
      <?php foreach ($reseaux as $reseau): ?>
        <a href="<?= $reseau['lien']; ?>" class="link-light"><i class="<?= $reseau['icone']; ?>"></i></a>
      <?php endforeach; ?>
      </p>
      <?php foreach ($utilisateurs as $utilisateur): ?>
      <p class="text-center m-3"> Download my CV in pdf format : <a href="<?= $utilisateur['cv']; ?>" target="_blank" class="link-light">cv.pdf <i class="fa-solid fa-file-pdf"></i></a></p>
      <?php endforeach; ?>  
    </div>
  </section>
  <footer class="text-center">
  <?php foreach ($hebergements as $hebergement): ?>
    <?= $hebergement['nomEditeur']; ?> | © 2022 | All rights reserved | <a data-bs-toggle="modal" data-bs-target="#infos" href="#infos">Terms of use</a>
    <!-- Modal -->
    <div class="modal fade" id="infos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mentions légales</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>This entire site is subject to French and international legislation on copyright and intellectual property. All reproduction rights are reserved, including for iconographic and photographic documents.</p>
            <h2>Hebergeur</h2>
            <p><?= $hebergement['hebergeur']; ?></p>
            <h2>Website publisher</h2>
            <address>
                <p><?php echo $hebergement['nomEditeur']."<br/>".$hebergement['adresseEditeur']; ?></p>
            </address>
          <?php endforeach; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </footer>
  <!-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
</body>

</html>