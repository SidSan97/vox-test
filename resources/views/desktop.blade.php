<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/desktop.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('css/desktop.css')}}">

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
            <div class="d-flex">
                <div class="my-squad me-3">
                    <span>Teste Vox</span>
                </div>
            </div>

            <hr class="text-light"> <br>

            <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo quadro</button>

            <div class="mt-2">
                <label for="name" class="text-light mb-1">Nome do quadro</label>
                <input type="text" class="form-control w-25" id="name" name="name">
                <input type="hidden" value="{{Auth::user()->id}}">

                <button class="btn btn-success mt-4"><i class="bi bi-send"></i> Criar quadro</button>
            </div>
        </div>

    </div>
</body>
</html>