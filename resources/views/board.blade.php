<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Template Dashboard</title>
        <!-- Bootstrap 5 CSS -->
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
        />
        <!-- Bootstrap Icons (opcional) -->
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css"
          rel="stylesheet"
        />
        <link rel="stylesheet" href="{{asset('css/home.css')}}">
        <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
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

    <!-- Sidebar -->
    @include('sidebar')

    <!-- Conteúdo principal -->
    <div class="main-content">
        <h2>Bem-vindo ao quadro Dashboard</h2> <br>

        <div class="kanban-board">

    <!-- Coluna 1 -->
    <div class="kanban-column">
      <div class="kanban-header">Tarefas</div>
      <div class="sortable-coluna">
        <div class="card-task d-flex justify-content-between align-items-center">
          <div>
            <div>Especificar requisitos</div>
            <div class="text-muted small"><i class="bi bi-eye"></i> <i class="bi bi-list-task"></i></div>
          </div>
        </div>
        <div class="card-task d-flex justify-content-between align-items-center">
          <div>
            <div>Validar escopo</div>
            <div class="text-muted small"><i class="bi bi-eye"></i> <i class="bi bi-list-task"></i></div>
          </div>
        </div>
      </div>
      <div class="add-card"><i class="bi bi-plus-lg"></i> Adicionar um cartão</div>
    </div>

    <!-- Coluna 2 -->
    <div class="kanban-column">
      <div class="kanban-header">Em andamento</div>
      <div class="sortable-coluna">
        <div class="card-task d-flex justify-content-between align-items-center">
          <div>
            <div>Autopreencher fortalezas</div>
            <div class="text-muted small"><i class="bi bi-eye"></i> <i class="bi bi-list-task"></i></div>
          </div>
        </div>
      </div>
      <div class="add-card"><i class="bi bi-plus-lg"></i> Adicionar um cartão</div>
    </div>

    <!-- Coluna 3 -->
    <div class="kanban-column">
      <div class="kanban-header">Concluído</div>
      <div class="sortable-coluna">
        <div class="card-task d-flex justify-content-between align-items-center">
          <div>
            <div>Autopreencher monitoramento</div>
            <div class="text-muted small"><i class="bi bi-eye"></i> <i class="bi bi-list-task"></i></div>
          </div>
        </div>
        <div class="card-task d-flex justify-content-between align-items-center">
          <div>
            <div>Flag atividades em aberto</div>
            <div class="text-muted small"><i class="bi bi-eye"></i> <i class="bi bi-list-task"></i></div>
          </div>
        </div>
      </div>
      <div class="add-card"><i class="bi bi-plus-lg"></i> Adicionar um cartão</div>
    </div>

  </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const sidebar = document.getElementById("sidebar");
      const toggleBtn = document.getElementById("sidebarToggle");

      toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("show");
      });
    </script>
    <!-- SortableJS -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <script>
    document.querySelectorAll('.sortable-coluna').forEach(function (el) {
      new Sortable(el, {
        group: 'kanban',
        animation: 150,
        ghostClass: 'bg-secondary'
      });
    });
  </script>
  </body>
</html>
