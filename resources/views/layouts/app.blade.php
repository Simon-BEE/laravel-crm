<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Dashboard - @yield('title')</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Styles -->
        <link href="{{ asset('css/styles.css') }} " rel="stylesheet" />
        <link href="{{ asset('css/app.css') }} " rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        @yield('css')
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow border-bottom border-dark">
            <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }} / Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Paramètres</a>
                        <a class="dropdown-item" href="#">Journal des logs</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/') }}">Retourner sur le site</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Déconnexion') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="/">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            @manager
                            <div class="sb-sidenav-menu-heading">Données</div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    Clients
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('customers.create') }}">Ajouter un client</a>
                                        <a class="nav-link" href="{{ route('customers.index') }}">Liste de tous les clients</a>
                                    </nav>
                                </div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProjects" aria-expanded="false" aria-controls="collapseProjects">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-project-diagram"></i>
                                    </div>
                                    Projets
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseProjects" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('projects.create') }}">Créer un projet</a>
                                        <a class="nav-link" href="{{ route('projects.index') }}">Liste de tous les projets</a>
                                        <a class="nav-link" href="{{ route('status.projects.index') }}">Gérer les statuts</a>
                                    </nav>
                                </div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTickets" aria-expanded="false" aria-controls="collapseTickets">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-archive"></i>
                                    </div>
                                    Tickets
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseTickets" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="#">Créer un ticket</a>
                                        <a class="nav-link" href="#">Liste de tous les tickets</a>
                                        <a class="nav-link" href="{{ route('status.tickets.index') }}">Gérer les statuts</a>
                                    </nav>
                                </div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEstimates" aria-expanded="false" aria-controls="collapseEstimates">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-copy"></i>
                                    </div>
                                    Devis
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseEstimates" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="#">Créer un devis</a>
                                        <a class="nav-link" href="#">Liste de tous les devis</a>
                                    </nav>
                                </div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoices" aria-expanded="false" aria-controls="collapseInvoices">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    Factures
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseInvoices" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="#">Créer une facture</a>
                                        <a class="nav-link" href="#">Liste de toutes les factures</a>
                                    </nav>
                                </div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArchive" aria-expanded="false" aria-controls="collapseArchive">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-archive"></i>
                                    </div>
                                    Archives
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseArchive" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="#">Clients</a>
                                        <a class="nav-link" href="#">Tickets</a>
                                        <a class="nav-link" href="#">Projets</a>
                                        <a class="nav-link" href="#">Devis</a>
                                        <a class="nav-link" href="#">Facture</a>
                                    </nav>
                                </div>
                                <!-- -->
                                @endmanager
                            </div>
                        </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Connecté en tant que :</div>
                        {{ auth()->user()->name }}
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <!-- Alert -->
                    @if (Session::has('alertType'))
                        <div class="container my-4">
                            <div class="alert alert-dismissible alert-{{Session::get('alertType')}}">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p class="mb-0">{{ Session::get('alertMessage') }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="container-fluid">
                        <ol class="breadcrumb my-4">
                            <li class="breadcrumb-item"><a href="/" class="text-info">Dashboard</a></li>
                            @yield('breadcrumb')
                        </ol>
                        <hr>
                        @yield('content')

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; <strong>{{ config('app.name', 'Laravel') }}</strong> {{ date("Y") }}</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        @yield('modal')
        @yield('javascript')
    </body>
</html>
