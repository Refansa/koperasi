<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Koperasi</title>
  <style>
    table,
    th,
    tr,
    td {
      padding: 0.25rem;
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>
</head>

<body>
  <div style="margin-bottom: 8rem;">
    <div style="float: left;">
      <h1
        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
        KOPE<span style="color: #3DC187">RASI</span>
      </h1>
    </div>
    <div style="float: right; text-align: right;">
      <div style="margin-bottom: 0.25rem;">
        <span style="font-weight: 600;">Tanggal Transaksi: </span>
        <span>{{ $withdraw->created_at }}</span>
      </div>
      <div>
        <span style="font-weight: 600;">Tanggal Print: </span>
        <span>{{ date('Y-m-d H:i:s') }}</span>
      </div>
    </div>
  </div>
  <div style="margin-bottom: 2.5rem;">
    <div style="text-decoration: underline;">Koperasi:</div>
    <div style="font-weight: 600;">Koperasi Jaya</div>
    <div>Alamat: Jl. Menuju Kesuksesan</div>
    <div>Phone: (+62) 81234567890</div>
    <div>Email: admin@koperasi.com</div>
  </div>
  <div style="margin-bottom: 2.5rem;">
    <div style="text-decoration: underline;">To:</div>
    <div style="font-weight: 600;">{{ $withdraw->user->name }}</div>
    <div>Email: {{ $withdraw->user->email }}</div>
    <div>Kontak: {{ $withdraw->user->contact }}</div>
  </div>
  <div style="margin-bottom: 4rem;">
    <div style="font-weight: 600;">No Transaksi# T-{{ $withdraw->id }}</div>
    <div style="font-weight: 600;">ID User: {{ $withdraw->user->id }}</div>
  </div>
  <table style="width: 100%;">
    <tr>
      <td>Jenis Simpanan:</td>
      <td>{{ $withdraw->type }}</td>
    </tr>
    <tr>
      <td>Jumlah Tarik:</td>
      <td>Rp. {{ number_format($withdraw->transaction->amount, 0, ',', '.') }}</td>
    </tr>
  </table>
</body>

</html>
