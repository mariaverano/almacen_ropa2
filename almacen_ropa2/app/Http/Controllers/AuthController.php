<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $user = Usuario::where('correo', $request->correo)->first();

        if (!$user) {
            return back()->withErrors(['correo' => 'Credenciales inválidas'])->withInput();
        }

        $inputPass = $request->contrasena;
        $stored = $user->contrasena;

        $ok = false;
        // Intentar verificar hash, si no, comparar directamente (por compatibilidad)
        if (password_verify($inputPass, $stored)) {
            $ok = true;
        } elseif ($inputPass === $stored) {
            $ok = true;
        }

        if (!$ok) {
            return back()->withErrors(['contrasena' => 'Credenciales inválidas'])->withInput();
        }

        // Guardar en sesión
        session([
            'usuario_id' => $user->id_usuario,
            'usuario_rol' => $user->rol,
            'usuario_nombre' => $user->nombre,
        ]);

        // Redirigir según rol
        if ($user->rol === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('shop.index'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['usuario_id', 'usuario_rol', 'usuario_nombre']);
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
