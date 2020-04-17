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
            <a class="navbar-brand" href="@admin {{ route('admin.home') }} @else {{ route('customer.home') }} @endadmin">
                SKYMON<span class="font-weight-bold">MANAGER</span>
            </a>
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
                        @admin
                            <a class="dropdown-item" href="@admin {{ route('admin.settings.index') }} @else {{ route('customer.settings.index') }} @endadmin">Paramètres</a>
                            <a class="dropdown-item" href="#">Journal des logs</a>
                            <div class="dropdown-divider"></div>
                        @endadmin
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
                            <div class="sb-sidenav-menu-heading">Général</div>
                            <a class="nav-link" href="@admin {{ route('admin.home') }} @else {{ route('customer.home') }} @endadmin">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            @admin
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
                                        <a class="nav-link" href="{{ route('admin.customers.create') }}">Ajouter un client</a>
                                        <a class="nav-link" href="{{ route('admin.customers.index') }}">Liste de tous les clients</a>
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
                                        <a class="nav-link" href="{{ route('admin.projects.create') }}">Créer un projet</a>
                                        <a class="nav-link" href="{{ route('admin.projects.index') }}">Liste de tous les projets</a>
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
                                        <a class="nav-link" href="{{ route('admin.priorities.index') }}">Priorités</a>
                                        <a class="nav-link" href="{{ route('admin.issues.index') }}">Problèmes</a>
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
                                        <a class="nav-link" href="{{ route('admin.estimates.create') }}">Créer un devis</a>
                                        <a class="nav-link" href="{{ route('admin.estimates.index') }}">Liste de tous les devis</a>
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
                                        <a class="nav-link" href="{{ route('admin.invoices.create') }}">Créer une facture</a>
                                        <a class="nav-link" href="{{ route('admin.invoices.index') }}">Liste de toutes les factures</a>
                                    </nav>
                                </div>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStatus" aria-expanded="false" aria-controls="collapseStatus">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-sticky-note"></i>
                                    </div>
                                    Statuts
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseStatus" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('admin.status.create') }}">Ajouter un statut</a>
                                        <a class="nav-link" href="{{ route('admin.status.index') }}">Liste de tous les statuts</a>
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
                                        <a class="nav-link" href="{{ route('admin.archives.customers.index') }}">Clients</a>
                                        <a class="nav-link" href="#">Tickets</a>
                                        <a class="nav-link" href="{{ route('admin.archives.projects.index') }}">Projets</a>
                                        <a class="nav-link" href="#">Devis</a>
                                        <a class="nav-link" href="#">Facture</a>
                                    </nav>
                                </div>
                                <!-- -->
                            @else
                                <div class="sb-sidenav-menu-heading">Données</div>
                                <!-- -->
                                <a class="nav-link" href="{{ route('customer.projects.index') }}">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-project-diagram"></i>
                                    </div>
                                    Mes projets
                                </a>
                                <!-- -->
                                <a class="nav-link" href="{{ route('customer.documents.index') }}">
                                    <div class="sb-nav-link-icon">
                                        <i class="far fa-copy"></i>
                                    </div>
                                    Mes documents
                                </a>
                                <!-- -->
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArchive" aria-expanded="false" aria-controls="collapseArchive">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-life-ring"></i>
                                    </div>
                                    Support
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseArchive" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('customer.tickets.create') }}">Ouvrir un ticket</a>
                                        <a class="nav-link" href="{{ route('customer.tickets.index') }}">Mes Tickets</a>
                                    </nav>
                                </div>
                            @endadmin
                            <div class="sb-sidenav-menu-heading">Compte</div>
                            <!-- -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="false" aria-controls="collapseAccount">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                Modifier
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseAccount" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="@admin {{ route('admin.account.edit') }} @else {{ route('customer.account.edit') }} @endadmin">Informations personnelles</a>
                                    <a class="nav-link" href="@admin {{ route('admin.account.password') }} @else {{ route('customer.account.password') }} @endadmin">Mot de passe</a>
                                </nav>
                            </div>
                            <!-- -->
                            <a class="nav-link" href="@admin {{ route('admin.settings.index') }} @else {{ route('customer.settings.index') }} @endadmin">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                Paramètres
                            </a>
                            <!-- -->
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

                        @if (!auth()->user()->changed)
                        <div class="fixed-bottom text-center">
                            <div class="alert alert-dismissible alert-danger">
                                <p class="mb-0">Nous vous invitons à <a class="text-danger font-weight-bold" href="{{ route('customer.account.password') }}">modifier votre mot de passe</a>.</p>
                            </div>
                        </div>
                        @endif
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
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        @yield('modal')
        @yield('javascript')
        @yield('javascript-filter')
    </body>
</html>
