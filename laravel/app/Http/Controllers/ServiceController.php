<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceActivation;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index($type = null)
    {
        if ($type) {
            $services = Service::where('type_services', $type)->get();
        } else {
            $services = Service::all(); // или [] если нужно скрыть все
        }

        return view('services.list', compact('services', 'type'));
    }
    public function internet() {
        $services = Service::where('type_services', 'Домашний интернет')->get();
        return view('services.internet', compact('services'));
    }

    public function tv() {
        $services = Service::where('type_services', 'Спутниковое ТВ')->get();
        return view('services.tv', compact('services'));
    }

    public function mobile() {
        $services = Service::where('type_services', 'Мобильные услуги')->get();
        return view('services.mobile', compact('services'));
    }
    public function showConnectForm($id)
    {
        $service = Service::findOrFail($id);
        return view('services.connect', compact('service'));
    }

    public function subscribe(Request $request, $id)
    {
        $validated = $request->validate([
            'name_guest' => 'required|string|max:255',
            'email_guest' => 'required|email|max:255',
            'address_connection' => 'required|string|max:500'
        ]);

        $user = auth()->user();
        $service = Service::findOrFail($id);

        ServiceActivation::create([
            'id_services' => $service->id_services,
            'id_user' => $user->id_user,
            'id_role' => $user->id_role,
            'name_guest' => $validated['name_guest'],
            'email_guest' => $validated['email_guest'],
            'address_connection' => $validated['address_connection'],
            'date_connection' => now(),
            'date_disconnection' => now()->addMonth()
        ]);

        return redirect()->route('dashboard')
                    ->with('success', 'Услуга "'.$service->description_services.'" успешно подключена!');
    }
    public function disconnect($id)
    {
        $activation = ServiceActivation::findOrFail($id);

        // Проверяем, что услуга принадлежит текущему пользователю
        if ($activation->id_user != Auth::id()) {
            abort(403, 'Вы не можете отключить эту услугу.');
        }

        $activation->delete();

        return redirect()->route('profile.services')->with('success', 'Услуга успешно отключена.');
    }

}

