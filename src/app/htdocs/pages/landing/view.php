<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $fulleName; ?></title>

    

    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <link href="/pages/landing/landing.css" rel="stylesheet">

    
  </head>
  <body>
    
<main>
  <div class="container py-4">


    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
      </a>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#Start" class="nav-link px-2 link-dark">Start</a></li>
        <li><a href="#Bewerbung" class="nav-link px-2 link-dark">Bewerbung</a></li>
        <li><a href="#Lebenslauf" class="nav-link px-2 link-dark">Lebenslauf</a></li>
        <li><a href="#Projekte" class="nav-link px-2 link-dark">Projekte</a></li>
      </ul>

      
      <div class="col-md-3 text-end">
        <!--
        <button type="button" class="btn btn-outline-primary me-2">Logout</button>
            -->
      </div>

    </header>
    
    <a id="Start"></a>
    <div class="row align-items-md-stretch mb-4 p-5 bg-light rounded-3">
      <div class="col-md-3">
        <img src="assets/images/profile.jpg" class="img-fluid" style="margin: 0.5em;">
      </div>

      <div class="col-md-8 p-5" style="padding-top: 2em;">
        <h1 class="display-5 fw-bold"><?php echo $fulleName; ?></h1>
        
        <p class="col-md-8 fs-4"><?php echo $personInfo; ?></p>
        
        <a href="pdf.php" target="pdf" class="btn btn-primary btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
<path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"></path>
<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"></path>
</svg> Bewerbung als PDF Laden </a>
        <br><br>
        <?php echo $kontakt; ?>
      </div>
    </div>
    
    <a id="Bewerbung"></a>
    <div class="row align-items-md-stretch mb-4 ">
      <div class="col-md-8">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2><?php echo $introSalute; ?></h2>
          <p>
          <?php echo $intro; ?>
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="h-100 p-5 text-white bg-secondary rounded-3">
          <h2>Kompetenzen</h2>

          <h3>Soft-Skills</h3>
          <p><?php echo $skillSoft; ?></p>

          <h3>Programmiersprachen</h3>
          <p><?php echo $skillProgramming; ?></p>
          
        </div>
      </div>
    </div>

    <a id="Lebenslauf"></a>
    <div class="row"></div>

    <div class="row align-items-md-stretch mb-4">
      <div class="col-md-8">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2>Lebenslauf</h2>
          <p>
          <?php echo $lebenslauf; ?>
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="h-100 p-5 text-white bg-secondary rounded-3">
          <h2>Software</h2>
          <?php echo $softwareTools; ?>
        </div>
      </div>
    </div>

    <a id="Projekte"></a>
    <div class="row"></div>

    <div class="row align-items-md-stretch mb-2">
      <div class="col-md-12">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2>Projekt - A</h2>
          <p>Project description</p><br>
        </div>
      </div>
    </div>

    <div class="row"></div>

    <div class="row align-items-md-stretch mb-2">
      <div class="col-md-12">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2>Projekt - A</h2>
          <p>Project description</p><br>
        </div>
      </div>
    </div>

    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="h-100 p-5 bg-secondary border rounded-3 text-white ">
          <h2>Kontakt</h2>
          <p><?php echo $kontakt; ?></p>
          
        </div>
      </div>
    </div>

    <footer class="pt-3 mt-4 text-muted border-top">
      &copy; 2022
    </footer>
  </div>
</main>


    
  </body>
</html>
