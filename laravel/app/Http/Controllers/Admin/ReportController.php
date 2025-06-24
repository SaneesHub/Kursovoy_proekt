<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\NetworkDevice;
use App\Models\Service;
use App\Models\ServiceActivation;
use App\Models\Invoice;
use App\Models\Implement;
class ReportController extends Controller
{
    /**
     * Показать таблицу по представлению network_equipment_view
     */
    public function networkEquipment()
    {
        $rows = DB::table('network_equipment_view')->get()->map(fn($row) => (array)$row);
        return view('admin.reports.network', compact('rows'));
    }

    /**
     * Сгенерировать PDF по представлению network_equipment_view
     */
    public function networkEquipmentPdf()
    {
        $rows = DB::table('network_equipment_view')->get()->map(fn($row) => (array)$row);
        $pdf = PDF::loadView('admin.reports.pdf.network', compact('rows'))
            ->setPaper('A4', 'landscape')
            ->setOption('defaultFont', 'dejavu sans');
        return $pdf->download('отчёт_сетевое_оборудование.pdf');
    }

    /**
     * Показать таблицу по представлению connected_services_view
     */
    public function connectedServices()
    {
        $rows = DB::table('connected_services_view')->get()->map(fn($row) => (array)$row);
        return view('admin.reports.connected', compact('rows'));
    }

    /**
     * Сгенерировать PDF по представлению connected_services_view
     */
    public function connectedServicesPdf()
    {
        $rows = DB::table('connected_services_view')->get()->map(fn($row) => (array)$row);
        $pdf = PDF::loadView('admin.reports.pdf.connected', compact('rows'))
            ->setPaper('A4', 'landscape')
            ->setOption('defaultFont', 'dejavu sans');
        return $pdf->download('отчёт_подключённые_услуги.pdf');
    }
    public function editNetwork($id)
    {
        $device = NetworkDevice::findOrFail($id);
        $services = Service::all();
        return view('admin.reports.edit-network', compact('device', 'services'));
    }

    public function updateNetwork(Request $request, $id)
    {
        $request->validate([
            'type_device' => 'required|string',
            'id_services' => 'nullable|exists:services,id_services'
        ]);

        $device = NetworkDevice::findOrFail($id);
        $device->type_device = $request->type_device;
        $device->save();

        // Обновим implements
        if ($request->filled('id_services')) {
            DB::table('implements')->updateOrInsert(
                ['id_device' => $device->id_device],
                ['id_services' => $request->id_services]
            );
        }

        return redirect()->route('admin.reports.network')->with('success', 'Запись обновлена');
    }
    public function destroy($mac)
    {
        $mac = trim($mac); // на случай пробелов

        // Проверяем количество записей с этим MAC-адресом
        $macCount = DB::table('network_device')->where('mac_address', $mac)->count();

        // Получаем адрес подключения из представления
        $row = DB::table('network_equipment_view')->where('mac_address', $mac)->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Запись не найдена.');
        }

        if ($macCount === 1 && $row->{'Адрес подключения'} === 'Не подключено') {
            // Удаляем оборудование
            DB::table('network_device')->where('mac_address', $mac)->delete();
        } else {
            // Удаляем подключение, если оно есть
            DB::table('service_activation')
                ->where('address_connection', $row->{'Адрес подключения'})
                ->whereIn('id_services', function ($q) use ($mac) {
                    $q->select('id_services')
                        ->from('implements')
                        ->whereIn('id_device', function ($sub) use ($mac) {
                            $sub->select('id_device')
                                ->from('network_device')
                                ->where('mac_address', $mac);
                        });
                })
                ->delete();
        }

        return redirect()->route('admin.reports.network')->with('success', 'Запись успешно удалена.');
    }
    // --- Подключённые услуги ---
    public function editService($id)
    {
        $activation = ServiceActivation::with('service')->findOrFail($id);
        $services = Service::all();
        $devices = NetworkDevice::all();
        return view('admin.reports.edit-service', compact('activation', 'services', 'devices'));
    }

    public function updateService(Request $request, $id)
    {
        $request->validate([
            'id_services' => 'required|exists:services,id_services'
        ]);

        $activation = ServiceActivation::findOrFail($id);
        $activation->id_services = $request->id_services;
        $activation->save();
        $activation->update([
            'id_services' => $request->input('id_services'),
            'address_connection' => $request->input('address_connection'),
            'date_disconnection' => $request->input('date_disconnection'),
        ]);

        // Если нужно обновить связь с оборудованием:
        if ($request->filled('id_device')) {
            // Например, обновить implements или иное связывание
            Implement::updateOrCreate(
                ['id_services' => $activation->id_services],
                ['id_device' => $request->input('id_device')]
                );
        }

        // Обновим счёт, если есть
        Invoice::where('id_connection', $activation->id_connection)
            ->update(['id_services' => $request->id_services]);

        return redirect()->route('admin.reports.services')->with('success', 'Услуга обновлена');
    }

    public function destroyService($id)
    {
        Invoice::where('id_connection', $id)->delete();
        ServiceActivation::where('id_connection', $id)->delete();
        return redirect()->route('admin.reports.services')->with('success', 'Услуга удалена');
    }
}
