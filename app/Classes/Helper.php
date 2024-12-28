<?php
namespace App\Classes;

class Helper {
    public static function easy_status_class($record)
    {
        if ($record->money_claimed < 50000) {
            if ($record->age < 90) {
                return 'table-success';
            } else {
                return 'table-warning';
            }
        }
        return 'table-danger';
    }
    public static function render_easy_status($record)
    {
        $money = $record->money_claimed;
        $age = $record->age;

        if ($money > 50000 || $money == 0) {
            return '<td class="cell-abu">' . number_format($money) . '</td>';
        } else {
            if ($age > 90) {
                return '<td class="cell-danger">' . number_format($money) . '</td>';
            } else {
                return '<td class="cell-success">' . number_format($money) . '</td>';
            }
        }
    }

    public static function render_appointment($appointment)
    {
        if ($appointment === 'نعم') {
            return '<td class="cell-success">' . $appointment . '</td>';
        } else {
            return '<td class="cell-danger">' . $appointment . '</td>';
        }
    }

    public static function render_session($session)
    {
        if ($session <= 3) {
            return '<td class="cell-success">' . $session . '</td>';
        } elseif ($session == 4) {
            return '<td class="cell-warning">' . $session . '</td>';
        } else {
            return '<td class="cell-danger">' . $session . '</td>';
        }
    }

    public static function render_age($session)
    {
        if ($session <= 150) {
            return '<td class="cell-success">' . $session . '<span style="float: left;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#257723" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg></span></td>';
        } elseif ($session <= 179) {
            return '<td class="cell-warning">' . $session . '<span style="float: left;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#956239" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></span></td>';
        } else {
            return '<td class="cell-danger">' . $session . '<span style="float: left"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#832222" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg></span> </td>';
        }
    }

}
