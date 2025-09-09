<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() {
        return Notification::all();
    }

    public function store(Request $request) {
        return Notification::create($request->all());
    }

    public function show($id) {
        return Notification::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $notif = Notification::findOrFail($id);
        $notif->update($request->all());
        return $notif;
    }

    public function destroy($id) {
        return Notification::destroy($id);
    }
}
