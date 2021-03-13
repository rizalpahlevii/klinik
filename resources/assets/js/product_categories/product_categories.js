"use strict";

let tableName = "#categoriesTbl";
let tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    order: [[0, "asc"]],
    ajax: {
        url: categoriesUrl
    },
    columnDefs: [
        {
            targets: [1],
            orderable: false,
            className: "text-center",
            width: "5%"
        },
        {
            targets: "_all",
            defaultContent: "N/A"
        }
    ],
    columns: [
        {
            data: "category_name",
            name: "category_name"
        },
        {
            data: function(row) {
                let data = [
                    {
                        id: row.id
                    }
                ];
                return prepareTemplateRender(
                    "#productCategoryActionTemplate",
                    data
                );
            },
            name: "id"
        }
    ]
});

$(document).on("click", ".edit-btn", function(event) {
    if (ajaxCallIsRunning) {
        return;
    }
    ajaxCallInProgress();
    let categoryId = $(event.currentTarget).data("id");
    renderData(categoryId);
});

$(document).on("click", ".delete-btn", function(event) {
    let categoryId = $(event.currentTarget).data("id");
    deleteItem(
        categoriesUrl + "/" + categoryId,
        "#categoriesTbl",
        "Data Kategori"
    );
});

window.renderData = function(id) {
    $.ajax({
        url: categoriesUrl + "/" + id + "/edit",
        type: "GET",
        success: function(result) {
            if (result.success) {
                let category = result.data;
                $("#categoryId").val(category.id);
                $("#category_name_udpate").val(category.category_name);
                $("#editModal").modal("show");
                ajaxCallCompleted();
            }
        },
        error: function(result) {
            manageAjaxErrors(result);
        }
    });
};

$(document).on("submit", "#addNewForm", function(event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find("#btnSave");
    loadingButton.button("loading");
    $.ajax({
        url: categoryCreateUrl,
        type: "POST",
        data: $(this).serialize(),
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addModal").modal("hide");
                $("#categoriesTbl")
                    .DataTable()
                    .ajax.reload(null, true);
            }
        },
        error: function(result) {
            printErrorMessage("#validationErrorsBox", result);
        },
        complete: function() {
            loadingButton.button("reset");
        }
    });
});

$(document).on("submit", "#editForm", function(event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find("#btnEditSave");
    loadingButton.button("loading");
    var id = $("#categoryId").val();
    $.ajax({
        url: categoriesUrl + "/" + id,
        type: "put",
        data: $(this).serialize(),
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editModal").modal("hide");
                $("#categoriesTbl")
                    .DataTable()
                    .ajax.reload(null, true);
            }
        },
        error: function(result) {
            UnprocessableInputError(result);
        },
        complete: function() {
            loadingButton.button("reset");
        }
    });
});

$("#addModal").on("hidden.bs.modal", function() {
    resetModalForm("#addNewForm", "#validationErrorsBox");
});

$("#editModal").on("hidden.bs.modal", function() {
    resetModalForm("#editForm", "#editValidationErrorsBox");
});
