<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller {
    public function index(Request $request) {
        $type = $request->get('type', 'frontend');
        $menus = Menu::where('type', $type)->topLevel()->with('children')->get();
        return view('admin.menus.index', compact('menus', 'type'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'     => 'required',
            'url'       => 'nullable',
            'target'    => 'required|in:_self,_blank',
            'parent_id' => 'nullable|exists:menus,id',
            'type'      => 'required|in:frontend,admin',
            'icon'      => 'nullable',
        ]);

        $position = Menu::where('parent_id', $request->parent_id)
            ->where('type', $request->type)
            ->count();

        Menu::create([
            'title'     => $request->title,
            'url'       => $request->url,
            'target'    => $request->target,
            'parent_id' => $request->parent_id,
            'type'      => $request->type,
            'icon'      => $request->icon,
            'position'  => $position,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Menu item added successfully.');
    }

    public function update(Request $request, Menu $menu) {
        $request->validate([
            'title'  => 'required',
            'url'    => 'nullable',
            'target' => 'required|in:_self,_blank',
            'icon'   => 'nullable',
        ]);

        $menu->update($request->only('title', 'url', 'target', 'is_active', 'icon'));

        return redirect()->back()->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu) {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request) {
        $order = $request->order;
        $type = $request->get('type', 'frontend');

        $this->updateOrder($order, null, $type);

        return response()->json(['status' => 'success']);
    }

    private function updateOrder($items, $parentId = null, $type = 'frontend') {
        foreach ($items as $index => $itemData) {
            $menu = Menu::find($itemData['id']);
            if ($menu) {
                $menu->update([
                    'position'  => $index,
                    'parent_id' => $parentId,
                    'type'      => $type,
                ]);

                if (isset($itemData['children']) && ! empty($itemData['children'])) {
                    $this->updateOrder($itemData['children'], $menu->id, $type);
                }
            }
        }
    }
}
