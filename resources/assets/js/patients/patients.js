"use strict";
let tableName = "#patientsTable";
let tbl = $("#patientsTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    ajax: {
        url: patientUrl,
        data: function(data) {
            data.status = $("#filter_status")
                .find("option:selected")
                .val();
        }
    },
    columnDefs: [
        {
            targets: [0, 5, 6],
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
            data: "DT_RowIndex",
            name: "DT_RowIndex"
        },
        {
            data: function(row) {
                let showLink = patientUrl + "/" + row.id;
                return '<a href="' + showLink + '">' + row.name + "</a>";
            },
            name: "name"
        },
        {
            data: "address",
            name: "address"
        },
        {
            data: "phone",
            name: "phone"
        },
        {
            data: "blood_group",
            name: "blood_group"
        },
        {
            data: "city",
            name: "city"
        },
        {
            data: function(row) {
                let url = patientUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return prepareTemplateRender("#patientActionTemplate", data);
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
    let patientId = $(event.currentTarget).data("id");
    deleteItem(patientUrl + "/" + patientId, "#patientsTable", "Patient");
});

$(document).on("change", ".status", function(event) {
    let patientId = $(event.currentTarget).data("id");
    updateStatus(patientId);
});

window.updateStatus = function(id) {
    $.ajax({
        url: patientUrl + "/" + +id + "/active-deactive",
        method: "post",
        cache: false,
        success: function(result) {
            if (result.success) {
                tbl.ajax.reload(null, false);
            }
        }
    });
};
