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
        <link rel="stylesheet" href="{{asset('css/board.css')}}">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
  <body id="bodyBoard">
    @include('navbar')

    <div class="main-content">
        <h2>Bem-vindo ao quadro</h2> <br>

        <div class="kanban-board" id="kanban-board">
            <div id="boardSpinner" class="spinner-border" style="display: none;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="taskModalLabel">Detalhes da tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-3">
                            <label for="taskModalTitle">Título</label>
                            <textarea class="form-control" id="taskModalTitle" cols="30" rows="1"></textarea>
                        </div>

                        <div class="col-12">
                            <label for="taskModalBody">Descrição</label>
                            <textarea class="form-control" id="taskModalBody" cols="30" rows="3">
                            </textarea>
                        </div>

                        <textarea id="taskModalId" class="d-none"></textarea>
                    </div>

                    <div class="d-flex w-100 justify-content-center mt-2 mb-2">
                        <div id="modalSpinner" class="spinner-border" style="display: none;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <strong>Criado em:</strong>
                            <p id="taskModalCreated"></p>
                        </div>

                        <div class="col-6">
                            <strong>Última atualização:</strong>
                            <p id="taskModalUpdated"></p>
                        </div>
                    </div>

                    <strong>Autor: </strong> <span id="taskAuthor"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editInfoTask">Salvar mudanças</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/utils/closeModal.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/board.js')}}"></script>
    <script src="{{asset('js/ajax/task.js')}}"></script>
    <script src="{{asset('js/ajax/board.js')}}"></script>

  </body>
</html>
