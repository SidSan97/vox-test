<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/desktop.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('css/desktop.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Área de trahalho</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-secondary navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">DASHBOARD</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notificações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>
                </ul>
            </div>
      </div>
    </nav>

    <!-- Botão de toggle para sidebar em telas pequenas -->
    <button class="sidebar-toggle-btn" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    @include('sidebar')

    <div class="main-content">
        <h3 class="text-light ms-2 mt-4 mb-5">Área de trabalho</h3>

        <div class="container-fluid">
            <p class="text-light">Meus quadros</p>

            <div class="d-flex" id="boardsList">
                <div id="spinner" class="mt-3 text-light" style="display: none;">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <span class="ms-2">Criando quadro...</span>
                </div>
            </div>

            <hr class="text-light"> <br>

            <button class="btn btn-primary" onclick="toggleForm()">
                <i class="bi bi-plus-lg"></i> Novo quadro
            </button>

            <div class="mt-2" id="formBoard" style="display: none;">
                <label for="name" class="text-light mb-1">Nome do quadro</label>
                <input type="text" class="form-control w-25" id="name" name="name">

                <button class="btn btn-success mt-4" id="createBoard">
                    <i class="bi bi-send"></i> Criar quadro
                </button>
            </div>
        </div>
    </div>

    <script src="{{asset('js/home.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/ajax/desktop.js')}}"></script>
</body>
</html>
