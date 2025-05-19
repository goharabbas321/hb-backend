<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'setting::messages.settings.modules.heading';

        $modules = Module::all(); // Get all modules, whether enabled or disabled

        usort($modules, function ($a, $b) {
            return $a->getPriority() <=> $b->getPriority(); // Ascending order (0 = highest priority)
        });

        $moduleInfo = [];

        foreach ($modules as $module) {
            $modulePath = module_path($module->getName());
            $moduleJsonPath = $modulePath . '/module.json';

            $info = [
                'name' => $module->getName(),
                'enabled' => $module->isEnabled() ? 'Enabled' : 'Disabled',
                'priority' => null,
                'description' => null,
            ];

            // Fetch priority and description from module.json if it exists
            if (File::exists($moduleJsonPath)) {
                $moduleJson = json_decode(File::get($moduleJsonPath), true);
                $info['priority'] = $moduleJson['priority'] ?? 'N/A';
                $info['description'] = $moduleJson['description'] ?? 'No description';
            }

            $moduleInfo[] = $info;
        }

        return view('setting::modules', compact('page_title', 'moduleInfo'));
    }

    /**
     * Toggle module status (enable/disable)
     */
    public function update($name)
    {
        try {
            $module = Module::find($name);

            if (!$module) {
                return redirect()->route('settings.modules.index')->withNotify([['error', __('setting::messages.settings.modules.not_found')]]);
            }

            if ($module->isEnabled()) {
                // Disable the module
                Module::disable($name);
            } else {
                // Enable the module
                Module::enable($name);
            }

            clearCache();

            return redirect()->route('settings.modules.index')->withNotify([['success', __('messages.response.update.success')]]);
        } catch (\Exception $e) {
            return redirect()->route('settings.modules.index')
                ->with('error', __('setting::messages.settings.modules.toggle_error', ['error' => $e->getMessage()]));
        }
    }
}
