<?php

namespace App\Helpers;

use App\Models\Employee;
use App\Jobs\SentSMSForOTP;
use App\Jobs\SentEmailForOTP;
use Carbon\Carbon;

class Helper {

    public static function sendOtp(string $mobile)
    {
        $employee = Employee::where('mobile', $mobile)->first();
       // $otp = mt_rand(100000,999999);
        $otp = 111111;
        $data = [];
        $data['otp'] = $otp;
        $data['mobile'] = $employee->mobile;
        $data['email'] = $employee->email;
        $data['name'] = $employee->name;

        // //send sms
        // if ($employee->mobile) {
        //     SentSMSForOTP::dispatch($data);
        // }
        //send mail
        if ($employee->email) {
            SentEmailForOTP::dispatch($data);
        }

        //otp update in database
        $carbon = new Carbon;
        $now = $carbon->now();
        $employee->update(['otp' => $otp, 'otp_created_at' => $now]);
        return $otp;
    }

    public static function countDays($year, $month, $ignore)
	{
		$count   = 0;
		$counter = mktime(0, 0, 0, $month, 1, $year);
		while (date("n", $counter) == $month) {
			if (!in_array(date("w", $counter), $ignore)) {
				$count++;
			}
			$counter = strtotime("+1 day", $counter);
		}
		return $count;
	}

	public static function workingDays($startDate, $endDate){
		$begin = strtotime($startDate);
		$end   = strtotime($endDate);
		if ($begin > $end) {
			echo "startdate is in the future! <br />";

			return 0;
		} else {
			$no_days  = 0;
			$weekends = 0;
			while ($begin <= $end) {
				$no_days++; // no of days in the given interval
				$what_day = date("N", $begin);
				// if ($what_day > 6) { // 6 and 7 are weekend days
				// 	$weekends++;
				// };
				$begin += 86400; // +1 day
			};
			$working_days = $no_days - $weekends;

			return $working_days;
		}
	}

	public static function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? '  ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));

        return $Rupees . 'Rs. ';
    }
}
