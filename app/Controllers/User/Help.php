<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\LibrarySettingsModel;

class Help extends BaseController
{
    public function display()
    {
        $library_settings_model = new \App\Models\LibrarySettingsModel();

        $library_settings = $library_settings_model->first();

        return view('user/help', [
            'library_settings' => $library_settings
        ]);
    }
}
