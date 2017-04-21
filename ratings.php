<html>
<head>
  <link rel="stylesheet" type="text/css" href="rating_style.css">
  <script type="text/javascript">
   function change(id)
   {
      var cname=document.getElementById(id).className;
      var ab=document.getElementById(id+"_hidden").value;
      document.getElementById(cname+"rating").innerHTML=ab;

      for(var i=ab;i>=1;i--)
      {
         document.getElementById(cname+i).src="images/star2.png";
      }
      var id=parseInt(ab)+1;
      for(var j=id;j<=5;j++)
      {
         document.getElementById(cname+j).src="images/star1.png";
      }
   }
</script>
  
</head>

<body>

<form method="post" action="insert_rating.php">
  <p id="total_votes">Total Votes:<?php echo $total;?></p>
  <div class="div">
	  <p>Your review..</p>
	  <input type="hidden" id="star1_hidden" value="1">
	  <img src="images/star1.png" onmouseover="change(this.id);" id="star1" class="star">
	  <input type="hidden" id="star2_hidden" value="2">
	  <img src="images/star1.png" onmouseover="change(this.id);" id="star2" class="star">
	  <input type="hidden" id="star3_hidden" value="3">
	  <img src="images/star1.png" onmouseover="change(this.id);" id="star3" class="star">
	  <input type="hidden" id="star4_hidden" value="4">
	  <img src="images/star1.png" onmouseover="change(this.id);" id="star4" class="star">
	  <input type="hidden" id="star5_hidden" value="5">
	  <img src="images/star1.png" onmouseover="change(this.id);" id="star5" class="star">
  </div>

  <input type="hidden" name="starrating" id="starrating" value="0">
  <input type="submit" value="Submit" name="submit_rating">

</form> 

</body>
</html>