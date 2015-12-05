<!doctype html>
<html>
<? require('header.php'); ?>

<body>
    <link rel="stylesheet" href="jquery-ui.css">
    <script>
     $(function() {
         $( "#draggable" ).draggable();
         $( "#droppable" ).droppable({
             
             drop: function( event, ui ) {
                 $( this ).addClass( "ui-state-highlight" )
                          .find( "p" )
                          .html( "Firefighter added!" );
             }
             /* out: function( event, ui ) {
                $(this).find("p")
                .html("Empty");
                } */
         });
         /*          $( "#droppable" ).on( "dropout", function( event, ui ) {} ); */
     });
    </script>
    
    <div id="draggable" class="ui-widget-content">
      <p>I'm a fireman.</p>
    </div>
    
    <div id="droppable" class="ui-widget-header">
      <p>I'm a firetruck.</p>
    </div>
    
  </body>
  <? require('footer.php'); ?>
</html>
