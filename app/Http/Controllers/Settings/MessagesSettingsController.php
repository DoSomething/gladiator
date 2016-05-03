<?php

namespace Gladiator\Http\Controllers\Settings;

use Gladiator\Models\MessageSetting;
use Gladiator\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessagesSettingsController extends Controller
{
    /**
     * Create new MessagesSettingsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $messages = MessageSetting::all();

        return view('settings.messages.edit', compact('messages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // @TODO: this is kinda gross and can likely be combined with methods in MessageRepository @_@
        $input = $request->all();
        $messages = $input['messages'];

        foreach ($messages as $type => $items) {
            foreach ($items as $key => $data) {
                $data['type'] = $type;
                $data['key'] = $key;

                $message = MessageSetting::where('type', $type)->where('key', $key)->first();

                $attributes = $message->getFillable();

                foreach ($attributes as $attribute) {
                    if (isset($data[$attribute])) {
                        $message->{$attribute} = $data[$attribute];
                    }
                }

                $message->save();
            }
        }

        return redirect()->route('settings.index')->with('status', 'Default messages have been updated!');
    }
}
