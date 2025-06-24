<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'id_role' => 'required|exists:Role,ID_role',
        ]);
        $user->id_role = $request->ID_role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Роль пользователя обновлена.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Пользователь удалён.');
    }
    public function userTariffs($id)
    {
        $user = User::findOrFail($id);

        $connections = DB::table('service_activation AS sa')
            ->join('services AS s', 'sa.id_services', '=', 's.id_services')
            ->leftJoin('invoice AS i', 'sa.id_connection', '=', 'i.id_connection')
            ->where('sa.id_user', $id)
            ->select('sa.*', 's.description_services', 's.tariff_price', 'i.status_payment')
            ->get();
        foreach ($connections as $conn) {
        $conn->date_connection = \Carbon\Carbon::parse($conn->date_connection);
        if ($conn->date_disconnection) {
            $conn->date_disconnection = \Carbon\Carbon::parse($conn->date_disconnection);
        }
    }

        return view('admin.users.tariffs', compact('user', 'connections'));
    }
}
