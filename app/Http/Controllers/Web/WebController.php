<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medic;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class WebController extends Controller
{
    /**
     *
     * @return Factory|View
     */
    public function index()
    {
        $doctors = Medic::distinct()->take(6)->get();
        $contactDetails = Setting::all()->pluck('value', 'key')->toArray();
        $testimonials = Testimonial::all();

        return view(
            'web.home.index',
            compact('doctors', 'contactDetails', 'testimonials')
        );
    }

    /**
     * @return Factory|View
     */
    public function demo()
    {
        return \view('web.demo.index');
    }

    /**
     * @return Factory|View
     */
    public function modulesOfHms()
    {
        return \view('web.modules_of_hms.index');
    }
}
