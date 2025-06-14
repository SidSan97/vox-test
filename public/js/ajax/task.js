$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

async function loadTask(id) {
    try {
        const response = await $.ajax({
            url: '/task/' + id,
            method: 'GET'
        });

        return response.data;

    } catch (error) {
        console.error('Erro ao buscar task:', error.responseText);
        Swal.fire({
            title: "Erro ao buscar task!",
            icon: "error",
        });

        return null;
    }
}

function editTask() {
    let title = $('#taskModalTitle').val();
    let description = $('#taskModalBody').val();
    let id = $('#taskModalId').val();

    if (!title.trim()) {
        Swal.fire({
            title: "Informe o título da tarefa!",
            icon: "warning"
        });
        return;
    }

    $('#modalSpinner').show();

    $.ajax({
        url: '/task',
        method: 'PUT',
        data: {
            title: title,
            description: description,
            id: id,
        },
        success: function (response) {
           console.log(response.data)
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao atualizar tarefa. Tente novamente mais tarde!",
                icon: "error",
            });
        },
        complete: function () {
            loadCategories();
           $('#modalSpinner').hide();
        }
    });
}

function deleteTask(taskId) {
    $.ajax({
        url: '/task/' + taskId,
        method: 'DELETE',
        data: {},
        success: function (response) {
           console.log(response.message)
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao excluir tarefa. Tente novamente mais tarde!",
                icon: "error",
            });
        },
        complete: function () {
            loadCategories();
        }
    });
}

$(document).on('click', '#editInfoTask', function (e) {
    e.preventDefault();
    editTask();
});

$(document).on('click', '.deleteTask', function (e) {
    e.preventDefault();
    const taskId = $(this).data('task-taskid');
    deleteTask(taskId);
});