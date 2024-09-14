<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserActivationController extends Controller
{
    public function showActivationForm()
    {
        return view('auth.activate');
    }

    public function sendActivationEmail(Request $request)
    {
        // Validation de l'email
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Récupérer l'utilisateur
        $user = User::where('email', $request->email)->first();

        // Générer un jeton
        $token = Str::random(60);

        // Stocker le jeton dans la base de données avec expiration
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token, // Non hashé pour comparaison
                'created_at' => now(),
            ]
        );

        // Générer un lien d'activation
        $activationLink = route('activate.token', ['token' => $token, 'email' => $user->email]);

        // Envoyer l'e-mail d'activation
        Mail::to($user->email)->send(new ActivationMail($user, $activationLink));

        return redirect()->route('login')->with('status', 'Un lien d\'activation a été envoyé à votre email.');
    }

    public function showSetPasswordForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.set_password', ['email' => $email, 'token' => $token]);
    }

    public function setPassword(Request $request, $token)
    {
        // Validation du nouveau mot de passe
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $email = $request->query('email');

        // Récupérer le jeton de la base de données
        $reset = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$reset) {
            return redirect()->route('activate.form')->withErrors(['email' => 'Jeton invalide ou expiré']);
        }

        // Comparaison directe des jetons
        if ($reset->token !== $token || $this->tokenExpired($reset->created_at)) {
            return redirect()->route('activate.form')->withErrors(['email' => 'Jeton invalide ou expiré']);
        }

        // Trouver l'utilisateur associé à l'email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('activate.form')->withErrors(['email' => 'Utilisateur non trouvé']);
        }

        // Mettre à jour le mot de passe de l'utilisateur (réinitialisation)
        $user->password = Hash::make($request->password);
        $user->save();

        // Supprimer le jeton utilisé
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')->with('status', 'Votre mot de passe a été changé avec succès ! Vous pouvez maintenant vous connecter.');
    }

    /**
     * Vérifie si le jeton a expiré (par exemple, après 60 minutes).
     */
    protected function tokenExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addMinutes(60)->isPast();
    }
}
