<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:50'],
            'no_ktp' => ['required', 'string', 'max:255'],
        ]);

        // Cek apakah pasien dengan no_ktp tersebut sudah ada
        $existingPatient = User::where('no_ktp', $request->no_ktp)->first();

        if ($existingPatient) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Generate No RM dengan format RM{tahun}{bulan}-urutan
        $currentYearMonth = date('Ym'); // Format: 202506 untuk Juni 2025

        // Hitung jumlah pasien yang terdaftar dengan tahun dan bulan yang sama
        $patientCount = User::where('no_rm', 'like', 'RM' . $currentYearMonth . '-%')->count();

        // Buat no_rm dengan format RM{tahun}{bulan}-urutan
        $no_rm = 'RM' . $currentYearMonth . '-' . str_pad($patientCount + 1, 3, '0', STR_PAD_LEFT);

        // Buat user baru
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien',
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,
            'no_rm' => $no_rm, // Nomor RM yang terurut dengan format yang benar
        ]);

        // Trigger event Registered
        event(new Registered($user));

        // Login user yang baru terdaftar
        Auth::login($user);

        // Redirect ke dashboard pasien
        return redirect(route('pasien.dashboard', absolute: false));
    }
}
