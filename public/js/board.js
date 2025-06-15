
function initFormListeners() {
    const showFormBtn = document.getElementById("show-form-btn");
    const listForm = document.getElementById("list-form");
    const cancelBtn = document.getElementById("cancel-btn");

    if (showFormBtn && listForm && cancelBtn) {
        showFormBtn.addEventListener("click", () => {
            showFormBtn.classList.add("d-none");
            listForm.classList.remove("d-none");
        });

        cancelBtn.addEventListener("click", () => {
            listForm.classList.add("d-none");
            showFormBtn.classList.remove("d-none");
        });
    }
}

// Menu lateral
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("sidebarToggle");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("show");
});

// SortableJS
function initSortable() {
    document.querySelectorAll('.sortable-coluna').forEach(function (el) {
        new Sortable(el, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'bg-secondary',
            onEnd: function (evt) {
                const taskElement = evt.item.querySelector('.card-task');
                const movedTaskId = taskElement.dataset.taskId;

                const newCategoryElement = evt.to.closest('.kanban-column');
                const newCategoryId = newCategoryElement.dataset.categoryId;

                const reorderedTasks = Array.from(evt.to.children).map((child, index) => {
                    const card = child.querySelector('.card-task');
                    return {
                        id: card?.dataset.taskId,
                        position: index
                    };
                }).filter(task => task.id); // filtra nulls ou undefined

                $.ajax({
                    url: '/tasks/reorder',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: movedTaskId,
                        tasks: reorderedTasks,
                        category_id: newCategoryId
                    },
                    success: function (response) {
                        console.log(response.message);
                    },
                    error: function (xhr) {
                        console.error("Erro ao reordenar", xhr.responseText);
                    },
                    complete: function () {
                        loadCategories();
                    }
                });
            }
        });
    });
}

//modal Bootstrap
function activateModal() {
    $(document).on('click', '.card-task', async function () {
        const taskId = $(this).data('task-id');

        try {
            const data = await loadTask(taskId);

            $('#taskModalTitle').val('').val(data.title);
            $('#taskModalBody').val('').val(data.description);
            $('#taskModalBody').text(data.description);
            $('#taskModalCreated').text(formattingDate(data.created_at));
            $('#taskModalUpdated').text(formattingDate(data.updated_at));
            $('#taskModalId').text(data.id);
            $('#taskAuthor').text(data.user.name);

            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        } catch (error) {
            console.error("Erro ao carregar task:", error);
            Swal.fire({
                title: "Erro ao buscar task!",
                icon: "error",
            });
        }
    });
}

function closeModal()
{
    setTimeout(() => {
        $('.modal-backdrop').remove();
    }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('taskModal');

    modalEl.addEventListener('hidden.bs.modal', function () {
        document.getElementById("bodyBoard").removeAttribute("style");
    });
});

function formattingDate(originalDate) {
    const isoDate = originalDate;
    const dateObj = new Date(isoDate);

    const formattedDate = dateObj.toLocaleString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false
    });

    return formattedDate;
}

function iconDisplay(id, status) {
    if(status === "show") {
        $('#deleteTask' + id).show();
    } else if (status === "hide"){
        $('#deleteTask' + id).hide();
    }
}

