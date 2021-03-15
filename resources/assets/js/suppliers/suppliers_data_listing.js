"use strict";

let tableName2 = "#salesmansTbl";
let tbl2 = $("#salesmansTbl").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    paging: false,
    ajax: {
        url: salesmanUrl,
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
            data: "salesman_name",
            name: "salesman_name"
        },
        {
            data: "phone",
            name: "phone"
        },
        {
            data: function(row) {
                let url = salesmanUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return `<a title="Hapus" class="btn action-btn btn-danger btn-sm sales-delete-btn" data-id="${row.id}">
                <i class="fa fa-trash action-icon"></i>
                </a>`;
            },
            name: "id"
        }
    ],
    fnInitComplete: function() {
        $("#filter_status").change(function() {
            $(tableName2)
                .DataTable()
                .ajax.reload(null, true);
        });
    }
});

$(document).on("click", ".sales-delete-btn", function(event) {
    let salesmanId = $(event.currentTarget).data("id");
    deleteItem(
        salesmanUrl + "/" + "salesmans/" + salesmanId,
        "#salesmansTbl",
        "Saleman"
    );
});

$(".btn-save-salesman").click(function() {
    if ($("#salesman_name").val() == "" || $("#salesman_phone").val() == "") {
        alert("Nama sales atau telpn masih kosong");
        return;
    }
    $.ajax({
        url: salesmanUrl + "/" + "salesmans",
        method: "post",
        dataType: "json",
        data: {
            salesman_name: $("#salesman_name").val(),
            salesman_phone: $("#salesman_phone").val()
        },
        success: function(obj) {
            if (obj.success) {
                $(tableName2)
                    .DataTable()
                    .ajax.reload(null, false);
            }
            swal({
                title: "Created!",
                text: "Salesman berhasil dibuat.",
                type: "success",
                timer: 2000
            });
            $("#salesman_name").val("");
            $("#salesman_phone").val("");
        },
        error: function(data) {
            swal({
                title: "",
                text: data.responseJSON.message,
                type: "error",
                timer: 5000
            });
        }
    });
});
