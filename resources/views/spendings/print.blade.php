<div style="width:300px;height:auto;top:-100px;">
    <div style="width:100%;padding:6px 4px;border-bottom:dashed 1px #333;text-align:center">

        <div class="form-group">
            <small>Ganesha Husada</small><br>
            <small>Kasi : asd</small><br>
            <small>Tanggal : {{ $spending->created_at->format('Y-m-d H:i:s') }}</small>
        </div>
    </div>
    <div style="width:100%;padding:6px 4px;border-bottom:dashed 1px #333;">
        <table style="width:100%;font-size:12px;">
            <tr style="border-bottom:dashed 1px #333;">
                <th>Nama Pengeluaran</th>
                <th>Jenis Pengeluaran</th>
                <th>Tanggal Pengeluaran</th>
                <th>Jumlah Pengeluaran</th>
            </tr>
            <tr>
                <td>{{ $spending->name }}</td>
                <td>
                    @if ($spending->type == "salary")
                    Gaji
                    @elseif($spending->type == "operational")
                    Operasional
                    @elseif($spending->type == "non_operational")
                    Non Operasional
                    @else
                    Kebutuhan Kantor
                    @endif
                </td>
                <td>{{ $spending->created_at->format('Y-m-d : H:is') }}</td>
                <td>{{ convertToRupiah($spending->amount,'Rp. ') }}</td>
            </tr>


        </table>
    </div>


</div>
<style media="screen">
    table tr th {
        margin: 0 0 10px 0;
    }
</style>
