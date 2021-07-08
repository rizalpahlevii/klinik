"use strict";
let tableName = "#spendingsTable";
let tbl = $("#spendingsTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    searching: false,
    ajax: {
        url: spendingUrl,
        data: function(data) {
            data.start_date = $("#start").val();
            data.end_date = $("#end").val();
            data.type = $("#type").val();
        }
    },
    columnDefs: [
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
            data: "type",
            name: "type"
        },
        {
            data: "date",
            name: "date"
        },
        {
            data: "amount",
            name: "amount"
        },
        {
            data: function(row) {
                let url = spendingUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit",
                        urlPrint: url + "/print"
                    }
                ];
                return prepareTemplateRender("#spendingActionTemplate", data);
            },
            name: "id"
        }
    ]
});

$("#btn-filter").click(function() {
    tbl.draw();
});
$(document).on("click", ".delete-btn", function(event) {
    let spendingId = $(event.currentTarget).data("id");
    deleteItem(spendingUrl + "/" + spendingId, "#spendingsTable", "Pembelian");
});
