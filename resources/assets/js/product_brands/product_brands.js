"use strict";
let tableName = "#brandsTbl";
let tbl = $("#brandsTbl").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: brandsUrl,
        data: function(data) {
            data.status = $("#filter_status")
                .find("option:selected")
                .val();
        }
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
            data: function(row) {
                let showLink = brandsUrl + "/" + row.id;
                return '<a href="' + showLink + '">' + row.brand_name + "</a>";
            },
            name: "brand_name"
        },
        {
            data: function(row) {
                let url = brandsUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return prepareTemplateRender("#brandActionTemplate", data);
            },
            name: "id"
        }
    ],
    fnInitComplete: function() {
        $("#filter_status").change(function() {
            $(tableName)
                .DataTable()
                .ajax.reload(null, true);
        });
    }
});

$(document).on("click", ".delete-btn", function(event) {
    let brandId = $(event.currentTarget).data("id");
    deleteItem(brandsUrl + "/" + brandId, "#brandsTbl", "Merek");
});

$(document).on("click", ".edit-btn", function(event) {
    if (ajaxCallIsRunning) {
        return;
    }
    ajaxCallInProgress();
    let brandId = $(event.currentTarget).data("id");
    renderData(brandId);
});

window.renderData = function(id) {
    $.ajax({
        url: brandsUrl + "/" + id + "/edit",
        type: "GET",
        success: function(result) {
            if (result.success) {
                let brand = result.data;
                $("#brandId").val(brand.id);
                $("#editName").val(brand.brand_name);
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
        url: brandCreateUrl,
        type: "POST",
        data: $(this).serialize(),
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#addModal").modal("hide");
                $("#brandsTbl")
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
    var id = $("#brandId").val();
    $.ajax({
        url: brandsUrl + "/" + id,
        type: "put",
        data: $(this).serialize(),
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editModal").modal("hide");
                $("#brandsTbl")
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
