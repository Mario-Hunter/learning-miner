<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Learning Miner</title>

  <!-- Bootstrap core CSS -->
  <link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css"></link>

  <!-- Custom styles for this template -->
  <link href="/css/miner.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href=" /css/ratings.css">
  <script type="text/javascript">
   function change(id)
   {
    var course_id = id.substring(5);
    var cname=document.getElementById(""+id).className;
    var ab=document.getElementById(""+id+"_hidden").value;
    document.getElementById("rating"+course_id).value=ab;

    for(var i=ab;i>=1;i--)
    {
     document.getElementById(""+cname+i+course_id).src="/images/star2.png";
   }
   var id=parseInt(ab)+1;
   for(var j=id;j<=5;j++)
   {
     document.getElementById(""+cname+j+course_id).src="/images/star1.png";
   }
 }
</script>

</head>

<body>

  @include('layouts.nav')

  <div class="container" style="height:500px;">
    @yield('content')
  </div>
  @include('layouts.errors')
  @include('layouts.jquery')

</body>
</html>
