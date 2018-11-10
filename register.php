<?php
        include 'sessionHandling.php';
        include './dbConnenctor.php';
        include './TemplateView.php';
        $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->isCorrectPape("abwart");
        
        $dbc = dbConnector::Instance();
        $dbc->connect();
        $_SESSION['dbconnection'] = $dbc;
            
?>
<html>
    <head>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script type='text/javascript'>
            $(document).ready(function(){
               $('.delete').click(function() {
               var data = $(this).parent().parent().attr('id');
                $.ajax({
                 type: "POST",
                 url: "delete.php",
                 data: { action: data }
               }).done(function() {
                 window.location.reload();   
                 
               });    

            });
                   
          $('.update').click(function() {
               data = $(this).parent().parent().attr('id');
                var thisform = $(this);
                $.ajax({
                 type: "POST",
                 url: "update.php",
                 data: { action: data },               
                success: function(msg) { 
                        thisform.parent().append(msg);
                   
                        }
             
                });
            });
   
   
          $('.rechnung').click(function() {
              data = $(this).parent().parent().attr('id');
              window.open("rechnung.php?id="+ encodeURIComponent(data));
           //   window.location = "http://localhost/first.php?q=" + encodeURIComponent(checkB) + "&p=" + encodeURIComponent(tableName);
              /*
               data = $(this).parent().parent().attr('id');
                var thisform = $(this);
                $.ajax({
                 type: "POST",
                 url: "rechnung.php",
                 data: { action: data },               
                success: function(msg) { 
                        thisform.parent().append(msg);
                   
                        }
             
                });
                */
            });

                
                
            });
        </script>
    </head>
    <body>
   
    <form method="post" action="register.php">
        Name:<input name="nname" type="text" required/><br/>
        Password:<input name="password" type="password" required=""/><br/>
        Benutzername:
          <input type="radio" name="benutzertyp" value="mieter" checked> Mieter
          <input type="radio" name="benutzertyp" value="abwart"> Abwart<br/>
          <input name="submit" type="submit"><input type="reset"><br/>
    </form>
        <table>
            
                <?php 
                    $ergebnis = $_SESSION['dbconnection']->selectUsersColumnNames();
                    echo '<tr>';
                       while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                        echo '<th>'.  TemplateView::noHTML($zeile[0]).'</th>';
                     }
                    echo '</tr>';
                     $ergebnis = $_SESSION['dbconnection']->selectUsers();
                
                     while($zeile = $_SESSION['dbconnection']->iterateResult($ergebnis))
                     {        
                     
                      echo '<tr id="'.$zeile[0].'"><td>'. TemplateView::noHTML($zeile[0]).'</td><td>'.TemplateView::noHTML($zeile[1]) .'</td><td>'.TemplateView::noHTML($zeile[2]) .'</td><td>'.TemplateView::noHTML($zeile[3]) .'</td><td><button  class="delete">delete</button></td><td><button class="update">update</button></td><td><button class="rechnung">Eechnung einsehen</button></td></tr>';
                     
                     }
                ?>
         
        </table>
        
        <?php
      
        function register()
        {
 
            $name = $_POST["nname"];
            $password = $_POST["password"];
            $benutzertyp = $_POST["benutzertyp"];
            $_SESSION['dbconnection']->insert($name, $password, $benutzertyp);
            if(isset($_POST['submit']))
            {
               echo "hello ".$_POST["benutzertyp"];
            } 
        }
        
        if(isset($_POST['submit']))
        {
           register();
        } 
        ?>
        

    </body>
</html>

