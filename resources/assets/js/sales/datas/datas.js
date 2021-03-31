"use strict";
let tableName = "#salesTable";
let tbl = $("#salesTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    searching: false,
    ajax: {
        url: saleUrl,
        data: function(data) {
            data.start_date = $("#start").val();
            data.end_date = $("#end").val();
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
            data: function(row) {
                let showUrl = saleUrl + "/" + row.id;
                return `<a target="_blank" href="${showUrl}">${row.receipt_code}</a>`;
            },
            name: "receipt_code"
        },
        {
            data: "receipt_date",
            name: "receipt_date"
        },
        {
            data: "buyer_name",
            name: "buyer_name"
        },
        {
            data: "buyer_type",
            name: "buyer_type"
        },

        {
            data: function(row) {
                if (row == "cash") {
                    return "Tunai";
                } else {
                    return "Debit";
                }
            },
            name: "payment_method"
        },
        {
            data: "grand_total2",
            name: "grand_total2"
        },
        {
            data: function(row) {
                let url = saleUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit",
                        printUrl: url + "/print"
                    }
                ];
                return prepareTemplateRender("#saleActionTemplate", data);
            },
            name: "id"
        }
    ]
});

$("#btn-filter").click(function() {
    tbl.draw();
});
