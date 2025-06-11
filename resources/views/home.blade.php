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
    <style>
      /* Corpo */
      body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
      }

      /* Navbar */
      .navbar-custom {
        background-color: #343a40;
      }
      .navbar-custom .navbar-brand,
      .navbar-custom .nav-link {
        color: #ffffff !important;
      }

      /* Sidebar */
      .sidebar {
        height: 100vh;
        position: absolute;
        top: 56px; /* Altura da navbar (padrão Bootstrap 5 é 56px) */
        left: 0;
        bottom: 0;
        width: 250px;
        background-color: #212529;
        padding-top: 20px;
        overflow-y: auto;
      }
      .sidebar a {
        display: block;
        padding: 10px 20px;
        color: #adb5bd;
        text-decoration: none;
        font-size: 0.95rem;
      }
      .sidebar a:hover {
        background-color: #343a40;
        color: #ffffff;
      }

      /* Conteúdo principal */
      .main-content {
        margin-top: 56px; /* altura da navbar */
        margin-left: 250px; /* largura da sidebar */
        padding: 20px;
        background-color: #ffffff;
        min-height: calc(100vh - 56px);
      }

      .category {
        min-width: 272px;
        margin: 10px;
      }

      .row-categories {
        overflow-x: auto;
        display: flex;
        justify-content: space-around;
        width: 100%;
      }

      /* Responsividade: em telas menores, o sidebar pode se esconder (ou ser colapsado) */
      @media (max-width: 992px) {
        .sidebar {
          left: -250px;
          transition: left 0.3s ease;
        }
        .sidebar.show {
          left: 0;
        }
        .main-content {
          margin-left: 0;
        }
      }

      /* Botão de menu para abrir o sidebar em telas pequenas */
      .sidebar-toggle-btn {
        display: none;
      }
      @media (max-width: 992px) {
        .sidebar-toggle-btn {
          display: block;
          position: fixed;
          top: 8px;
          left: 8px;
          z-index: 1100;
          border: none;
          background: #343a40;
          color: #fff;
          padding: 8px 12px;
          border-radius: 4px;
        }
      }
    </style>
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
        <h1>Bem-vindo ao Dashboard</h1>
        <p>
            Este é um exemplo de layout com navbar, sidebar e área principal de
            conteúdo. Ajuste os itens conforme suas necessidades e adicione mais
            componentes.
        </p>

        <!-- Exemplo de cards no conteúdo -->
        <div class="row-categories">
            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                    <h5 class="card-title">Card 1</h5>
                    <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>
            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 2</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>
            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

            <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

             <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

             <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

             <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

             <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
            </div>

             <div class="category">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Card 3</h5>
                        <p class="card-text">Algum texto de exemplo.</p>
                    </div>
                </div>
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
  </body>
</html>
