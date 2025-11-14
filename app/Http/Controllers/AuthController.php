<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Verificar se o usuário existe
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email não encontrado.']);
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => 'Link de redefinição enviado para seu email!'])
                : back()->withErrors(['email' => 'Erro ao enviar email. Tente novamente.']);
                
        } catch (\Exception $e) {
            \Log::error('Email error: ' . $e->getMessage());
            
            // Se estiver em desenvolvimento, mostrar link direto
            if (app()->environment('local')) {
                return back()->with([
                    'status' => 'Em desenvolvimento: Use o link abaixo para redefinir sua senha.',
                    'dev_reset_link' => route('password.reset', ['token' => 'dev-token', 'email' => $request->email])
                ]);
            }
            
            return back()->withErrors([
                'email' => 'Serviço de email temporariamente indisponível. Tente novamente mais tarde.'
            ]);
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        // Em desenvolvimento, permitir qualquer token
        if (app()->environment('local') && $token === 'dev-token') {
            return view('auth.reset-password', [
                'token' => $token,
                'email' => $request->email
            ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            // Em desenvolvimento, aceitar token qualquer
            if (app()->environment('local') && $request->token === 'dev-token') {
                $user = User::where('email', $request->email)->first();
                
                if (!$user) {
                    return back()->withErrors(['email' => 'Usuário não encontrado.']);
                }

                $user->password = Hash::make($request->password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));

                return redirect()->route('login')->with('status', 'Senha redefinida com sucesso!');
            }

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', 'Senha redefinida com sucesso!')
                : back()->withErrors(['email' => 'Token inválido ou expirado.']);
                
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Erro ao redefinir senha. Tente novamente.']);
        }
    }
}