<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceAdminController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'internetServices' => Service::where('type_services', 'Домашний интернет')->get(),
            'tvServices' => Service::where('type_services', 'Спутниковое ТВ')->get(),
            'mobileServices' => Service::where('type_services', 'Мобильные услуги')->get()
        ]);
    }

    public function create() {
        return view('admin.services.create');
    }

    public function edit($id) {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description_services' => 'required|string|max:255',
            'type_services' => 'required|string',
            'tariff_price' => 'required|numeric'
        ]);

        Service::create($request->all());

        return redirect()->route('home')->with('success', 'Услуга успешно добавлена!');
    }

    public function update(Request $request, $id) {
        $service = Service::findOrFail($id);

        $request->validate([
            'description_services' => 'required|string|max:255',
            'tariff_price' => 'required|numeric',
            'type_services' => 'required|string'
        ]);

        $service->update($request->all());
        return redirect()->route('home')->with('success', 'Услуга обновлена.');
    }

    public function destroy($id) {
        Service::destroy($id);
        return redirect()->route('home')->with('success', 'Услуга удалена.');
    }
}

