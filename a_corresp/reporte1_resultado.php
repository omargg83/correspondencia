<?php
  require_once("db_.php");
  $de=explode("-",$_REQUEST['desde']);
  $desde=$de['2']."-".$de['1']."-".$de['0']." 00:00:00";

  $ha=explode("-",$_REQUEST['hasta']);
  $hasta=$ha['2']."-".$ha['1']."-".$ha['0']." 23:59:59";

  echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
 	echo "<br><h5>Analisis</h5>";
 	echo "<hr>";

  $sql="select * from yoficios where ";

 ?>
  <div class="alert alert-light" style='width:100%;height:300px; overflow:auto;'>
   <canvas id="personal" height='200' width='200'>

   </canvas>
  </div>
</div>

 <script type="text/javascript">

   $(document).ready(function(){
     setTimeout(person_grap, 2000);
   });


   function person_grap(){
     var parametros={
       "function":"personal"
     };
     $.ajax({
       url: "escritorio/datos_orga.php",
       method: "GET",
       data: parametros,
       success: function(data) {
         var player = [];
         var score = [];
         var validado = [];
         var datos = JSON.parse(data);
         for (var x = 0; x < datos.length; x++) {
           player.push(datos[x].nombre + " "+ datos[x].total );
           score.push(datos[x].total);
           validado.push(datos[x].validado);
         }
         var chartdata = {
         labels: player,
         datasets : [
           {
           label: 'Número de personal',
           backgroundColor: 'rgba(255, 99, 132, 0.6)',
           borderColor: 'rgba(200, 200, 200, 0.75)',
           hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
           hoverBorderColor: 'rgba(200, 200, 200, 1)',
           data: score
           },
           {
           label: 'Personal validado',
           backgroundColor: 'rgba(139, 185, 221, 1.0)',
           borderColor: 'rgba(200, 200, 200, 0.75)',
           hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
           hoverBorderColor: 'rgba(200, 200, 200, 1)',
           data: validado
           }
         ]
         };
       var ctx = $("#personal");
           var barGraph = new Chart(ctx, {
           type: 'bar',
           data: chartdata,
           options: {
             legend: {
               "display": true
             },
             tooltips: {
               "enabled": true
             }
           }
           });
       },
       error: function(data) {

       }
       });
   };
   </script>
