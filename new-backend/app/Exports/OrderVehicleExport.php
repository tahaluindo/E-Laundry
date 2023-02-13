<?php

namespace App\Exports;

use App\Models\OrderVehicle;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Sheet;

class OrderVehicleExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    // a place to store the team dependency
    private $orderVehicles;
    private $formattedOrderVehicles = array();

    // use constructor to handle dependency injection
    public function __construct($orderVehicles)
    {
        $this->orderVehicles = $orderVehicles;
    }

    
    /**
    * @return \Illuminate\Support\Collection
    */ 
    public function headings():array{
        return[
            'No',
            'Nama Pemesan',
            'Tanggal Pemesanan',
            'Hari Pemesan',
            'Tanggal Kembali',
            'Hari kembali',
            'Nama Pengemudi',
            'Nomor Polisi',
            'Nama Kendaraan',
            'Nama Approval Pertama',
            'Nama Approval Kedua',
            'Status Pemesanan',
            'Dibuat Pada Tanggal'
        ];
    } 

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        foreach($this->orderVehicles as $index => $order){
            switch ($order->status){
                case 'Pending Second Approval' :
                    $order->status = "Menunggu persetujuan kedua";
                    break;
                case 'Approved' :
                    $order->status = "Pemesanan sudah disetujui";
                    break;
                case 'In Use' :
                    $order->status = "Kendaraan sedang digunakan";
                    break;
                case 'Finished' :
                    $order->status = "Kendaraan sudah dikembalikan";
                    break;
                default :
                    $order->status = "Menunggu persetujuan pertama";
                    break;
            };

            $formattedOrderVehicles[] = [
                'no' => $index+1,
                'requestor_name' => $order->requestor_name,
                'start_date' => Carbon::parse($order->start_date)->format('d/m/Y'),
                'start_day' => Carbon::parse($order->start_date)->isoFormat('dddd'),
                'end_date' => Carbon::parse($order->end_date)->format('d/m/Y'),
                'end_day' => Carbon::parse($order->end_date)->isoFormat('dddd'),
                'driver_name' => !empty($order->driver) ? $order->driver->name : 'N/A',
                'registration_no' => !empty($order->vehicle) ? $order->vehicle->registration_no : 'N/A',
                'vehicle_name' => !empty($order->vehicle) ? $order->vehicle->name : 'N/A',
                'approver_one_name' => !empty($order->approverOne) ? $order->approverOne->name : 'N/A',
                'approver_two_name' => !empty($order->approverTwo) ? $order->approverTwo->name : 'N/A',
                'status' => $order->status,
                'created_at' => Carbon::parse($order->created_at)->format('d/m/Y'),
            ];
        }
        return collect($formattedOrderVehicles);
    }

    /**
     * set auto column width
     */
    public function registerEvents(Sheet $sheet)
    {
        $sheet->setAutoSize(true);
    }
}
