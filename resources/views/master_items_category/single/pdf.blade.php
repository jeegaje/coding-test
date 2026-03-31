{{-- resources/views/categories/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kategori - {{ $category->nama_category }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            padding: 20px;
            position: relative;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .header h3 {
            font-size: 16px;
            color: #34495e;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            color: #7f8c8d;
        }
        
        /* Info Kategori */
        .category-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        
        .category-info table {
            width: 100%;
        }
        
        .category-info td {
            padding: 5px;
        }
        
        .category-info td:first-child {
            font-weight: bold;
            width: 120px;
            background-color: #e9ecef;
        }
        
        /* Summary Card */
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        
        .summary-box {
            flex: 1;
            padding: 10px;
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            border-radius: 5px;
            text-align: center;
        }
        
        .summary-box .label {
            font-size: 11px;
            color: #2e7d32;
            margin-bottom: 5px;
        }
        
        .summary-box .value {
            font-size: 16px;
            font-weight: bold;
            color: #1b5e20;
        }
        
        /* Tabel Items */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .items-table th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 11px;
            border: 1px solid #34495e;
        }
        
        .items-table td {
            padding: 6px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .items-table tr:hover {
            background-color: #f5f5f5;
        }
        
        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: white;
        }
        
        /* Tanda Tangan */
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        
        /* Text alignment */
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .badge {
            background-color: #2196f3;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DETAIL KATEGORI</h1>
        <h3>{{ strtoupper($category->nama_category) }}</h3>
        <p>Dicetak pada: {{ $printed_at->format('d/m/Y') }} | Pukul: {{ $printed_at->format('H:i:s') }}</p>
    </div>

    <div class="category-info">
        <table>
            <tr>
                <td width="120">Kode Kategori</td>
                <td width="10">:</td>
                <td><strong>{{ $category->kode }}</strong></td>
            </tr>
            <tr>
                <td>Nama Kategori</td>
                <td>:</td>
                <td><strong>{{ $category->nama }}</strong></td>
            </tr>
            @if($category->deskripsi)
            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td>{{ $category->deskripsi }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="label">Total Item</div>
            <div class="value">{{ $total_items }} Item</div>
        </div>
    </div>

    <h4 style="margin: 15px 0 10px 0;">Daftar Item dalam Kategori</h4>
    
    @if($items && $items->count() > 0)
        <table class="items-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th width="100">Kode Item</th>
                    <th>Nama Item</th>
                    <th width="100">Harga Beli</th>
                    <th width="60">Laba</th>
                    <th width="100">Harga Jual</th>
                    <th>Supplier</th>
                    <th>Jenis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                @php
                    $harga_jual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->kode }}</td>
                    <td class="text-left">{{ $item->nama }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->laba }}%</td>
                    <td class="text-right">Rp {{ number_format($harga_jual, 0, ',', '.') }}</td>
                    <td class="text-left">{{ $item->supplier }}</td>
                    <td class="text-left">{{ $item->jenis }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; background-color: #f5f5f5; border: 1px solid #ddd;">
            <p>Tidak ada item dalam kategori ini</p>
        </div>
    @endif

    <div style="margin-top: 20px; font-size: 10px; color: #666; background-color: #f5f5f5; padding: 8px; border-radius: 3px;">
        <strong>Catatan:</strong>
        <ul style="margin-left: 20px; margin-top: 5px;">
            <li>Harga Jual = Harga Beli + (Harga Beli × Laba%)</li>
            <li>Total Nilai Inventaris = Total dari semua Harga Jual item</li>
        </ul>
    </div>

    <div class="signature">
        <div class="signature-box">
            <div class="signature-line">
                Dicetak oleh,
            </div>
            <div style="margin-top: 5px;">
                <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
            </div>
            <div style="font-size: 10px; color: #666;">
                {{ $printed_at->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <strong>Master Item System</strong> | Laporan ini digenerate secara otomatis oleh sistem pada {{ $printed_at->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>