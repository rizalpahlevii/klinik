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
            data: "payment_method",
            name: "payment_method"
        },
        {
            data: "grand_total2",
            name: "grand_total2"
        }
    ]
});

$("#btn-filter").click(function() {
    tbl.draw();
});
