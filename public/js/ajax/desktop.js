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

                response.data.forEach(function (quadro) {
                    const link = `
                        <a class="my-squad me-3 nav-link" href="/board/${quadro.id}">
                            <span>${quadro.name}</span>
                        </a>
                    `;
                    container.append(link);
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

$(document).ready(function () {
    loadBoards();

    $('#createBoard').on('click', function (e) {
        e.preventDefault();
        createBoard();
    });
});
