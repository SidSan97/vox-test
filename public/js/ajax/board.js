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
                if (response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }
                
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
                                    <i class="bi bi-trash deleteTask" 
                                        data-task-taskid="${task.id}" 
                                        id="deleteTask${task.id}"
                                    ></i>
                                </div>
                            </div>
                        `;
                    }).join('');

                    const template = `
                        <div class="kanban-column" data-category-id="${category.id}">
                            <div class="kanban-header d-flex justify-content-between">
                                ${category.title}

                                <div class="dropdown">
                                    <i class="bi bi-three-dots-vertical text-light dropdown-toggle me-3" id="dropButton${category.id}" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <ul class="dropdown-menu" aria-labelledby="dropButton${category.id}">
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete${category.id}">
                                                Excluir
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateCategory${category.id}">
                                                Editar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="sortable-coluna">
                                ${tasksHtml}
                            </div>

                            <div class="add-card"><i class="bi bi-plus-lg"></i> Adicionar um cartão</div>
                        </div>

                        <div class="modal fade" id="delete${category.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-dark" id="exampleModalLabel">Atenção!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body text-dark">
                                        Deseja mesmo excluir esta categoria? Todo seu conteudo também irá ser apagado.
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NÃO</button>
                                        <button 
                                            type="button" 
                                            class="btn btn-danger deleteCategoryBtn" 
                                            data-deletecategory-id="${category.id}"
                                        >
                                            <span>SIM</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="updateCategory${category.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-dark" id="exampleModalLabel">${category.title}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body text-dark">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="newTitleCategory">Defina o nome da categoria</label>
                                                <input type="text" class="form-control" id="newTitleCategory${category.id}" value="${category.title}">
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
                                            class="btn btn-primary updateCategoryBtn" 
                                            data-updatecategory-id="${category.id}"
                                        >
                                            <span>Salvar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    document.querySelector("#kanban-board").insertAdjacentHTML('beforeend', template);
             
                });
         
                deleteCategoryEvent();
                editCategoryEvent();

                const listContainerHtml = `
                    <div id="list-container" class="d-inline-block">
                        <button id="show-form-btn" class="btn add-list-btn">
                            + Criar lista
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

function deleteCategory(categoryId) {
    $.ajax({
        url: '/categories/' + categoryId,
        method: 'DELETE',
        data: {},
        success: function (response) {
            console.log(response.message)
            Swal.fire({
                title: response.message,
                icon: "success",
                showConfirmButton: true,
                willClose: () => {
                    removeclassesModal();
                    escButtonEvent();
                    loadCategories();
                }
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao excluir categoria!",
                icon: "error",
            });
        },
    });
}

function updateCategory(id) {
    let title   = $('#newTitleCategory' + id).val();

    if (!title.trim()) {
        Swal.fire({
            title: "Informe o nome da categoria!",
            icon: "warning"
        });
        return;
    }

    $('.spinnerEdit').show();
    $.ajax({
        url: '/categories/' + id,
        method: 'PUT',
        data: {
            title: title,
            id: id,
        },
        success: function (response) {
           console.log(response.message)
           removeclassesModal();
           escButtonEvent();
           loadCategories();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Erro ao atualizar categoria. Tente novamente mais tarde!",
                icon: "error",
            });
        },
        complete: function () {
            $('.spinnerEdit').hide();
        }
    });
}

$(document).ready(function () {
    loadCategories();
    activateModal();
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

function deleteCategoryEvent() {
    $(document).off('click', '.deleteCategoryBtn').on('click', '.deleteCategoryBtn', function (e) {
        e.preventDefault();
        const categoryId = $(this).data('deletecategory-id');
        deleteCategory(categoryId);
    });
}

function editCategoryEvent() {
    $(document).off('click', '.updateCategoryBtn').on('click', '.updateCategoryBtn', function (e) {
        e.preventDefault();
        const updateId = $(this).data('updatecategory-id');
        updateCategory(updateId);
    });
}