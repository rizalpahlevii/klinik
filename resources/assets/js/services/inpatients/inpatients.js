"use strict";
let tableName = "#inpatientsTable";
let tbl = $("#inpatientsTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    ajax: {
        url: inpatientUrl,
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
                let showLink = inpatientUrl + "/" + row.id;
                return (
                    '<a href="' + showLink + '">' + row.service_number + "</a>"
                );
            },
            name: "service_number"
        },
        {
            data: "registration_time",
            name: "registration_time"
        },
        {
            data: function(row) {
                let showLink = patientUrl + "/" + row.patient.id;
                return (
                    '<a href="' + showLink + '">' + row.patient.name + "</a>"
                );
            },
            name: "patient.name"
        },

        {
            data: function(row) {
                let showLink = medicUrl + "/" + row.medic.id;
                return '<a href="' + showLink + '">' + row.medic.name + "</a>";
            },
            name: "medic.name"
        },
        {
            data: "phone",
            name: "phone"
        },
        {
            data: "total_fee",
            name: "total_fee"
        },

        {
            data: function(row) {
                let url = inpatientUrl + "/" + row.id;
                let data = [
                    {
                        id: row.id,
                        url: url + "/edit",
                        urlPrint: url + "/print"
                    }
                ];
                return prepareTemplateRender("#inpatientActionTemplate", data);
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
    let inpatientId = $(event.currentTarget).data("id");
    deleteItem(
        inpatientUrl + "/" + inpatientId,
        "#inpatientsTable",
        "Layanan Rawat Inap"
    );
});

$(document).on("change", ".status", function(event) {
    let inpatientId = $(event.currentTarget).data("id");
    updateStatus(inpatientId);
});
