<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
      #customers {
        border-collapse: collapse;
        width: 90%;
      }

      #customers td,
      #customers th {
        border: 1px solid #ddd;
        padding: 8px;
      }

      .containerTanggal {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: space-between;
        width: 90%;
      }
    </style>
  </head>
  <body>
    <div>
      <div class="containerTanggal">
        <p>Tanggal masuk: {{ $start_date }}</p>
      </div>
      <div class="containerTanggal">
        <p>Tanggal keluar: {{ $end_date }}</p>  
      </div>
      <div class="containerTanggal">
        <p>Type: {{ $type }}</p>  
      </div>
      <table id="customers">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama barang</th>
            <th>Jumlah barang</th>
            <th>Tipe</th>
            <th>Harga barang</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $index => $value)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $value->name }}</td>
              <td>{{ $value->quantity }} unit</td>
              <td>{{ $value->type }}</td>
              <td>Rp. {{ $value->amount }}</td>
              <td>{{ $value->created_at }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </body>
</html>