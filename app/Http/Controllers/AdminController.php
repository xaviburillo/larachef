<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function userList() {

        $users = User::orderBy('name', 'ASC')->paginate(10);

        return view('admin.users.list', ['users' => $users]);
    }

    public function userShow(User $user) {

        $user->with('recetas');
        $valoracionesEliminadas = $user->valoraciones()->onlyTrashed()->get();

        return view('admin.users.show', ['user' => $user, 'valoracionesEliminadas' => $valoracionesEliminadas]);
    }

    public function userSearch(Request $request) {
        $request->validate(['name' => 'max:32', 'email' => 'max:32']);

        $name = $request->name ?? '';
        $email = $request->email ?? '';

        $users = User::orderBy('name', 'ASC')
            ->where('name', 'like', "%$name%")
            ->where('email', 'like', "%$email%")
            ->paginate(10)
            ->appends(['name' => $name, 'email' => $email]);

        return view('admin.users.list', ['users' => $users]);
    }

    public function setRole(Request $request) {

        $role = Role::find($request->role_id);
        $user = User::find($request->user_id);

        if ($request->user()->cant('addRole', $user)) {
            return back()
                ->withErrors("No se pudo añadir el rol $role->role a $user->name. Un usuario administrador no puede añadirse roles.");
        }

        try {
            $user->roles()->attach($role->id);

            return back()
                ->with('success', "Rol $role->role añadido a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()
                ->withErrors("No se pudo añadir el rol $role->role a $user->name. Es posible que ya lo tenga.");
        }
    }

    public function removeRole(Request $request) {

        $role = Role::find($request->role_id);
        $user = User::find($request->user_id);

        if ($request->user()->cant('removeRole', $user)) {
            return back()
                ->withErrors("No se pudo quitar el rol $role->role a $user->name. Un usuario administrador no puede quitarse roles.");
        }

        try {
            $user->roles()->detach($role->id);

            return back()
                ->with('success', "Rol $role->role quitado a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()
                ->withErrors("No se pudo quitar el rol $role->role a $user->name.");
        }
    }

    public function bloquear(Request $request, User $user) {

        if ($request->user()->cant('ban', $user)) {
            return back()
                ->withErrors("No se pudo bloquear a $user->name. Es posible que estés intentando bloquearte a ti mismo.");
        }

        try {
            $user->roles()->attach(5, [
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()
                ->with('success', "Usuario $user->email bloqueado correctamente.");
        } catch (QueryException $e) {
            return back()
                ->withErrors("No se pudo bloquear a $user->name. Es posible que ya esté bloqueado.");
        }
    }
    
    public function desbloquear(Request $request, User $user) {

        if ($request->user()->cant('unban', $user)) {
            return back()
                ->withErrors("No se pudo desbloquear a $user->name. Es posible que estés intentando desbloquearte a ti mismo.");
        }

        try {
            $user->roles()->detach(5);

            return back()
                ->with('success', "Usuario $user->email desbloqueado correctamente.");
        } catch (QueryException $e) {
            return back()
                ->withErrors("No se pudo desbloquear a $user->name. Es posible que ya esté desbloqueado.");
        }
    }
}
