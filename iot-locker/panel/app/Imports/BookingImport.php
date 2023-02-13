<?php

namespace App\Imports;

use App\Helpers\ValidateNumber;
use App\Models\Booking;
use App\Models\EventLog;
use Carbon\Carbon;
use EventLogHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class BookingImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     dd ($row);
    //     return new Booking([

    //     ]);
    // }

    public $dataChangeCounter = 0;

    public function collection(Collection $rows)
    {
        // dd ($rows[0]);
        $this->columns = [];
        $this->errorCheck = 0;
        // return "Format Not match";
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                // dd($row[0]);
                foreach ($row as $idx => $col) {
                    $this->columns[$row[$idx]] = $idx;
                }
                // $this->columns = [
                //     $row[0] => 0,
                //     $row[1] => 1,
                //     $row[2] => 2,
                //     $row[3] => 3,
                //     $row[4] => 4,
                //     $row[5] => 5,
                //     $row[6] => 6,
                //     $row[7] => 7,
                // ];

                // check 
                if (!isset($this->columns["parcel_number"])) {
                    $this->errorCheck = 1;
                    Session::put('errorCheckMessage', 'Invalid File format. Try export file from this page');
                }
                continue;
            }
            if ($this->errorCheck) {
                continue;
            }
            $this->updateBooking($row);
        }
        // dd ($rows[0]);
        // dd($this->dataChangeCounter);
        Session::put('dataChangeCounter', $this->dataChangeCounter);
    }

    public function updateBooking($bookingWithCustomerNumber)
    {

        // dd($this->columns);
        // dd($bookingWithCustomerNumber);
        $response = ValidateNumber::validNumber($bookingWithCustomerNumber[$this->columns['customer_number']]);
        $response = json_decode($response->getContent());
        // dd($response->formatted_number);

        if ($response->code != 200) {
            return;
        }
        $customerNumber = $response->formatted_number;
        $exsistingBooking = Booking::where("parcel_no", $bookingWithCustomerNumber[$this->columns['parcel_number']])
            ->whereNull("customer_no")
            ->whereNull("customer_sms_key")
            ->latest()
            ->first();
        if (!is_null($exsistingBooking)) {
            // dd($exsistingBooking);
            $exsistingBooking->customer_no = $customerNumber;
            $exsistingBooking->customer_no_set_at = Carbon::now();
            $exsistingBooking->save();
            $this->dataChangeCounter++;

            // Create Event Log
            try {
                $formatedData = EventLogHelper::formatData($exsistingBooking);
                $eventLog = EventLogHelper::createLog($formatedData);
            } catch (\Throwable $th) {
                //throw $th;
                return;
            }
        }

        // dd($exsistingBooking);
    }
}
