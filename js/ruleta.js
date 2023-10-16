$(document).ready(function(){
    var tamanyoRuleta = 360;
    var numeroCasillas = 8;
    var anguloCasillas = 360 / numeroCasillas;
    var grados = (180 - anguloCasillas) / 2;
    var alturaCasilla = Math.tan(grados * Math.PI / 180) * (tamanyoRuleta / 2);
    
    $(".ruleta").css({
      'width' : tamanyoRuleta + 'px',
      'height' : tamanyoRuleta + 'px'
    })
  
    $('head').append('<style id="afterNumero"></style>');
    
    for(var i=1; i<=numeroCasillas; i++){
      
      $(".ruleta").append('<div class="opcion opcion-'+ i +'"></div>');
      var clasS = '.opcion-' + i;
      
      $(clasS).css({
        'transform' : 'rotate(' + anguloCasillas * i + 'deg)',
        'border-bottom-color' : getRandomColor()
      });
      
      $('#afterNumero').append('.opcion-'+ i +'::before {content: "'+ i +'"}');
      
      $(".opcion")
        .attr('data-content', i)
        .attr('data-ancho', (tamanyoRuleta / 2) + 'px')
        .attr('data-line', (tamanyoRuleta / 2) + 'px');
    }
    
  
    $(".opcion").css({
      'border-bottom-width' : alturaCasilla + 'px',
      'border-right-width' : (tamanyoRuleta / 2) + 'px',
      'border-left-width' : (tamanyoRuleta / 2) + 'px'
    })
    
    function getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    
    $('.ruleta').before().click(function(){
      var num;
      var numID = 'number-';
      num = 1 + Math.round(Math.random() * (numeroCasillas - 1));
      numID += num;
      
      $('#animacionRuleta').remove();
      $('head').append('<style id="animacionRuleta">'+
          '#number-'+ num +' { animation-name: number-'+ num +'; } '+
        '@keyframes number-'+ num +' {'+
          'from { transform: rotate(0); } '+
          'to { transform: rotate('+ (360 * (numeroCasillas - 1) - anguloCasillas * num) +'deg); }'+
        '}'+
        '</style>'
      );
      
      $('.ruleta').removeAttr('id').attr('id', numID);
    });
    
  });