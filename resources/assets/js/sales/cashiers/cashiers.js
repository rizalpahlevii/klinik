$(document).ready(function() {
    loadTable();
    function loadTable() {
        $(".table-load").load(cartTableUrl);
    }

    var sellingPrice = document.getElementById("selling_price");
    $("#selling_price").keyup(function() {
        value = $(this).val();
        $(this).val(formatRupiah(value, "Rp. "));
    });

    function formatRupiah(angka, prefix) {
        var numberString = angka.replace(/[^,\d]/g, "").toString(),
            split = numberString.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
});
