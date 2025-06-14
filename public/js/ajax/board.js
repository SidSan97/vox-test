$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadCategories() {
    $(document).ready(function () {
        $('#boardSpinner').show();

        const pathArray = window.location.pathname.split('/');
        const boardId = pathArray[pathArray.length - 1];

        $.ajax({
            url: '/categories/' + boardId,
            method: 'GET',
            success: function (response) {
                let container = $('#kanban-board');
                container.empty();

                response.data.forEach(function (category) {
                    const tasksHtml = category.tasks.map(task => {
                        return `
                            <div class="d-flex mainDivTask"
                                onmouseenter="iconDisplay(${task.id}, 'show')"
                                onmouseleave="iconDisplay(${task.id}, 'hide')"                             
                            >
                                <div class="card-task d-flex justify-content-between align-items-center"
                                    data-task-title="${task.title}"
                                    data-task-id="${task.id}"
                                    data-task-description="${task.description}"
                                    data-task-created="${task.created_at}"
                                    data-task-updated="${task.updated_at}"                                
                                >
                                    <div>
                                        <div class="taskTitle">${task.title}</div>
                                    </div>
                                </div>

                                <div>
                                    <i class="bi bi-trash deleteTask" data-task-taskid="${task.id}" id="deleteTask${task.id}"></i>
                                </div>
                            </div>
                        `;
                    }).join('');

                    const template = `
                        <div class="kanban-column" data-category-id="${category.id}">
                            <div class="kanban-header">${category.title}</div>

                            <div class="sortable-coluna">
                                ${tasksHtml}
                            </div>

                            <div class="add-card"><i class="bi bi-plus-lg"></i> Adicionar um cartão</div>
                        </div>
                    `;

                    document.querySelector("#kanban-board").insertAdjacentHTML('beforeend', template);

                    activateModal();
                });

                const listContainerHtml = `
                    <div id="list-container" class="d-inline-block">
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
                    </div>
                `;

                container.append(listContainerHtml);

                initSortable();
                initFormListeners();
            },
            error: function (xhr) {
                console.error('Erro ao buscar quadros:', xhr.responseText);
                 Swal.fire({
                    title: "Erro ao buscar quadros!",
                    icon: "error",
                });
            },
            complete: function () {
                $('#boardSpinner').hide();
            }
        });
    });
}

function createCategory() {
    let title = $('#title').val();
    const pathArray = window.location.pathname.split('/');
    const boardId = pathArray[pathArray.length - 1];

    if (!title.trim()) {
        Swal.fire({
            title: "Informe o nome da categoria!",
            icon: "warning"
        });

        return;
    }

    $.ajax({
        url: '/categories',
        method: 'POST',
        data: {
            title: title,
            board_id: boardId
        },
        success: function (response) {
            Swal.fire({
                title: response.message,
                icon: "success",
                showConfirmButton: true,
                willClose: () => {
                    $('#title').val('');
                    loadCategories();
                }
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao criar quadro. Tente novamente mais tarde!",
                icon: "error",
            });
        }
    });
}

function createTask(categoryId) {
    const taskTitle = $('#taskTitle').val();

    $('#spinnerTask').show();
    $.ajax({
        url: '/task',
        method: 'POST',
        data: {
            title: taskTitle,
            category_id: categoryId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response.message)
            loadCategories();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire("Erro ao adicionar tarefa", "", "error");
        },
        complete: function () {
            $('#spinnerTask').hide();
        }
    });
}

$(document).ready(function () {
    loadCategories();
});

$(document).on('click', '#createCategory', function (e) {
    e.preventDefault();
    createCategory();
});

$(document).on('click', '.add-card', function () {
    if ($(this).siblings('.card-form').length > 0) return;

    const textarea = `
        <div class="card-form mt-2 mb-3">
            <textarea class="form-control mb-2" placeholder="Descreva a tarefa..." name="taskTitle" id="taskTitle"></textarea>

            <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-primary save-task">Adicionar</button>

                <div class="spinner-border" id="spinnerTask" style="display:none;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <button class="btn btn-sm btn-light cancel-task">Cancelar</button>
            </div>
        </div>
    `;

    $(this).before(textarea);
});

$(document).on('click', '.cancel-task', function () {
    $(this).closest('.card-form').remove();
});

$(document).on('click', '.save-task', function (e) {
    e.preventDefault();

    const categoryId = $(this).closest('.kanban-column').data('category-id');

    createTask(categoryId);
});

