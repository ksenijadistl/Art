<?php
	require 'config.php';

	$grand_total = 0;
	$allItems = '';
	$items = [];

	$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  $grand_total += $row['total_price'];
	  $items[] = $row['ItemQty'];
	}
	$allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Checkout</title>
  <link rel="stylesheet" href="../scss/arts.scss">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="../index.php">MD Gallery</a>
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar links -->
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

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 px-4 pb-4" id="order">
        <h4 class="text-center text-info p-2">Complete your order!</h4>
        <div class="jumbotron p-3 mb-2 text-center">
          <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
          <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
          <h5><b>Total Amount Payable : </b><i class="fas fa-euro-sign"></i>&nbsp<?= number_format($grand_total,2) ?></h5>
        </div>
        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
          </div>
          <div class="form-group">
            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
          </div>
          <h6 class="text-center lead">Select Payment Mode</h6>
          <div class="form-group">
            <select name="pmode" class="form-control">
              <option value="" selected disabled>-Select Payment Mode-</option>
              <option value="cod">Cash On Delivery</option>
              <option value="netbanking">Net Banking</option>
              <option value="cards">Debit/Credit Card</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Sending Form data to the server
    $("#placeOrder").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function(response) {
          $("#order").html(response);
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