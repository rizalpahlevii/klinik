"use strict";

let tableName = "#rolesTbl";
let tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    order: [[0, "asc"]],
    ajax: {
        url: rolesUrl
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
            data: "name",
            name: "name"
        },
        {
            data: function(row) {
                let data = [
                    {
                        id: row.id
                    }
                ];
                return prepareTemplateRender("#roleActionTemplate", data);
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
    let roleId = $(event.currentTarget).data("id");
    renderData(roleId);
});

$(document).on("click", ".delete-btn", function(event) {
    let roleId = $(event.currentTarget).data("id");
    deleteItem(rolesUrl + "/" + roleId, "#rolesTbl", "Jabatan");
});

window.renderData = function(id) {
    $.ajax({
        url: rolesUrl + "/" + id + "/edit",
        type: "GET",
        success: function(result) {
            if (result.success) {
                let role = result.data;
                $("#roleId").val(role.id);
                $("#editName").val(role.name);
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
        url: roleCreateUrl,
        type: "POST",
        data: $(this).serialize(),
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addModal").modal("hide");
                $("#roleTbl")
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
    var id = $("#roleId").val();
    $.ajax({
        url: rolesUrl + "/" + id,
        type: "put",
        data: $(this).serialize(),
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editModal").modal("hide");
                $("#rolesTbl")
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
