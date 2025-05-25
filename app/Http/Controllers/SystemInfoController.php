<?php
namespace App\Http\Controllers;

use App\Models\SystemInfo;
use Illuminate\Http\Request;

class SystemInfoController extends Controller
{
    public function index()
    {
        $infos = SystemInfo::all();
        return view('system_info.index', compact('infos'));
    }

    public function create()
    {
        return view('system_info.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('logos'), $filename);
            $data['logo'] = $filename;
        }
        SystemInfo::create($data);
        return redirect()->route('system-info.index')->with('success', 'System info added!');
    }

    public function edit(SystemInfo $system_info)
    {
        return view('system_info.edit', compact('system_info'));
    }

    public function update(Request $request, SystemInfo $system_info)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('logos'), $filename);
            $data['logo'] = $filename;
        }

        $system_info->update($data);
        return redirect()->route('system-info.index')->with('success', 'Updated successfully!');
    }

    public function destroy(SystemInfo $system_info)
    {
        $system_info->delete();
        return redirect()->route('system-info.index')->with('success', 'Deleted!');
    }
}
