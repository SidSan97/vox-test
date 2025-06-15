<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/desktop.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('css/desktop.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Área de trahalho</title>
</head>
<body>
    <!-- Navbar -->
    @include('navbar')

    <div class="container-fluid">
        <div class="main-content">
            <h3 class="text-light ms-2 mt-4 mb-5">Área de trabalho</h3>

            <div class="container-fluid">
                <p class="text-light">Meus quadros</p>

                <div class="row" id="boardsList">

                        <div id="spinner" class="mt-3 text-light" style="display: none;">
                            <div class="spinner-border text-light" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                            <span class="ms-2">Carregando quadros...</span>
                        </div>

                </div>

                <hr class="text-light"> <br>

                <button class="btn btn-primary" onclick="toggleForm()">
                    <i class="bi bi-plus-lg"></i> Novo quadro
                </button>

                <div class="mt-2" id="formBoard" style="display: none;">
                    <label for="name" class="text-light mb-1">Nome do quadro</label>
                    <div class="d-flex">
                        <input type="text" class="form-control w-25 me-2" id="name" name="name">
                        <button class="btn close-formBoard" onclick="toggleForm('close')">
                            <i class="bi bi-x-lg text-light"></i>
                        </button>
                    </div>

                    <button class="btn btn-success mt-4" id="createBoard">
                        <i class="bi bi-send"></i> Criar quadro
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/utils/closeModal.js')}}"></script>
    <script src="{{asset('js/home.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/ajax/desktop.js')}}"></script>
</body>
</html>
