
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
                const taskElement = evt.item;
                const movedTaskId = evt.item.dataset.taskId;

                const newCategoryElement = evt.to.closest('.kanban-column');
                const newCategoryId = newCategoryElement.dataset.categoryId;

                const reorderedTasks = Array.from(evt.to.children).map((child, index) => {
                    return {
                        id: child.dataset.taskId,
                        position: index
                    };
                });

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

