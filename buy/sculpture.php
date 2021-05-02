<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Art</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../scss/arts.scss">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' /> 
	</head>
<body>
	<!-- Navbar start -->
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="../index.php">MD Gallery</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="art.php"><i class="fas fa-paint-brush">&nbsp</i>Art</a>
        </li>
		<li class="nav-item">
          <a class="nav-link active" href="draw.php"><i class="fas fa-pencil-alt">&nbsp</i>Drawings</a>
        </li>
		<li class="nav-item">
          <a class="nav-link active" href="sculpture.php"><i class="fas fa-dragon">&nbsp</i>Sculpture</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="checkout.php"><i class="fas fa-money-check-alt mr-2"></i>Checkout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Navbar end -->

  <!-- Displaying Products Start -->
  <div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
  			include 'config.php';
  			$stmt = $conn->prepare('SELECT * FROM sculptures');
  			$stmt->execute();
  			$result = $stmt->get_result();
  			while ($row = $result->fetch_assoc()):
  		?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
            <div class="card-body p-1">
              <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4>
              <h5 class="card-text text-center text-danger"><i class="fas fa-euro-sign"></i>&nbsp<?= number_format($row['product_price'],2) ?></h5>

            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control pqty" value="<?= $row['product_qty'] ?>">
                  </div>
                </div>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                  cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  <!-- Displaying Products End -->

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server
    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
      var pcode = $form.find(".pcode").val();

      var pqty = $form.find(".pqty").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          pid: pid,
          pname: pname,
          pprice: pprice,
          pqty: pqty,
          pimage: pimage,
          pcode: pcode
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>
	
	<footer class="page-footer font-small mdb-color lighten-3 pt-4" >
		<hr>
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
	  
			
			<div class="col-md-2 col-lg-2 text-center mx-auto my-4" id="soc">
	  
			  <!-- Social buttons -->
			  <h5 class="font-weight-bold text-uppercase mb-4">Zapratite:</h5>
	  
			  <!-- Facebook -->
			  <a type="button" class="btn-floating btn-fb" >
				<a href="#"><img src="../img/facebook.png"  alt="facebook" width="50px" height="50px"></a>
			  </a><br><br>
			  <!-- Instagram -->
			  <a type="button" class="btn-floating btn-tw ">
				<a href="#"><img src="../img/instagram.png"  alt="instagram" width="50px" height="50px"></a>
			  </a><br><br>
			 
			  
			</div>
		
	  
		  </div>
	
	  
		</div>
		<!-- Footer Links -->
	  
		<!-- Copyright -->
		<div class="footer-copyright text-center py-3" style="background-image: url('../img/first.jpg'); color: #fff;">
			© 2020 Copyright: MDgallery.com
		   
		</div>
		
	  
	  </footer>

</body>
</html>