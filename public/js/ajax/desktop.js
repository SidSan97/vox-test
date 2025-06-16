$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadBoards() {
    $(document).ready(function () {
        $('#spinner').show();

        $.ajax({
            url: '/boards',
            method: 'GET',
            success: function (response) {
                let container = $('#boardsList');
                container.empty();

                response.data.forEach(function (board) {
                    const icon = board.pivot.role === "admin"
                                ? `<i class="bi bi-three-dots-vertical text-light dropdown-toggle me-3" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>`
                                : "";

                    const link = `
                    <div class="col-md-2 col-6 mb-2">
                        <div class="d-flex">
                            <a class="my-squad me-1 nav-link" href="/board/${board.id}">
                                <span>${board.name}</span>
                            </a>

                            <div class="dropdown">
                                ${icon}
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#del${board.id}">
                                            Excluir
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update${board.id}">
                                            Editar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal fade" id="del${board.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        Deseja mesmo excluir este quadro? Todo seu conteudo também irá ser apagado.
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NÃO</button>
                                        <button
                                            type="button"
                                            class="btn btn-danger deleteBoardBtn"
                                            data-deleteboard-id="${board.id}"
                                            data-role="${board.pivot.role}"
                                        >
                                            <span>SIM</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="update${board.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">${board.name}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="newTitleBoard">Defina o nome do quadro</label>
                                                <input type="text" class="form-control" id="newTitleBoard${board.id}" value="${board.name}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="mt-3 text-dark spinnerEdit" style="display: none;">
                                            <div class="spinner-border text-dark" role="status">
                                                <span class="visually-hidden">Carregando...</span>
                                            </div>
                                            <span class="ms-2">Carregando...</span>
                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-primary updateBoardBtn"
                                            data-updateboard-id="${board.id}"
                                            data-role="${board.pivot.role}"
                                        >
                                            <span>Salvar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    container.append(link);
                });

                editEvent();
                deleteEvent();
            },
            error: function (xhr) {
                console.error('Erro ao buscar quadros:', xhr.responseText);
                 Swal.fire({
                    title: "Erro ao buscar quadros!",
                    icon: "error",
                });
            },
            complete: function () {
                $('#spinner').hide();
            }
        });
    });
}

function createBoard() {
    let name = $('#name').val();

    if (!name.trim()) {
        Swal.fire({
            title: "Informe o nome do quadro!",
            icon: "warning"
        });
        return;
    }

    $('#spinner').show();

    $.ajax({
        url: '/boards',
        method: 'POST',
        data: {
            name: name,
        },
        success: function (response) {
            Swal.fire({
                title: response.message,
                icon: "success",
                showConfirmButton: true,
                willClose: () => {
                    $('#name').val('');
                    document.getElementById('formBoard').style.display = "none";
                    loadBoards();
                }
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao criar quadro. Tente novamente mais tarde!",
                icon: "error",
            });
        },
        complete: function () {
            $('#spinner').hide();
        }
    });
}

function editBoard(boardId, role) {
    let title   = $('#newTitleBoard' + boardId).val();

    if (!title.trim()) {
        Swal.fire({
            title: "Informe o nome do quadro!",
            icon: "warning"
        });
        return;
    }

    $('.spinnerEdit').show();
    $.ajax({
        url: '/boards/' + boardId,
        method: 'PUT',
        data: {
            title: title,
            id: boardId,
            role: role,
        },
        success: function (response) {
           console.log(response.message)
           removeclassesModal();
           escButtonEvent();
           loadBoards();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao atualizar tarefa. Tente novamente mais tarde!",
                icon: "error",
            });
        },
        complete: function () {
            $('.spinnerEdit').hide();
        }
    });
}

function deleteBoard(boardId, role) {
    $.ajax({
        url: '/boards/' + boardId,
        method: 'DELETE',
        data: {
            role: role,
        },
        success: function (response) {
            console.log(response.message)
            Swal.fire({
                title: response.message,
                icon: "success",
                showConfirmButton: true,
                willClose: () => {
                    removeclassesModal();
                    escButtonEvent();
                    loadBoards();
                }
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao excluir quadro!",
                icon: "error",
            });
        },
    });
}

$(document).ready(function () {
    loadBoards();

    $('#createBoard').on('click', function (e) {
        e.preventDefault();
        createBoard();
    });
});

function editEvent() {
    $(document).on('click', '.updateBoardBtn', function (e) {
        e.preventDefault();
        const boardId = $(this).data('updateboard-id');
        const role    = $(this).data('role');
        editBoard(boardId, role);
    });
}

function deleteEvent() {
    $(document).off('click', '.deleteBoardBtn').on('click', '.deleteBoardBtn', function (e) {
        e.preventDefault();
        const boardId = $(this).data('deleteboard-id');
        const role    = $(this).data('role');
        deleteBoard(boardId, role);
    });
}

