<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
      #tablesLiner {
        border-collapse: collapse;
        width: 90%;
      }

      #tablesLiner td,
      #tablesLiner th {
        border: 1px solid #ddd;
        padding: 8px;
      }

    </style>
  </head>
  <body>
    <div>    
      <div>
        <p>Tanggal masuk: {{ $start_date }}</p>
        <p>Tanggal keluar: {{ $end_date }}</p>  
      </div>
      
      <br>

      <div>
        <h3>Barang Normal</h3>
        <p>Type: {{ $type }}</p>  
      </div>
      <table id="tablesLiner">
        <thead>
          <tr>
            <th>No</th>
            <th>Gudang</th>
            <th>Rak</th>
            <th>Alias ID</th>
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
              <td>{{ $value->warehouse_name }}</td>
              <td>{{ $value->rack_name }}</td>
              <td>{{ $value->alias_id }}</td>
              <td>{{ $value->name }}</td>
              <td>{{ $value->quantity }} unit</td>
              <td>{{ $value->type }}</td>
              <td>Rp. {{ $value->amount }}</td>
              <td>{{ $value->created_at }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>


      <br>
      <br>

      <div>
        <h3>Barang Defect</h3>  
      </div>
      <table id="tablesLiner">
        <thead>
          <tr>
            <th>No</th>
            <th>Gudang</th>
            <th>Rak</th>
            <th>Alias ID</th>
            <th>Nama barang</th>
            <th>Jumlah barang</th>
            <th>Harga barang</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @if(count($items_defect) === 0)
              <tr>
                <td colspan="8">Tidak ada barang defect</td>
              </tr>
          @else
            @foreach ($items_defect as $index => $value)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $value->warehouse_name }}</td>
                <td>{{ $value->rack_name }}</td>
                <td>{{ $value->alias_id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->quantity }} unit</td>
                <td>Rp. {{ $value->amount }}</td>
                <td>{{ $value->created_at }}</td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>

    </div>
  </body>
</html>
