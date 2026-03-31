<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = MasterItem::with('categories');
        
        if (!empty($this->filters['kode'])) {
            $query->where('kode', 'LIKE', '%' . $this->filters['kode'] . '%');
        }
        
        if (!empty($this->filters['nama'])) {
            $query->where('nama', 'LIKE', '%' . $this->filters['nama'] . '%');
        }
        
        if (!empty($this->filters['hargamin']) && !empty($this->filters['hargamax'])) {
            $query->whereBetween('harga_beli', [$this->filters['hargamin'], $this->filters['hargamax']]);
        } elseif (!empty($this->filters['hargamin'])) {
            $query->where('harga_beli', '>=', $this->filters['hargamin']);
        } elseif (!empty($this->filters['hargamax'])) {
            $query->where('harga_beli', '<=', $this->filters['hargamax']);
        }
        
        return $query->orderBy('id', 'desc')->get();
    }
    
    public function headings(): array
    {
        return [
            'NO',
            'KODE ITEM',
            'NAMA ITEM',
            'KATEGORI',
            'HARGA BELI',
            'LABA (%)',
            'HARGA JUAL',
            'SUPPLIER',
            'JENIS',
            'DIBUAT TANGGAL',
            'TERAKHIR UPDATE'
        ];
    }
    
    public function map($item): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);
        
        $categoryNames = '';
        if ($item->categories && $item->categories->count() > 0) {
            $categoryNames = $item->categories->pluck('nama_category')->implode(', ');
        }
        
        return [
            $rowNumber,
            $item->kode,
            $item->nama,
            $categoryNames,
            $item->harga_beli,
            $item->laba,
            round($hargaJual),
            $item->supplier,
            $item->jenis,
            $item->created_at ? $item->created_at->format('d/m/Y H:i:s') : '-',
            $item->updated_at ? $item->updated_at->format('d/m/Y H:i:s') : '-',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        
        $sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
        
        return [];
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // NO
            'B' => 15,  // KODE ITEM
            'C' => 30,  // NAMA ITEM
            'D' => 25,  // KATEGORI
            'E' => 15,  // HARGA BELI
            'F' => 10,  // LABA
            'G' => 15,  // HARGA JUAL
            'H' => 15,  // SUPPLIER
            'I' => 12,  // JENIS
            'J' => 20,  // DIBUAT
            'K' => 20,  // UPDATE
        ];
    }
    
    public function title(): string
    {
        return 'Master Items_' . date('Ymd');
    }
}