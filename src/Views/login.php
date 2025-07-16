
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login LP4</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/api-rest-composer-0800/src/Views/assets/img/favicon.png" rel="icon">
  <link href="/api-rest-composer-0800/src/Views/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/api-rest-composer-0800/src/Views/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/api-rest-composer-0800/src/Views/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Ingresa con tu cuenta</h5>
                    <p class="text-center small">Acceso</p>
                  </div>

                  <form class="row g-3 needs-validation" id="form_login" name="form_login" method="get" novalidate>

                    <div class="col-12">
                      <label for="usuario" class="form-label">Usuario</label>
                      <div class="input-group has-validation">
                        <input type="text" name="usuario" class="form-control" id="usuario" required>
                       
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="clave" class="form-label">Contraseña</label>
                      <input type="password" name="clave" class="form-control" id="clave" required>
                      
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Recuerdame!</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

             

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/echarts/echarts.min.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/quill/quill.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="/api-rest-composer-0800/src/Views/assets/vendor/php-email-form/validate.js"></script>
   <script src="/api-rest-composer-0800/src/Views/js/jquery.min.js"></script>
  <!-- Template Main JS File -->
  <script src="/api-rest-composer-0800/src/Views/assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/api-rest-composer-0800/src/Views/js/funciones.js"></script>
  
</body>

</html>