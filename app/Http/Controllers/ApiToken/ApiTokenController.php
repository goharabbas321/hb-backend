<?php

namespace App\Http\Controllers\ApiToken;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function index()
    {
        return view('pages.api_tokens.index', [
            'tokens' => Auth::user()->tokens,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        $token = $request->user()->createToken($request->name, $request->permissions)->plainTextToken;

        return redirect()->route('api-tokens.index', ['token' => $token])->withNotify([['success', __('messages.api_tokens.create.response.success')]]);
    }

    public function update(Request $request, $tokenId)
    {
        /*$token = $request->user()->tokens()->findOrFail($tokenId);

        $request->validate([
            'permissions' => 'array',
        ]);

        $token->forceFill([
            'abilities' => $request->permissions,
        ])->save();

        return redirect()->route('api-tokens.index')->withNotify([['success', __('API token updated successfully.')]]);*/
    }

    public function destroy(Request $request, $tokenId)
    {
        $request->user()->tokens()->findOrFail($tokenId)->delete();

        return redirect()->route('api-tokens.index')->withNotify([['success', __('messages.api_tokens.delete.response.success')]]);
    }
}
