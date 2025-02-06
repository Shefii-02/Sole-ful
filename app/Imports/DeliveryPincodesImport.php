<?php
namespace App\Imports;

use App\Models\DeliveryPincode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryPincodesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        // Update existing or create new record with update_status = 1
        DeliveryPincode::updateOrCreate(
            ['pincode' => $row['pincode']], // Unique identifier
            [
                'city' => $row['city'],
                'hub_code'=> $row['hub_code'],
                'fm' => $row['fm'],
                'lm' => $row['lm'],
                'cod' => $row['cod'],
                'state' => $row['state'],
                'update_status' => 1 // Mark as updated
            ]
        );
    }
}
