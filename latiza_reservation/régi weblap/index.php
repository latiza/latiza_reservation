<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Latiza Kft bemutatkozó weblapja">
  <meta name="keywords"
    content="Idegenvezetés, Idegenvezető, Csoportkísérő, tourguide, tourleader, system administrator, rendszergazda, IT, weblapkészítés">
  <meta name="author" content="Ruzsinszki Zita">
  <!--CSS-ek-->
  <link rel="stylesheet" href="css/swiper.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
  <Title>Latiza Kft.</Title>

</head>

<body>
  <!--navigáció-->
  <?php include 'menu.html'; ?>

  <!-- SZOLGÁLTATÁSOK – modern grid + mobil scroll-snap -->
  <section class="hero" style="background-image:url('img/hero-bg.jpg')">
    <div class="hero-content fade-in">
      <h1>Üdvözli a Latiza Kft.</h1>
      <p>Idegenvezetés és informatikai szolgáltatások </p>
      <a href="#services" class="btn btn-primary">Fedezze fel szolgáltatásainkat</a>
    </div>
  </section>

  <section id="services" class="services-grid container">
    <article class="service-card fade-in">
      <img class="img-fluid"  src="img/zita.jpg" alt="Idegenvezetés – Latiza Kft.">
      <div class="content">
        <h3>Idegenvezetés</h3>
        <p>Városnézések és tematikus túrák – teljes útvonal- és logisztikai szervezéssel, hiteles narrációval.</p>
        <a href="guide.php" class="btn btn-primary">Bővebben</a>
      </div>
    </article>

    <article class="service-card fade-in">
      <img class="img-fluid"  src="img/tamas.jpg" alt="IT szolgáltatások – Latiza Kft.">
      <div class="content">
        <h3>IT szolgáltatások</h3>
        <p>Rendszergazda, felhő, mentés és monitoring – stabil üzemeltetés, gyors támogatás, mérhető SLA.</p>
        <a href="it.php" class="btn btn-primary">Bővebben</a>
      </div>
    </article>
  </section>



  <footer class="site-footer" role="contentinfo">
    <div class="container">
      <div class="row gy-4 align-items-start">
        <div class="col-md-5">
          <a class="footer-brand d-inline-block mb-2" href="index.php">Latiza Kft.</a>
          <ul class="list-unstyled footer-contact mb-0">
            <li><span class="lbl">Kapcsolat:</span> Ruzsinszki Zita</li>
            <li><a href="mailto:latizakft@gmail.com">latizakft@gmail.com</a></li>
            <li><a href="tel:+36304778772">+36 30 477 8772</a></li>
          </ul>
        </div>

        <div class="col-md-4">
          <nav aria-label="Gyorslinkek">
            <h6 class="footer-head">Oldalak</h6>
            <ul class="list-unstyled footer-links mb-0">
              <li><a href="guide.html">Idegenvezetés</a></li>
              <li><a href="itszolg.html">IT szolgáltatások</a></li>
            </ul>
          </nav>
        </div>

      </div>

      <hr class="footer-sep">

      <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-2 small">
        <p class="mb-0 opacity-75">© <span id="year"></span> Latiza Kft. Minden jog fenntartva.</p>
        <div class="d-flex gap-3">
          <a class="opacity-90" href="#" aria-label="Impresszum">Impresszum</a>
          <a class="opacity-90" href="#" aria-label="Adatkezelés">Adatkezelés</a>
          <a class="to-top opacity-90" href="#top" aria-label="Vissza a tetejére">↑ Vissza a tetejére</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // évszám automatikusan
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>

  <!--Javascriptek-->
  <script src="javascript/jquery-1.11.2.min.js"></script>
  <script src="javascript/jquery.magnific-popup.js"></script>
  <script src="javascript/swiper.min.js"></script>
  <script src="javascript/plugins.js"></script>
  <script src="javascript/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-2h8X..."
    crossorigin="anonymous"></script>
  <script src="javascript/accordion.js"></script>
</body>

</html>