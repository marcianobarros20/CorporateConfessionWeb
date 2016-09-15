<!DOCTYPE html>
<html>
<head>
	<title>Stripe Test</title>
</head>
<body>
<h1>Hello</h1>

		<form action="ConfessionWeb/stripeToken" method="POST">
		  <script
		    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		    data-key="pk_test_cxAD4WvYEGk1EojeTyyy0roa"
		    data-amount="999"
		    data-name="Demo Site"
		    data-description="Widget"
		    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		    data-locale="auto">
		  </script>
		</form>


</body>
</html>