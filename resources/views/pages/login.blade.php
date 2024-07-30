<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="152x76" href="../assets/img/logo_ice_tea.png">
    <link rel="icon" type="image/png" href="../assets/img/logo_ice_tea.png">
    <title>
      Infusion de l'Île
    </title>

    <!--     Fonts and icons     -->
    <link href="../assets/css/fonts.css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  </head>

<body class="">
  
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-4">

                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-primary text-gradient">Bienvenue</h3>
                  @if(session()->has('erreur'))
                      <div class="alert alert-danger">{{ session('erreur') }}</div>
                  @endif
                </div>

                <div class="card-body">
                  <form action="{{ route('authentification') }}" method="post">
                    @csrf

                    <label>Email</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">                      
                    </div>
                    @error('email')
                          <div class="alert alert-light">{{ $message }}</div>
                    @enderror

                    <label>Mot de passe</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Mot de passe" name="mdp" value="{{ old('mdp') }}">                      
                    </div>
                    @error('mdp')
                          <div class="alert alert-light">{{ $message }}</div>
                    @enderror
                    
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Se connecter </button>
                    </div>

                  </form>
                </div>
                
              </div>
            </div>

            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n5">
                <div class=" bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </main>

</body>

</html>