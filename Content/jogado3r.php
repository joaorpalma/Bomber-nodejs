<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script src="/socket.io/socket.io.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, user-scalable=no, minimal-ui,initial-scale = 1,maximum-scale = 1">
</head>

<body>

  <div class="control" id="controlo">
      <a class="bt bt_top" id="bttop"><</a>
      <a class="bt bt_right"  id="btright">></a>
      <a class="bt bt_bottom"  id="btbottom">></a>
      <a class="bt bt_left"  id="btleft"><</a>
      <a class="bt bt_bomba" id="btbomba"></a>
  </div>

  <div id="NovoJogador"> 
     <form  method="get">
     <input placeholder="Nome" class="Nnome" id="Nome" />
     <input type="button" class="Nenviar" value="Enviar" id="b_enviar" />
     </form>
   </div>

<div id="texto">Por favor, Espere...</div>

<script>

    $('body').css('background-color','black');

    var elm = document.getElementById('btbomba');
    var elm_1 = document.getElementById('bttop');
    var elm_2 = document.getElementById('btbottom');
    var elm_3 = document.getElementById('btright');
    var elm_4 = document.getElementById('btleft');

    var catcher = function(evt) {
        if (evt.touches.length < 2)
            evt.preventDefault();
    };

    elm.addEventListener('touchstart', catcher, true);
    elm_1.addEventListener('touchstart', catcher, true);
    elm_2.addEventListener('touchstart', catcher, true);
    elm_3.addEventListener('touchstart', catcher, true);
    elm_4.addEventListener('touchstart', catcher, true);

    var socket = io.connect();
    var show = 0;

   var ratio = window.devicePixelRatio || 1;
    var w = screen.width;// * ratio;
    var h = screen.height;// * ratio;

socket.on('Dead',function(msg){
      document.getElementById('controlo').style.display='none';
      document.getElementById('texto').style.display='block';
});

socket.on('Inicio',function(msg){
      document.getElementById('texto').style.display='none';
      document.getElementById('NovoJogador').style.display='none';
      document.getElementById('controlo').style.display='block';
      switch(msg) {
        case J1:
          $('body').css('background-color','blue');
        break;
        case J2:
          $('body').css('background-color','red');
        break;
        case J3:
          $('body').css('background-color','green');
        break;
        case J4:
          $('body').css('background-color','yellow');
        break;
        default:
          $('body').css('background-color','black');
        break;
      }
});

$(document).ready(function(button){
    msgnome = <?php echo $_GET['nome']?>;
    envianome();
});


$("#b_enviar").click(function(){
    document.getElementById('NovoJogador').style.display='none';
    document.getElementById('controlo').style.display='block';
    show = 1;

    var el = document.documentElement, rfs = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen;
    rfs.call(el);
});

if(show == 0 )
{
  document.getElementById('controlo').style.display='none';
  document.getElementById('texto').style.display='none';
}


function envianome()
{
  socket.emit("Nome",msgnome);
}
    $(document).ready(function(button){

      $('.bt_left').click(function(){
        msgmovimento = "Esquerda";
        envia();
    	});

      $('.bt_right').click(function(){
        msgmovimento = "Direita";
        envia();
    	});

      $('.bt_top').click(function(){
        msgmovimento = "Cima";
        envia();
    	});

      $('.bt_bottom').click(function(){
        msgmovimento = "Baixo";
          envia();
      });

      $('.bt_bomba').click(function(){
        msgmovimento = "BOMBA!!";
        envia();
      });
    });

    function envia()
    {
      socket.emit("Movimento",msgmovimento);
    }

  </script>

</body>
</html>
