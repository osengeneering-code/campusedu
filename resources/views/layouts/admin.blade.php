
<!doctype html>


  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="{{ asset('Pro/assets/ ') }} "
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8"/>
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name', 'APP | AUTOGEST') }} | @yield('titre', 'RIEN') </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Pro/logo/TRY.png') }}" height="200px"  whidt="200px" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
       <!-- Page CSS -->
    
    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/css/pages/app-chat.css') }} " />

    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/css/core.css') }} "/>
    <link rel="stylesheet" href="{{ asset('Pro/assets/css/demo.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Pro/assets/css/demo.css') }}" />

    <!-- Page CSS -->
    
  <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/css/pages/app-calendar.css') }}" />


    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/css/pages/page-icons.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('Pro/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('Pro/assets/js/config.js') }}"></script>

    @yield('header')
  </head>


  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 60px;">
                  <img src="{{ asset('Pro/logo/1.png') }}" alt="Logo" style="max-height: 225px; width: auto; margin-left: -17px;">
              </div>
              <!-- <span class="app-brand-text demo menu-text fw-bold ms-2">Sneat</span> -->
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
            </a>
          </div>

          <div class="menu-divider mt-0"></div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            
            @auth
            <!-- Tableau de Bord -->
            <li class="menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
              <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Tableau de bord</div>
              </a>
            </li>

            <!-- Messagerie -->
            <li class="menu-item {{ Request::routeIs('conversations.*') ? 'active' : '' }}">
              <a href="{{ route('conversations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-message-square-dots"></i>
                <div data-i18n="Messagerie">Messagerie</div>
              </a>
            </li>

            <!-- Portail Étudiant -->
            @role('etudiant')
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Mon Espace</span></li>
            <li class="menu-item">
              <a href="{{-- route('portail.etudiant') --}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Mon Portail">Mon Portail</div>
              </a>
            </li>
            
            @endrole
            
            <!-- Portail Enseignant -->
            @role('enseignant')
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Mon espace Enseignant</span></li>

            @can('consulter_son_emploi_du_temps')
            <li class="menu-item {{ Request::routeIs('gestion-cours.emplois-du-temps') ? 'active' : '' }}">
                <a href="{{ route('gestion-cours.emplois-du-temps') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Mon Emploi du temps">Mon Emploi du temps</div>
                </a>
            </li>
            @endcan

            <li class="menu-item {{ Request::routeIs('portail.enseignant.mes-modules') ? 'active' : '' }}">
                <a href="{{ route('portail.enseignant.mes-modules') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Mes Modules">Mes Modules</div>
                </a>
            </li>

            @can('saisir_notes')
            <li class="menu-item {{ Request::routeIs('gestion-cours.evaluations.index') ? 'active' : '' }}">
                <a href="{{ route('gestion-cours.evaluations.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-pen"></i>
                    <div data-i18n="Saisie des Notes">Saisie des Notes</div>
                </a>
            </li>
            @endcan

            @can('suivre_stages_tuteur')
            <li class="menu-item {{ Request::routeIs('stages.stages.index') ? 'active' : '' }}">
                <a href="{{ route('stages.stages.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="Mes Stages Tutorés">Mes Stages Tutorés</div>
                </a>
            </li>
            @endcan
            @endrole


            <!-- MODULES DE GESTION (ADMINS, SECRETAIRES, etc.) -->

            @can('gerer_structure_pedagogique')
            <li class="menu-item {{ Request::is('academique*') || Request::is('gestion-cours.notes.*') || Request::is('gestion-cours.evaluations.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                    <div data-i18n="Pédagogie">Pédagogie</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::is('academique*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-sitemap"></i>
                            <div data-i18n="Structure Académique">Structure Académique</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::routeIs('academique.facultes.*') ? 'active' : '' }}"><a href="{{ route('academique.facultes.index') }}" class="menu-link">Facultés</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.departements.*') ? 'active' : '' }}"><a href="{{ route('academique.departements.index') }}" class="menu-link">Départements</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.filieres.*') ? 'active' : '' }}"><a href="{{ route('academique.filieres.index') }}" class="menu-link">Filières</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.parcours.*') ? 'active' : '' }}"><a href="{{ route('academique.parcours.index') }}" class="menu-link">Parcours</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.semestres.*') ? 'active' : '' }}"><a href="{{ route('academique.semestres.index') }}" class="menu-link">Semestres</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.ues.*') ? 'active' : '' }}"><a href="{{ route('academique.ues.index') }}" class="menu-link">UE</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.modules.*') ? 'active' : '' }}"><a href="{{ route('academique.modules.index') }}" class="menu-link">Modules</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.salles.*') ? 'active' : '' }}"><a href="{{ route('academique.salles.index') }}" class="menu-link">Salles</a></li>
                            <li class="menu-item {{ Request::routeIs('academique.evaluation-types.*') ? 'active' : '' }}"><a href="{{ route('academique.evaluation-types.index') }}" class="menu-link">Types d\'Évaluation</a></li>
                        </ul>
                    </li>
                        <li class="menu-item {{ Request::routeIs('gestion-cours.evaluations.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Notes et Évaluations">Évaluations et Notes</div>
                            </a>
                           <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('gestion-cours.evaluations.*') ? 'active' : '' }}">
                                    <a href="{{ route('gestion-cours.evaluations.index') }}" class="menu-link">Liste des Évaluations</a>
                                </li>
                            </ul>
                        </li>                
                      </ul>
                   </li>
            @endcan

            @canany(['lister_etudiants', 'gerer_enseignants'])
            <li class="menu-item {{ Request::is('personnes*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Personnes">Personnes</div>
                </a>
                <ul class="menu-sub">
                    @can('lister_etudiants')
                    <li class="menu-item {{ Request::routeIs('personnes.etudiants.*') ? 'active' : '' }}">
                        <a href="{{ route('personnes.etudiants.index') }}" class="menu-link">Étudiants</a>
                    </li>
                    @endcan
                    @can('gerer_enseignants')
                    <li class="menu-item {{ Request::routeIs('personnes.enseignants.*') ? 'active' : '' }}">
                        <a href="{{ route('personnes.enseignants.index') }}" class="menu-link">Enseignants</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['gerer_candidatures', 'gerer_inscriptions'])
            <li class="menu-item {{ Request::is('inscriptions*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Admissions">Admissions</div>
                </a>
                <ul class="menu-sub">
                    @can('gerer_candidatures')
                    <li class="menu-item {{ Request::routeIs('inscriptions.candidatures.*') ? 'active' : '' }}">
                        <a href="{{ route('inscriptions.candidatures.index') }}" class="menu-link">Candidatures</a>
                    </li>
                    @endcan
                    @can('gerer_inscriptions')
                    <li class="menu-item {{ Request::routeIs('inscriptions.inscription-admins.*') ? 'active' : '' }}">
                        <a href="{{ route('inscriptions.inscription-admins.index') }}" class="menu-link">Inscriptions</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @can('gerer_emplois_du_temps')
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Emploi du temps</span></li>
            <li class="menu-item {{ Request::routeIs('gestion-cours.cours.*') ? 'active' : '' }}">
              <a href="{{ route('gestion-cours.cours.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Emploi du temps">Emploi du temps</div>
              </a>
            </li>
            @endcan

            @can('gerer_stages')
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Stages</span></li>
            <li class="menu-item {{ Request::is('stages*') ? 'active open' : '' }}">
                 <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                    <div data-i18n="Gestion des Stages">Gestion des Stages</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::routeIs('stages.stages.*') ? 'active' : '' }}"><a href="{{ route('stages.stages.index') }}" class="menu-link">Suivi des stages</a></li>
                    <li class="menu-item {{ Request::routeIs('stages.entreprises.*') ? 'active' : '' }}"><a href="{{ route('stages.entreprises.index') }}" class="menu-link">Entreprises</a></li>
                </ul>
            </li>
            @endcan
            
            @can('gerer_paiements')
              <li class="menu-header small text-uppercase"><span class="menu-header-text">Gestion Comptable</span></li>
              <li class="menu-item {{ Request::routeIs('paiements.*') ? 'active' : '' }}">
                <a href="{{ route('paiements.index') }}" class="menu-link ">
                  <i class="menu-icon tf-icons bx bxs-wallet-alt"></i>
                  <div data-i18n="Paiements">Paiements</div>
                </a>
              </li>
            @endcan
              
            @role('admin') 
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Paramètres &amp; Sécurité</span></li>
            <li class="menu-item {{ Request::routeIs('parametre') ? 'active' : '' }}">
              <a href="{{ route('parametre') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Form Layouts">Administration</div>
              </a>
            </li>
            @endrole
            
          @endauth
          </ul>
        </aside>
          <!-- Layout container -->
            <div class="layout-page">
              <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                      <i class="icon-base bx bx-menu icon-md"></i>
                    </a>
                  </div>

                  <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                    <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                      
                      <!-- Date et Heure actuelle -->
                      <li class="nav-item me-3 d-none d-md-flex align-items-center">
                        <div class="text-center">
                          <div class="fw-semibold" id="current-date" style="font-size: 0.875rem; line-height: 1.2;">
                            <i class="bx bx-calendar me-1"></i>
                            <span id="date-display"></span>
                          </div>
                          <div class="text-muted" id="current-time" style="font-size: 0.75rem;">
                            <i class="bx bx-time me-1"></i>
                            <span id="time-display"></span>
                          </div>
                        </div>
                      </li>

                      <!-- Notification -->
                      <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                          <span class="position-relative">
                            <i class="icon-base bx bx-bell icon-md"></i>
                            @if($unreadMessagesCount > 0)
                                <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                            @endif
                          </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0" style="width: 380px;">
                          <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                              <h6 class="mb-0 me-auto">Notifications</h6>
                              <div class="d-flex align-items-center h6 mb-0">
                                @if($unreadMessagesCount > 0)
                                    <span class="badge bg-label-primary me-2">{{ $unreadMessagesCount }} non lues</span>
                                @else
                                    <span class="badge bg-label-success me-2">Aucune nouvelle</span>
                                @endif
                                {{-- <a href="javascript:void(0)" class="dropdown-notifications-all p-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Tout marquer comme lu">
                                  <i class="icon-base bx bx-envelope-open text-heading"></i>
                                </a> --}}
                              </div>
                            </div>
                          </li>
                          
                          <li class="dropdown-notifications-list scrollable-container" style="max-height: 400px; overflow-y: auto;">
                            <ul class="list-group list-group-flush">
                                @forelse($recentUnreadMessages as $message)
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                    <a href="{{ route('conversations.show', $message->conversation) }}" class="text-decoration-none text-reset">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="{{ $message->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) }}" alt class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="small mb-0">{{ $message->user->name }}</h6>
                                                <small class="mb-1 d-block text-body">{{ Str::limit($message->body, 50) }}</small>
                                                <small class="text-body-secondary">
                                                    <i class="bx bx-time-five"></i> {{ $message->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li class="list-group-item">
                                    <div class="text-center py-4">
                                      <i class="bx bx-check-square icon-xl text-muted mb-2"></i>
                                      <p class="text-muted">Vous êtes à jour !</p>
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                          </li>
                          
                          <li class="border-top">
                            <div class="d-grid p-4">
                              <a class="btn btn-primary btn-sm d-flex" href="{{ route('conversations.index') }}">
                                <small class="align-middle">Voir toutes les conversations</small>
                              </a>
                            </div>
                          </li>
                        </ul>
                      </li>
                      <!--/ Notification -->

                      <!-- Quick links -->
                      <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                          <i class="icon-base bx bx-grid-alt icon-md"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                          <div class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                              <h6 class="mb-0 me-auto">Raccourcis</h6>
                              <a href="javascript:void(0)" class="dropdown-shortcuts-add py-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter des raccourcis">
                                <i class="icon-base bx bx-plus-circle text-heading"></i>
                              </a>
                            </div>
                          </div>
                          <div class="dropdown-shortcuts-list scrollable-container">
                            <div class="row row-bordered overflow-visible g-0">
                              <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                  <i class="icon-base bx bx-calendar icon-26px text-heading"></i>
                                </span>
                                <a href="app-calendar.html" class="stretched-link">Calendrier</a>
                                <small>Planifiez vos programmes</small>
                              </div>
                              <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                  <i class="icon-base bx bx-food-menu icon-26px text-heading"></i>
                                </span>
                                <a href="app-invoice-list.html" class="stretched-link">Archivage</a>
                                <small>Archivez vos documents</small>
                              </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                              <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                  <i class="icon-base bx bx-calculator icon-26px text-heading"></i>
                                </span>
                                <a href="app-user-list.html" class="stretched-link">Calculatrice</a>
                                <small>Facilité vos calculs</small>
                              </div>
                              <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                  <i class="icon-base bx bx-check-shield icon-26px text-heading"></i>
                                </span>
                                <a href="app-access-roles.html" class="stretched-link">Tâches</a>
                                <small>Gestionnaires de tâches</small>
                              </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                              <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                  <i class="icon-base bx bx-window-open icon-26px text-heading"></i>
                                </span>
                                <a href="modal-examples.html" class="stretched-link">Propriété du système</a>
                                <small>Informations système</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- Quick links -->

                      <!-- User -->
                      <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        @auth
                        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                          <div class="avatar avatar-online">
                            <img src="{{ asset('Pro/assets/img/avatars/user.png') }}" alt class="w-px-40 h-auto rounded-circle"/>
                          </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li>
                            <a class="dropdown-item" href="#">
                              <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                  <div class="avatar avatar-online">
                                    <img src="{{ asset('Pro/assets/img/avatars/user.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                  </div>
                                </div>
                                <div class="flex-grow-1">
                                  <h6 class="mb-0">{{ Auth::user()->prenom }}</h6>
                                  <small class="text-body-secondary">{{ Auth::user()->nom }}</small>
                                </div>
                              </div>
                            </a>
                          </li>
                          <li><div class="dropdown-divider my-1"></div></li>
                          <li>
                            <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">
                              <i class="icon-base bx bx-user icon-md me-3"></i><span>Mon Profil</span>
                            </a>
                          </li>
                          <li><div class="dropdown-divider my-1"></div></li>
                          <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                              <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Déconnexion</span>
                            </a>
                          </li>
                        </ul>
                        @endauth
                      </li>
                      <!--/ User -->
                    </ul>
                  </div>
                </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              
               @yield('content')
            </div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
        @endif

        @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
        @endif

        <!-- Core JS -->
        <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "showMethod": "slideDown",
            "hideMethod": "fadeOut",
            "timeOut": "3500",
            "positionClass": "toast-top-right"
        };

        // Ajuster la position (un peu plus bas que le haut)
        $(document).ready(function() {
            $('.toast-top-right').css({
                'top': '90px',   // espace depuis le haut
                'right': '20px'  // marge à droite
            });
        });

        @if(session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('toastr_success'))
            toastr.success("{{ session('toastr_success') }}");
        @endif

        @if (session('toastr_error'))
            toastr.error("{{ session('toastr_error') }}");
        @endif

        @if (session('toastr_info'))
            toastr.info("{{ session('toastr_info') }}");
        @endif

        @if (session('toastr_warning'))
            toastr.warning("{{ session('toastr_warning') }}");
        @endif
    </script>

    <script>
    // Fonction pour mettre à jour la date et l'heure
    function updateDateTime() {
        const now = new Date();
        
        // Formater la date
        const dateOptions = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
        const dateString = now.toLocaleDateString('fr-FR', dateOptions);
        document.getElementById('date-display').textContent = dateString;
        
        // Formater l'heure
        const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('time-display').textContent = timeString;
    }

    // Mettre à jour immédiatement
    updateDateTime();

    // Mettre à jour toutes les secondes
    setInterval(updateDateTime, 1000);

    // Fonction de recherche des notifications
    document.getElementById('notification-search').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const notifications = document.querySelectorAll('#notifications-list .dropdown-notifications-item');
        const noResults = document.getElementById('no-notifications-found');
        let hasResults = false;
        
        notifications.forEach(function(notification) {
            const text = notification.getAttribute('data-notification-text').toLowerCase();
            
            if (text.includes(searchTerm)) {
                notification.style.display = '';
                hasResults = true;
            } else {
                notification.style.display = 'none';
            }
        });
        
        // Afficher/masquer le message "aucun résultat"
        if (hasResults || searchTerm === '') {
            noResults.classList.add('d-none');
        } else {
            noResults.classList.remove('d-none');
        }
    });

    // Réinitialiser la recherche quand le dropdown se ferme
    document.querySelector('.dropdown-notifications').addEventListener('hidden.bs.dropdown', function() {
        document.getElementById('notification-search').value = '';
        document.querySelectorAll('#notifications-list .dropdown-notifications-item').forEach(function(notification) {
            notification.style.display = '';
        });
        document.getElementById('no-notifications-found').classList.add('d-none');
    });
    </script>

    <style>
    /* Style pour l'horloge */
    #current-date, #current-time {
        white-space: nowrap;
    }

    /* Amélioration du style de recherche */
    #notification-search {
        font-size: 0.875rem;
    }

    #notification-search:focus {
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
    }

    /* Animation pour les notifications filtrées */
    .dropdown-notifications-item {
        transition: all 0.3s ease;
    }

    /* Style pour le message "aucun résultat" */
    #no-notifications-found .icon-xl {
        font-size: 3rem;
    }
    </style>

    <script src="{{ asset('Pro/assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <!-- Core JS -->
    <script src="{{ asset('build/assets/app.js') }}"></script>

    <script src="{{ asset('Pro/assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('Pro/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Pro/assets/vendor/js/bootstrap.js') }}"></script>

    <script src="{{ asset('Pro/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('Pro/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('Pro/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- BS-Stepper JS (Ajouté) -->
    <script src="{{ asset('Pro/assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>

    <!-- Main JS -->

    <script src="{{ asset('Pro/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('Pro/assets/js/dashboards-analytics.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @yield('footer')

  </body>
</html>
