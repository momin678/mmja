<?php
namespace App\Imports;
use App\ItemList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class BulkImport implements ToModel,WithHeadingRow
{
	/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ItemList([
            'style_id' => $row['style_id'],
            'group_no' => $row['group_no'],
            'group_name' => $row['group_name'],
            'barcode' => $row['barcode'],
            'item_name' => $row['item_name'],
            'brand_id' => $row['brand_id'],
            'country' => $row['country'],
            'unit' => $row['unit'],
            'description' => $row['description'],
            'sell_price' => $row['sell_price'],
            'vat_rate' => $row['vat_rate'],
            'vat_amount' => $row['vat_amount'],
            'total_amount' => $row['total_amount'],
        ]);
    }
}