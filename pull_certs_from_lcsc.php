<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        #results { display: none; }
    </style>
</head>
<body>

    <div id="results">
        <?php
            require('simple_html_dom.php');
            $html = file_get_html( "http://www.lcsc.edu/degrees" );
            echo ( $html );
        ?>
    </div>
    <div id="table"></div>
    

    <script>
        $(function(){

            // Create Text file
            function download(text, name, type) {
                var a = document.createElement("a");
                var file = new Blob([text], {type: type});
                a.href = URL.createObjectURL(file);
                a.download = name;
                a.click();
            }

            let degreeTable = $('#results #degreeTable').html();
            $('#table').html( degreeTable );

            var certs = [];
            let cert = [];
            let certObj = {};

            let data = $('#table tr[data-degree-type="Certificates"]').each(function(){
                $(this).children().each(function(){
                    cert.push( $(this).text().trim() );
                    //console.log("The child: " + $(this).text() );
                });
                certObj = {
                    name: cert[0],
                    type: cert[1],
                    division: cert[2]
                }

                certs.push(certObj);
                cert = [];
                certObj = {};
            });

            console.log(certs);
            var certs = JSON.stringify(certs);

            download(certs, 'certs.json', 'application/json');

        });
    </script>
</body>
</html>