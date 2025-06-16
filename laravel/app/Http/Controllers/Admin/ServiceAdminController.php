<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceAdminController extends Controller
{
    public function index() {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create() {
        return view('admin.services.create');
    }

    public function store(Request $request) {
        $request->validate([
            'Description_services' => 'required|string|max:255',
            'Tariff_price' => 'required|numeric',
            'type_services' => 'required|string'
        ]);

        Service::create($request->all());
        return redirect()->route('admin.services.index')->with('success', 'Услуга добавлена.');
    }

    public function edit($id) {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id) {
        $service = Service::findOrFail($id);

        $request->validate([
            'Description_services' => 'required|string|max:255',
            'Tariff_price' => 'required|numeric',
            'type_services' => 'required|string'
        ]);

        $service->update($request->all());
        return redirect()->route('admin.services.index')->with('success', 'Услуга обновлена.');
    }

    public function destroy($id) {
        Service::destroy($id);
        return redirect()->route('admin.services.index')->with('success', 'Услуга удалена.');
    }
}

