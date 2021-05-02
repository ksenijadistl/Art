<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cart</title>
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
      <div class="col-lg-10">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
  echo $_SESSION['showAlert'];
} else {
  echo 'none';
} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
} unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                require 'config.php';
                $stmt = $conn->prepare('SELECT * FROM cart');
                $stmt->execute();
                $result = $stmt->get_result();
                $grand_total = 0;
                while ($row = $result->fetch_assoc()):
              ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                <td><?= $row['product_name'] ?></td>
                <td>
                <i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <td>
                  <input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;">
                </td>
                <td><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['total_price'],2); ?></td>
                <td>
                  <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php $grand_total += $row['total_price']; ?>
              <?php endwhile; ?>
              <tr>
                <td colspan="3">
                  <a href="art.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                    Shopping</a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($grand_total,2); ?></b></td>
                <td>
                  <a href="checkout.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Change the item quantity
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
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
