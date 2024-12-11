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
        if ($record->money_claimed < 50000) {
            if ($record->age < 90) {
                return '<span class="badge badge-success mb-2 me-4">' . number_format($record->money_claimed) . '</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#37AB55" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>';
            } else {
                return '<span class="badge badge-danger mb-2 me-4">' . number_format($record->money_claimed) . '</span><a href="javascript:void(0);" class="danger bs-tooltip" data-bs-placement="top" title="متعثرة"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E7515A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></a>';
            }
        } else {
            return '<span class="badge badge-warning mb-2 me-4">' . number_format($record->money_claimed) . '</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E3A140" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>';
        }
    }

    public static function render_appointment($appointment)
    {
        if ($appointment === 'نعم') {
            return '<span class="badge badge-success">' . $appointment . '</span>';
        } else {
            return '<span class="badge badge-danger">' . $appointment . '</span>';
        }
    }

    public static function render_session($session)
    {
        if ($session > 5) {
            return '<span class="badge badge-danger">' . $session . '</span>';
        } else {
            return '<span class="badge badge-success">' . $session . '</span>';
        }
    }

    public static function render_age($session)
    {
        if ($session > 180) {
            return '<span class="badge badge-danger">' . $session . '</span>';
        } else {
            return '<span class="badge badge-success">' . $session . '</span>';
        }
    }

}
