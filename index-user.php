<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} else {
    // since the username is not set in session, the user is not-logged-in
    // he is trying to access this page unauthorized
    // so let's clear all session variables and redirect him to index
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Art</title>
	<link rel="stylesheet" href="scss/index.scss">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	</head>
<body>
<div class="user-container" style="background-color: #000; height: 30px; padding: 0 30px">
		<div class="page-header">
		    <a href="login/logout.php" style="float: right; color: #fff; text-decoration: none;">Odjavi se</a>
		</div>
		<div class="page-content" style="float: left; color: #fff;">Zdravo <?php echo $username;?></div>
	</div>
<!--Slider-->
<div id="slider">
	<div id="headerSlider" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
		  <li data-target="#headerSlider" data-slide-to="0" class="active"></li>
		  <li data-target="#headerSlider" data-slide-to="1"></li>
		  <li data-target="#headerSlider" data-slide-to="2"></li>
		  <li data-target="#headerSlider" data-slide-to="3"></li>
		  <li data-target="#headerSlider" data-slide-to="4"></li>
		</ol>
		<div class="carousel-inner">
		  <div class="carousel-item active ">
			<img src="img/first.jpg" class="d-block img-fluid" alt="first"  height="500px" width="100%">
			<div class="carousel-caption " >
				<img src="img/mdlogo1.png"  alt="logo" >
				</div>
		  </div>
		  <div class="carousel-item">
			<img src="img/Slika (5).jpg" class="d-block img-fluid" alt="art" height="500px" width="50%">
		    <div class="carousel-caption">
				<a href="buy/art.php"> <img src="img/arrow.png"  alt="artLogo" style="float: right; margin-right: 23.3%;"></a>
			</div>
	      </div>
		  <div class="carousel-item">
			<img src="img/crtez.jpg" class="d-block img-fluid" alt="draw"  height="500px" width="50%">
			<div class="carousel-caption">
				<a href="buy/draw.php"><img src="img/arrow.png"  alt="drawLogo" style="float: right; margin-right: 23.3%;"></a>
				
			</div>
		  </div>
		  <div class="carousel-item">
			<img src="img/sculpture (1).jpg" class="d-block img-fluid" alt="sculpture" height="500px" width="50%">
			<div class="carousel-caption">
				<a href="buy/sculpture.php"><img src="img/arrow.png"  alt="sculptureLogo" style="float: right; margin-right: 23.3%;" ></a>
				
			</div>
		  </div>
		  <div class="carousel-item">
			<img src="img/youcreate.jpg" class="d-block img-fluid" alt="create"  height="500px" width="50%">
			<div class="carousel-caption">
				<a href="order/create.php"><img src="img/arrow.png"  alt="createLogo" style="float: right; margin-right: 23.3%;"></a>
				
			</div>
		  </div>
		</div>
		<a class="carousel-control-prev" href="#headerSlider" role="button" data-slide="prev">
		  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		  <span class="sr-only">Prethodna</span>
		</a>
		<a class="carousel-control-next" href="#headerSlider" role="button" data-slide="next">
		  <span class="carousel-control-next-icon" aria-hidden="true"></span>
		  <span class="sr-only">Sledeća</span>
		</a>
	  </div>
</div>
<!--About-->
<section id="about" style="height: 400px;">
	<div class="container" >
		<div class="row" >
			<div class="col-md-6" >
				<img src="img/Maja.jpg" alt="Maja" style="width:200px;height:250px;margin-top: 70px;float:left;">
				<h2 style="margin-top: 70px;margin-left: 40%;">Maja Distl</h2>
				<h5 style="margin-left: 40%;">Umetnica</h5>  
				<p style="text-align: justify;margin-left: 40%;">"Imam 20 godina. Za sebe volim da kažem da sam umetničko-sportska duša. 
					Završila sam srednju politehničku školu,
					smer Likovni tehničar u Subotici gde sam i rođena. 
					Takođe bavim se sportom ceo svoj život. 
					Trenutno studiram u Novom Sadu na Akademiji umetnosti, smer Slikarstvo."
				</p> 
				
				

			</div>
			<div class="col-md-2 col-lg-2 text-center mx-auto my-4">
  
				<!-- Social buttons -->
				<h5 class="font-weight-bold text-uppercase mb-4"  style="margin-top: 70px;">Zapratite:</h5>
		
				<!-- Facebook -->
				<a type="button" class="btn-floating btn-fb">
					<a href="#"><img src="img/facebook.png"  alt="facebook" style="width: 50px; height: 50px; border-radius: 25px;"></a>
				</a><br><br>
				<!-- Instagram -->
				<a type="button" class="btn-floating btn-tw">
					<a href="#"><img src="img/instagram.png"  alt="instagram" style="width: 50px; height: 50px; border-radius: 25px;"></a>
				</a><br><br>
			   
				
			  </div>
			 
		  
			
		</div>
	</div>
</section>
<!--Techniques-->
<section id="techniques">
	<div class="container">
		<h1 style="text-align: center;padding-bottom: 10px;">Tehnike</h1>
		<div class="row">
			<div class="col-md-3 text-center">
				<div class="icon">
					<i class="fas fa-palette"  style="float: left;"></i>
				</div>
				<h3>Akril na platnu</h3>
				<p>Akril je slikarska tehnika.
					Akrilne boje su vrsta brzosušećih boja. 
					U svežem stanju mogu se razređivati vodom,
					dok su kad se osuše vodootporne.
					Slike ra]ene akrilom ne mogu da propadnu,
					pod uslovom da se čuvaju u adekvatnim uslovima.
				</p>
			</div>
			<div class="col-md-3 text-center">
				<div class="icon">
					<i class="fas fa-paint-brush"  style="float: left;"></i>
				</div>
				<h3>Akvarel<br>(Vodene boje)</h3>
				<p>
				   Vodom razređene boje se na papir visoke gramaže(kako nebi dolazilo do savijanja papira) nanose mekanim četkicama.
				   U ovom načinu slikanja se ne koristi bela boja,
		           pošto svetle i tamne tonove dobijamo dodavanjem više ili manje vode.
				   Delovi slike koji treba da ostanu beli, ostavljamo neslikanim.
				</p>

				</div>
			<div class="col-md-3 text-center">
				<div class="icon">
					<i class="fas fa-pencil-alt" style="float: left;"></i>
				</div>
				
				<h3>Grafitna olovka</h3>
				<p>Olovka,u užem smislu je isključivo crtački materijal, linijskog karaktera, tamnijeg ili svetlijeg tona.
				   Stvaranje crteža na površini,tj. papiru putem linija tački i mrlja.
				   Crtež olovkom je veoma stabilna tehnika otporna na vlagu. Nedostatak brisanja eliminiše se fiksiranjem.
				</p>
				
			</div>
			<div class="col-md-3 text-center">
				<div class="icon">
					<i class="fas fa-pencil-alt"  style="float: left;"></i>
				</div>
				<h3>Drvene boje</h3>
				<p>
				   Pogodne su za upotrebu jer ne ostavljaju nikakve fleke i lake su za upotrebu, a ostavljaju zadovoljavajuće rezultate.
				   Pigmenti drvenih boja su najpogodniji za nanošenje na papir i nisu za tvrde materijale. 
				   Moguće je spojiti linije različitih boja i na taj način dobiti u potpunosti novu nijansu.

				</p>
				
			</div>
			
		</div>
	</div>
	
