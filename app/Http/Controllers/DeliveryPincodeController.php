<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DeliveryPincodesImport;
use App\Models\DeliveryPincode;
use Illuminate\Support\Facades\Validator;

class DeliveryPincodeController extends Controller
{
    public function index()
    {
        $pincodes = DeliveryPincode::get();
        return view('admin.pincodes.index',compact('pincodes'));
    }

    public function importPincodes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Step 1: Set all update_status = 0 before import
        DeliveryPincode::query()->update(['update_status' => 0]);

        // Step 2: Import data (which updates records with update_status = 1)
        Excel::import(new DeliveryPincodesImport, $request->file('file'));

        // Step 3: Remove records that were not updated (update_status = 0)
        DeliveryPincode::where('update_status', 0)->delete();

        // Step 4: Reset update_status to 0 for all remaining records
        DeliveryPincode::query()->update(['update_status' => 0]);

        return back()->with('success', 'Pincode data imported successfully!');
    }
}
