<?php
  if (!empty($_GET['q'])) {
    switch ($_GET['q']) {
      case 'info':
        phpinfo(); 
        exit;
      break;
    }
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laragon</title>

        <link href="https://fonts.googleapis.com/css?family=Karla:400" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Karla';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }

            .opt {
                margin-top: 20px;
            }

            .opt a {
              text-decoration: none;
              font-size: 120%;
            }
            
            a:hover {
              color: red;
            }
            .app-list {
              display: grid;
              grid-template-columns: repeat(3, 1fr);
              grid-template-rows: auto;
              gap: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container">
          <div class="content">
            <div class="title" title="Laragon">Laragon</div>
  
            <div class="info"><br />
                  <?php print($_SERVER['SERVER_SOFTWARE']); ?><br />
                  PHP version: <?php print phpversion(); ?>   <span><a title="phpinfo()" href="/?q=info">info</a></span><br />
                  Document Root: <?php print ($_SERVER['DOCUMENT_ROOT']); ?><br />
            </div>
            
            <div class="app-list">

                <div class="diverse">
                  <div class="opt">
                    <div><a title="Téléversement" href="/laragon">Uploader</a></div>
                  </div>
                    <div class="opt">
                        <div><a title="App d'exemple" href="/example">Example App</a></div>
                    </div>
                </div>

                <div class="bdd">
                  <div class="opt">
                    <div><a title="Adminer" href="/adminer">adminer</a></div>
                  </div>
                  <div class="opt">
                    <div><a title="PhpMyAdmin" href="/phpmyadmin">PhpMyAdmin</a></div>
                  </div>
                </div>

                <div class="cache">
                  <div class="opt">
                    <div><a title="Redis" href="/redis">Redis</a></div>
                  </div>
                  <div class="opt">
                    <div><a title="Memcached" href="/memcached">memcached</a></div>
                  </div>
                </div>

            </div>
          </div>
        </div>
    </body>
</html>