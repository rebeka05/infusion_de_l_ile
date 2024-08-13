<aside class="sidenav navbar navbar-vertical navbar-expand-xs bg-white border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('accueil') }}">
        <img src="../assets/img/logo_ice_tea.png" class="navbar-brand-img h-200" alt="main_logo" width="100">
        <span class="ms-1 font-weight-bold">Infusion de l'île</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0">

    <!-- <div class="sidenav-footer mx-3 ">
      <a class="btn bg-gradient-primary mt-3 w-100" href="">vente</a>
    </div> -->    
    
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
          <a href="javascript:;" class="nav-link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-secret text-primary text-center"></i></span>
            <span class="nav-link-text ms-1 font-weight-bold text-uppercase">administrateur</span>
          </a>
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link  " href="{{ route('etatLivraison') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="text-s fas fa-clipboard-list text-primary text-center"></i></span>
            </div>
            <span class="nav-link-text ms-1 text-uppercase font-weight-bold">état de livraison</span>
          </a>
        </li>

        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" onclick="toggleSubMenu('submenuVente')">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="text-s fas fa-store text-primary text-center"></i>
              </div>
              <span class="nav-link-text ms-1 text-uppercase font-weight-bold">Vente</span>
            </a>
            
            <!-- Sous-menu -->
            <ul id="submenuVente" class="submenu">
              <li class="nav-item">
                <a href="{{ route('venteValide') }}" class="nav-link">
                  <i class="fas fa-check text-primary text-center"></i>
                  <span class="nav-link-text ms-1 text-uppercase font-weight-bold">Vente validé</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('etatVente') }}" class="nav-link">
                  <i class="fas fa-chart-line text-primary text-center"></i>
                  <span class="nav-link-text ms-1 text-uppercase font-weight-bold">état de vente</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('etatVentePaye') }}" class="nav-link">
                  <i class="fas fa-money-check text-primary text-center"></i>
                  <span class="nav-link-text ms-1 text-uppercase font-weight-bold">état de vente payé</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>

        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" onclick="toggleSubMenu('submenuPaiement')">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="text-s fas fa-money-bills text-primary text-center"></i>
              </div>
              <span class="nav-link-text ms-1 text-uppercase font-weight-bold">paiement</span>
            </a>
            
            <!-- Sous-menu -->
            <ul id="submenuPaiement" class="submenu">
              <li class="nav-item">
                <a href="{{ route('listePaiement') }}" class="nav-link">
                  <i class="fas fa-list text-primary text-center"></i>
                  <span class="nav-link-text ms-1 text-uppercase font-weight-bold">liste paiement</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('venteNonPaye') }}" class="nav-link">
                  <i class="fas fa-money-bill-alt text-primary text-center"></i>
                  <span class="nav-link-text ms-1 text-uppercase font-weight-bold">état non payé</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('etatCheque') }}" class="nav-link">
                  <i class="fas fa-university text-primary text-center"></i>
                  <span class="nav-link-text ms-1 text-uppercase font-weight-bold">état des chèques</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>

        <script>
          function toggleSubMenu(id) {
            var submenu = document.getElementById(id);
            submenu.classList.toggle('show');
          }
        </script>

        <li class="nav-item">
          <a class="nav-link  " href="{{ route('venteProduitClient') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="text-s fas fa-shopping-cart text-primary text-center"></i></span>
            </div>
            <span class="nav-link-text ms-1 text-uppercase font-weight-bold">produit par client</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link  " href="{{ route('totalProduit') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="text-s fas fa-users text-primary text-center"></i></span>
            </div>
            <span class="nav-link-text ms-1 text-uppercase font-weight-bold">Total produit</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link  " href="{{ route('etatechange') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="text-s fas fa-table text-primary text-center"></i></span>
            </div>
            <span class="nav-link-text ms-1 text-uppercase font-weight-bold">état d'échange</span>
          </a>
        </li>

      </ul>
    </div>

</aside>


  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl ita" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $nomPage }}</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">{{ $nomPage }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            
            <li class="nav-item d-flex align-items-center">
              <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="https://www.creative-tim.com/builder?ref=navbar-soft-ui-dashboard">Online Builder</a>
            </li>            

            <li class="nav-item px-4 dropdown d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0 ">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0 ">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0 ">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item d-xl-none ps-3 pe-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>

            <li class="nav-item d-flex align-items-center">
              <a href="{{ route('deconnexion') }}" class="nav-link text-body font-weight-bold px-0">
                <i class="fas fa-sign-out-alt me-sm-1"></i>
                <!-- <span class="d-sm-inline d-none">Se déconnecter</span> -->
              </a>
            </li>
            
          </ul>
        </div>
      </div>
    </nav>

    

    <aside class="sidenav navbar navbar-vertical navbar-expand-xs bg-white border-0 border-radius-xl my-3 mt-7" style="margin-left: 72%;">
        
      <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">

          <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-check-circle text-primary text-center"></i></span>
              <span class="nav-link-text ms-1 font-weight-bold text-uppercase">validation</span>
            </a>
            <ul> <!-- class="dropdown-menu" aria-labelledby="dropdownMenuButton" -->
              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('validationVente') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-store text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">Vente</span>
                </a>
              </li>
              
              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('validationEchange') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-exchange text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">échange</span>
                </a>
              </li>
              
              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('listFactureImpaye') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-money-bills text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">Paiement</span>
                </a>
              </li>
              
              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('listCheque') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-university text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">Chèque</span>
                </a>
              </li>

            </ul>
          </li>

        </ul>
        
        
        
        <ul class="navbar-nav">

          <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-file-edit text-primary text-center"></i></span>
              <span class="nav-link-text ms-1 font-weight-bold text-uppercase">saisie</span>
            </a>
            <ul> <!-- class="dropdown-menu" aria-labelledby="dropdownMenuButton" -->

              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('saisie') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-edit text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">saisie</span>
                </a>
              </li>

              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('saisieLivraison') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-truck text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">livraison</span>
                </a>
              </li>

              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('pageVente') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-store text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">vente</span>
                </a>
              </li>
              
              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('pageEchange') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-exchange text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">échange</span>
                </a>
              </li>
              
              <li class="nav-item dropdown-item">
                <a class="nav-link" href="{{ route('pageDegustation') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">                  
                    <i class="fas fa-glass-whiskey text-primary text-center"></i></span>
                  </div>
                  <span class="nav-link-text ms-1 text-uppercase">dégustation</span>
                </a>
              </li>

            </ul>
          </li>

        </ul>
      </div>

    </aside>
    <!-- End Navbar -->