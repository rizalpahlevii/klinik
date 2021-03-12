"use strict";

let tableName = "#usersTbl";
let tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    order: [[0, "asc"]],
    ajax: {
        url: usersUrl
    },
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "N/A"
        }
    ],
    columns: [
        {
            data: "fullname",
            name: "fullname"
        },
        {
            data: "role",
            name: "role"
        },
        {
            data: "phone",
            name: "phone"
        },
        {
            data: "address",
            name: "address"
        },
        {
            data: "start_working_date",
            name: "start_working_date"
        },
        {
            data: "gender",
            name: "gender"
        },
        {
            data: function(row) {
                let url = usersUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit"
                    }
                ];
                return prepareTemplateRender("#userActionTemplate", data);
            },
            name: "id"
        }
    ]
});

$(document).on("click", ".delete-btn", function(event) {
    let userId = $(event.currentTarget).data("id");
    deleteItem(usersUrl + "/" + userId, "#usersTbl", "Pengguna");
});
