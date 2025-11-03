<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    /**
     * Show the forget password form (step 1: enter email).
     */
    public function showForgetForm()
    {
        return view('auth.forget-password');
    }

    /**
     * Handle email submission and show security question.
     */
    public function submitEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->security_question) {
            return back()->with('error', 'No security question found for this account. Please contact administrator.');
        }

        // Store email in session for next step
        session(['forget_password_email' => $request->email]);

        return view('auth.verify-security-question', [
            'email' => $request->email,
            'security_question' => $user->security_question,
        ]);
    }

    /**
     * Verify security answer and show reset password form.
     */
    public function verifySecurityAnswer(Request $request)
    {
        $request->validate([
            'security_answer' => ['required', 'string'],
        ]);

        $email = session('forget_password_email');

        if (!$email) {
            return redirect()->route('password.forget')->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.forget')->with('error', 'User not found.');
        }

        // Verify security answer (case-insensitive, trimmed)
        $providedAnswer = strtolower(trim($request->security_answer));
        $hashedAnswer = $user->security_answer;

        if (!Hash::check($providedAnswer, $hashedAnswer)) {
            return back()->with('error', 'Incorrect security answer. Please try again.')
                        ->withInput();
        }

        // Store email in session for password reset
        session(['forget_password_email' => $email, 'security_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    /**
     * Show the reset password form.
     */
    public function showResetForm()
    {
        if (!session('forget_password_email') || !session('security_verified')) {
            return redirect()->route('password.forget')->with('error', 'Session expired. Please start again.');
        }

        return view('auth.reset-password');
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $email = session('forget_password_email');

        if (!$email || !session('security_verified')) {
            return redirect()->route('password.forget')->with('error', 'Session expired. Please start again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.forget')->with('error', 'User not found.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session
        session()->forget(['forget_password_email', 'security_verified']);

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
    }
}