</section>
<!-- Footer -->
<footer class="page-footer font-small mdb-color lighten-3 pt-4">

	<!-- Footer Links -->
	<div class="container text-center text-md-left">
  
	  <!-- Grid row -->
	  <div class="row">
  
		<!-- Grid column -->
		<div class="col-md-4 col-lg-3 mr-auto my-md-4 my-0 mt-4 mb-1">
  
		  <!-- Content -->
		  <h5 class="font-weight-bold text-uppercase mb-4">O Galeriji</h5>
		  <p style="text-align: justify;">"Ovo je online galerija mojih umetničkih radova, 
			a u budućnosti bih volela da bude, kako često volim da kazem, 
			stvarna i da svako može da je poseti kad god poželi. 
			Jedna od mojih najvećih želja jeste da jednog dana zarađujem i 
			živim od novca stečenog svojim talentom, trudom i radom, 
			da svima koji su me ubeđivali da je to nemoguće pokažem svoj uspeh."
		</p>
  
		  </div>
  
		<hr class="clearfix w-100 d-md-none">
  
		
		<div class="col-md-4 col-lg-3 mx-auto my-md-4 my-0 mt-4 mb-1">
  
		  <!-- Contact details -->
		  <h5 class="font-weight-bold text-uppercase mb-4">Kontakt</h5>
  
		  <ul class="list-unstyled">
			<li>
			  <p>
				<i class="fas fa-envelope mr-3"></i> mdgallery@gmail.com</p>
			</li>
			<li>
			  <p>
				<i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
			</li>
			<li>
			  <p>
				<i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
			</li>
		  </ul>
  
		</div>
	
  
		<hr class="clearfix w-100 d-md-none">
  
		
		<div class="col-md-2 col-lg-2 text-center mx-auto my-4">
  
		  <!-- Social buttons -->
		  <h5 class="font-weight-bold text-uppercase mb-4">Zapratite:</h5>
  
		  <!-- Facebook -->
		  <a type="button" class="btn-floating btn-fb">
			<a href="#"><img src="img/facebook.png"  alt="facebook" style="width: 50px; height: 50px; border-radius: 25px;"></a>
		  </a><br><br>
		  <!-- Instagram -->
		  <a type="button" class="btn-floating btn-tw">
			<a href="#"><img src="img/instagram.png"  alt="instagram" style="width: 50px; height: 50px; border-radius: 25px;"></a>
		  </a><br><br>
		 
		  
		</div>
	
  
	  </div>

  
	</div>
	<!-- Footer Links -->
  
	<!-- Copyright -->
	<div class="footer-copyright text-center py-3" style="background-image: url('img/first.jpg'); color: #fff;">
		© 2020 Copyright: MDgallery.com
	   
	</div>
	
  
  </footer>
  <!-- Footer -->
</body>

</html>
