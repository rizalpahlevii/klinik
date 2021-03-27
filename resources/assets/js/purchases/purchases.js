"use strict";
let tableName = "#purchasesTable";
let tbl = $("#purchasesTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    searching: false,
    ajax: {
        url: purchaseUrl,
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
                let showLink = purchaseUrl + "/" + row.id + "/print";
                return (
                    '<a target="_blank" href="' +
                    showLink +
                    '">' +
                    row.receipt_code +
                    "</a>"
                );
            },
            name: "receipt_code"
        },
        {
            data: function(row) {
                let showLink = supplierUrl + "/" + row.supplier.id;
                return (
                    '<a href="' + showLink + '">' + row.supplier.name + "</a>"
                );
            },
            name: "supplier.name"
        },
        {
            data: "salesman.salesman_name",
            name: "salesman.salesman_name"
        },

        {
            data: "receipt_date",
            name: "receipt_date"
        },
        {
            data: "grand_total2",
            name: "grand_total2"
        },
        {
            data: function(row) {
                let url = purchaseUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return prepareTemplateRender("#purchaseActionTemplate", data);
            },
            name: "id"
        }
    ]
});

$("#btn-filter").click(function() {
    tbl.draw();
});
