<?php

namespace App\Http\Controllers\Users\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Users\Settings\PasswordValidator;

/**
 * Class SettingsController 
 * 
 * @package App\Http\Controllers\Users\Profile
 */
class SettingsController extends Controller
{
    /**
     * Create new SettingsController constructor 
     * 
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Get the settings overview page for the authenticated user. 
     * 
     * @param  string|null $type Type of of settings the user wants to change. 
     * @return Renderable 
     */
    public function index(string $type = null): Renderable
    {
        $user = $this->getAuthenticatedUser();
        
        switch ($type) { // Display the settings page based on the given type in the URI.
            case 'security':    return view('users.settings.security', compact('user'));
            default:            return view('users.information', compact('user'));
        }
    }

    /**
     * Method for up-dating his security settings in the application. 
     * 
     * @param  PasswordValidator $input The form request class that handles the validation.
     * @return RedirectResponse
     */
    public function updateSecurity(PasswordValidator $input): RedirectResponse
    {
        if ($this->getAuthenticatedUser()->update(['password' => $input->password])) {
            flash('Your account security has been updated.')->important();
        }

        return redirect()->route('profile.settings', ['type' => 'security']);
    }
}