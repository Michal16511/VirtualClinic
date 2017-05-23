<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
         <div id="results"></div>
         </br>
         </br>
         </br>
         <div id="catalan"></div>
        <script language="javascript">
            function prawdopodobienstwo(ilosc)
            {
                var licznikPiatek =0;

                var licznikRoznych =0;

                for(var i=0; i<ilosc;i++)
                {
                    var kostka1 = Math.floor((Math.random() * 6) + 1);
                    var kostka2 = Math.floor((Math.random() * 6) + 1);
                    var kostka3 = Math.floor((Math.random() * 6) + 1);

                    if( kostka1 != kostka2 && kostka1 != kostka3 && kostka2 != kostka3)
                    {

                        if(kostka1 != 5 && kostka2 != 5 && kostka3 != 5)
                        {
                            licznikPiatek++;
                        }
                        licznikRoznych++;
                    }
                }
               var prawdopodobienstwo = licznikPiatek/licznikRoznych;
               
               return prawdopodobienstwo;
            }
            document.getElementById("results").innerHTML = prawdopodobienstwo(1000);
            
            
          </script>
        
    </body>
</html>
