<?php
/**
 * Created by PhpStorm.
 * User: darryldecode
 * Date: 4/2/2018
 * Time: 8:40 AM
 */

namespace App\Http\Controllers;

use App\Models\User;

class SinglePageController extends Controller
{
    public function displaySPA()
    {
        /**
         * @var User $currentUser
         */
        $currentUser = \Auth::user();
        view()->share('nav', $currentUser);

        $layout = 'layouts.' . $currentUser->role;
        return view($layout);
    }
}