"use strict";
let tableName = "#productsTable";
let tbl = $("#productsTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    ajax: {
        url: productUrl,
        data: function(data) {
            data.status = $("#filter_status")
                .find("option:selected")
                .val();
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
                let showLink = productUrl + "/" + row.id;
                return '<a href="' + showLink + '">' + row.name + "</a>";
            },
            name: "name"
        },
        {
            data: "brand.brand_name",
            name: "brand.brand_name"
        },
        {
            data: "selling_price",
            name: "selling_price"
        },
        {
            data: "category.category_name",
            name: "category.category_name"
        },

        {
            data: function(row) {
                let url = productUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return prepareTemplateRender("#productActionTemplate", data);
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
    let productId = $(event.currentTarget).data("id");
    deleteItem(productUrl + "/" + productId, "#productsTable", "Produk");
});

$(document).on("change", ".status", function(event) {
    let productId = $(event.currentTarget).data("id");
    updateStatus(productId);
});

window.updateStatus = function(id) {
    $.ajax({
        url: productUrl + "/" + +id + "/active-deactive",
        method: "post",
        cache: false,
        success: function(result) {
            if (result.success) {
                tbl.ajax.reload(null, false);
            }
        }
    });
};
