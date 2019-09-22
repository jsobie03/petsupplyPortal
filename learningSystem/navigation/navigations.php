<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo $title;?> | Pet Supply Orange County</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen">  
<!-- <link href="<?php echo web_root; ?>css/kcctc.css" rel="stylesheet" media="screen">  -->
<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">  
<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>loginregister.css">  
<link rel="stylesheet" href="<?php echo web_root; ?>assets/iCheck/flat/blue.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>css/jquery-ui.css">  
 <style type="text/css"> 
 
#content {
  min-height: 550px;
  margin: 0;
  width: 100%;
}
#footer > div {
 background-color: #FFCC00; 
  min-height: 200px;
  padding: 10px 50px;
  margin-top: 30px;
  border-top: 2px solid #000;

}
.footer-links { 
  /*margin-left: 5px;*/
}
#footer > footer { 
background-color: #FFCC00; 
  min-height: 100px;
  padding: 10px; 
  border-top: 2px solid #000;
  color:#000;

}
.navbar-nav {
  float: right;
}
@media only screen and (max-width: 768px){
 .navbar-nav {
  float: none;
 }

}
#content { 
  margin-right: 0px;
  margin-left: 90px;
  width:90%;
}

#content:before,
#content:after {
  display: table;
  content: "";
}

#content:after {
  clear: both;
}

#content:before,
#content:after {
  display: table;
  content: "";
}

#content:after {
clear: both;
}

#mySidenav a {
    position: absolute;
    left: -130px;
    transition: 0.3s;
    padding: 20px;
    width: 190px;
    text-decoration: none;
    font-size: 25px;
    color: black;
	border:2px solid #000;
    border-radius: 0 5px 5px 0;
}

#mySidenav a:hover {
    left: 0;
}

#lesson {
    top: 180px;
   background-color: #FFCC00; 
}

#exercise {
    top:260px;
    background-color: #FFCC00; 
}

#download {
    top: 340px;
    background-color: #FFCC00; 
}

#about {
    top: 420px;
    background-color: #FFCC00; 
}
#login {
    top: 500px;
    background-color: #FFCC00; 
}

#title-header {
  background-color: #FFCC00; 
  border-bottom: 2px solid #000; 
  height: 170px;  
  padding: 10px 0px;
  text-align: center;
  color: #000;
  font-size: 18px;
}
 

 </style>
 

<body >
<section id="title-header">
<img class="logo" src="../images/logo.png" style="width:200px; height:auto;"/>
  <div class="title">  
     
     <p>Pet Supply O.C. <br>Orange County, CA Locations</p>
      <p class="subtitle">Online Job Training for New Associates</p> 
  </div>
</section>  
<section id="navigation">
  <div id="mySidenav" class="sidenav">
    <a href="<?php echo web_root; ?>index.php?q=lesson" id="lesson">Lesson <i class="fa fa-home"></i></a> 
    <a href="<?php echo web_root; ?>index.php?q=exercises" id="exercise">Exercises</a>
    <a href="<?php echo web_root; ?>index.php?q=download" id="download">Download</a>
    <a href="<?php echo web_root; ?>index.php?q=about" id="about">About Us</a>  
     <a href="logout.php" id="login">Logout</a> 
  </div>
</section>  

<section id="content"> 
<?php check_message(); ?> 
  <div class="container"> 
    <?php require_once $content; ?> 
  </div>  
</section>

<section id="footer"> 
<!--      <div > 

</div>   -->
<footer  >
    <p align="left">&copy; Pet Supply O.C.</p>
</footer>
</section>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>jquery/jquery.min.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.dataTables.js"></script> 
  <script src="<?php echo web_root;?>assets/iCheck/icheck.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script type="text/javascript" src="<?php echo web_root; ?>js/jquery-ui.js"></script> 
  <script type="text/javascript" src="<?php echo web_root; ?>js/autofunc.js"></script> 
  <script src="<?php echo web_root;?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Page Script -->
<script>
 
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
    var t = $('#example').DataTable( {
      "bSort": false,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],

          //vertical scroll
         // "scrollY":        "300px",
        "scrollCollapse": true,

        //ordering start at column 1
        "order": [[ 1, 'desc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
$(document).ready(function() {
    var t = $('#example2').DataTable( {
      "bSort": false,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],

          //vertical scroll
         // "scrollY":        "300px",
        "scrollCollapse": true,

        //ordering start at column 1
        "order": [[ 1, 'desc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );

</script>  

<script type="text/javascript"> 

$('#date_picker').datetimepicker({
  format: 'mm/dd/yyyy',
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
});

  
</script>
<script>
  function checkall(selector)
  {
    if(document.getElementById('chkall').checked==true)
    {
      var chkelement=document.getElementsByName(selector);
      for(var i=0;i<chkelement.length;i++)
      {
        chkelement.item(i).checked=true;
      }
    }
    else
    {
      var chkelement=document.getElementsByName(selector);
      for(var i=0;i<chkelement.length;i++)
      {
        chkelement.item(i).checked=false;
      }
    }
  }
   function checkNumber(textBox){
        while (textBox.value.length > 0 && isNaN(textBox.value)) {
          textBox.value = textBox.value.substring(0, textBox.value.length - 1)
        }
        textBox.value = trim(textBox.value);
      }
      //
      function checkText(textBox)
      {
        var alphaExp = /^[a-zA-Z]+$/;
        while (textBox.value.length > 0 && !textBox.value.match(alphaExp)) {
          textBox.value = textBox.value.substring(0, textBox.value.length - 1)
        }
        textBox.value = trim(textBox.value);
      }
 

  $(document).on("change",".radios",function(){

    var exerciseid = $(this).data('id');
    var value = $(this).val();

       // alert(value);
       if ($(this).is(':checked'))
        {
            $.ajax({
            type : "POST",
            url : "validation.php",
            dataType: "text",
            data: {ExerciseID:exerciseid,Value:value},
            success : function(data){
              // alert(data)
            }
           });
        }
  

  });

//    $(function(){
//   $('input[type="radio"]').change(function(){
//     if ($(this).is(':checked'))
//     {
//       alert($(this).val());
//       $(this).disabled=true;
//     }
//   });
// });
  </script>     

</body>
</html>