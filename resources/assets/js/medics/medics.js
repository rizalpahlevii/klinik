"use strict";
let tableName = "#medicsTable";
let tbl = $("#medicsTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    ajax: {
        url: medicUrl,
        data: function(data) {
            data.status = $("#filter_status")
                .find("option:selected")
                .val();
        }
    },
    columnDefs: [
        {
            targets: [0],
            searchable: false
        },
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
                let showLink = medicUrl + "/" + row.id;
                return '<a href="' + showLink + '">' + row.name + "</a>";
            },
            name: "name"
        },
        {
            data: "specialization",
            name: "specialization"
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
            data: function(row) {
                return row.gender == "male" ? "Pria" : "Wanita";
            },
            name: "gender"
        },
        {
            data: "city",
            name: "city"
        },
        {
            data: function(row) {
                let url = medicUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return prepareTemplateRender("#medicActionTemplate", data);
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
    let medicId = $(event.currentTarget).data("id");
    deleteItem(medicUrl + "/" + medicId, "#medicsTable", "Dokter");
});

$(document).on("change", ".status", function(event) {
    let medicId = $(event.currentTarget).data("id");
    updateStatus(medicId);
});

window.updateStatus = function(id) {
    $.ajax({
        url: medicUrl + "/" + +id + "/active-deactive",
        method: "post",
        cache: false,
        success: function(result) {
            if (result.success) {
                tbl.ajax.reload(null, false);
            }
        }
    });
};
