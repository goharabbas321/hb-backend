<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::find(Auth::id());
        $google2fa = new Google2FA();

        // Generate a new secret key if it doesn't exist
        if (!$user->two_factor_secret) {
            $user->two_factor_secret = encrypt($google2fa->generateSecretKey());
            $user->two_factor_recovery_codes = encrypt(json_encode($this->generateRecoveryCodes()));
            $user->save();
        }

        // Generate the QR Code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            getJsonSetting('system_settings', 'name'),
            $user->email,
            decrypt($user->two_factor_secret)
        );

        // Use BaconQrCode to generate the QR code
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($qrCodeUrl);

        $sessions = getSessions(Auth::user()->id);
        $currentSessionId = session()->getId();

        return view('pages.profile.index', compact('user', 'qrCode', 'sessions', 'currentSessionId'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id), 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name' => 'required|string|max:255',
            'phone' => ['required', Rule::unique('users')->ignore($user->id), 'regex:/^\d{11}$/'],
            'country' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'language' => 'required|string|max:10',
            'currency' => 'required|string|max:10',
            'time_zone' => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user to the database

        $user->username = $validatedData['username'];
        // Check if the email has changed
        if ($user->email !== $validatedData['email']) {
            // Update the email but mark it as unverified
            $user->email = $validatedData['email'];
            $user->email_verified_at = null; // Mark as unverified

            // Trigger email verification
            $user->sendEmailVerificationNotification();
        } else {
            $user->email = $validatedData['email'];
        }
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->user_information = json_encode(['country' => $validatedData['country'], 'address' => $validatedData['address'] ?? null]);
        $user->language = $validatedData['language'];
        $user->currency = $validatedData['currency'];
        $user->time_zone = $validatedData['time_zone'];

        // Handle the file upload
        if ($request->hasFile('profile_image')) {
            // Generate a unique name using username and timestamp
            $filename = $validatedData['username'] . '_' . time() . '.' . $request->file('profile_image')->getClientOriginalExtension();

            // Save the file to the specified directory
            $path = $request->file('profile_image')->storeAs('profile-photos', $filename, 'public');

            // Save the file path to the database or perform other actions
            $user->profile_photo_path = 'profile-photos/' . $filename;
        }

        $user->update();

        return redirect()->back()->withNotify([['success', __('messages.profile.information.response.success')]]);
    }

    public function changePassword(Request $request, User $user)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed', // Ensure newPassword matches confirmPassword
        ]);

        // Check if the current password is correct
        if (!Hash::check($validatedData['currentPassword'], $user->password)) {
            return back()->withErrors(['currentPassword' => __('messages.profile.change_password.response.error')]);
        }

        // Update the password
        $user->password = Hash::make($validatedData['newPassword']);
        $user->save();

        // Flash success message to session
        session()->flash('alert', [
            'type' => 'success',
            'message' => __('messages.profile.change_password.response.success')
        ]);

        return redirect()->back()->withNotify([['success', __('messages.profile.change_password.response.success')]]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $google2fa = new Google2FA();
        $user = User::find(Auth::id());

        // Verify the OTP
        if ($google2fa->verifyKey(decrypt($user->two_factor_secret), $request->otp)) {
            $user->two_factor_confirmed_at = now();
            $user->save();

            return redirect()->back()->withNotify([['success', __('messages.profile.2fa.response.enable.success')]]);
        }

        /*$user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();*/

        return redirect()->back()->withErrors(['otp' => __('messages.profile.2fa.response.enable.error')]);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = User::find(Auth::id());

        // Check the password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => __('messages.profile.2fa.response.disable.error')]);
        }

        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return redirect()->route('dashboard')->withNotify([['success', __('messages.profile.2fa.response.disable.success')]]);
    }

    protected function generateRecoveryCodes()
    {
        return array_map(function () {
            return Str::random(10) . '-' . Str::random(10);
        }, range(1, 8));
    }

    public function logoutOtherSessions(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors(['password' => __('messages.profile.sessions.response.error')]);
        }

        $currentSessionId = session()->getId();
        $user = $request->user();

        // Logout all tokens except the current one
        $user->tokens->where('id', '!=', $currentSessionId)->each(function ($token) {
            $token->delete();
        });

        // Delete other session records except the current one
        $this->deleteOtherSessionRecords($user->id, $currentSessionId);

        return redirect()->route('dashboard')->withNotify([['success', __('messages.profile.sessions.response.success')]]);
    }

    private function deleteOtherSessionRecords($userId, $currentSessionId)
    {
        DB::table('sessions')->where('user_id', $userId)->where('id', '!=', $currentSessionId)->delete();
    }
}
