<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Template Dashboard</title>
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
        />
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css"
          rel="stylesheet"
        />
        <link rel="stylesheet" href="{{asset('css/home.css')}}">
        <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
        <link rel="stylesheet" href="{{asset('css/board.css')}}">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
  <body>
    @include('navbar')

    <button class="sidebar-toggle-btn" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    @include('sidebar')

    <div class="main-content">
        <h2>Bem-vindo ao quadro Dashboard</h2> <br>

        <!--div id="list-container" class="d-inline-block mb-4">
            <button id="show-form-btn" class="btn add-list-btn">
                + Adicionar outra lista
            </button>

            <div id="list-form" class="add-list-form d-none mt-2">
                <input type="text" class="form-control mb-2" id="title" name="title" placeholder="Digite o nome da lista..." />
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary btn-sm" id="createCategory">Adicionar Lista</button>
                    <button id="cancel-btn" class="btn-close">
                        <i class="bi bi-x-lg text-dark"></i>
                    </button>
                </div>
            </div>
        </div-->

        <div class="kanban-board" id="kanban-board"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/board.js')}}"></script>
    <script src="{{asset('js/ajax/board.js')}}"></script>

  </body>
</html>
