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
                        <div class="d-flex">
                            <a class="my-squad me-1 nav-link" href="/board/${board.id}">
                                <span>${board.name}</span>                       
                            </a>

                            <div class="dropdown">
                                ${icon}
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" id="deleteBoard">Excluir</a></li>
                                    <li id="editBoard">
                                        <a class="dropdown-item" data-board-id="${board.id}">
                                            Editar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>    
                    `;
                    container.append(link);

                    editEvent();
                });
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

function editBoard() {
    
}

$(document).ready(function () {
    loadBoards();

    $('#createBoard').on('click', function (e) {
        e.preventDefault();
        createBoard();
    });
});

function editEvent() {
    $(document).on('click', '#editBoard a', function (e) {
        e.preventDefault();
        const boardId = $(this).data('board-id');
        editBoard(boardId);
    });
}