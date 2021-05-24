<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketMessage;
use App\Http\Requests\TicketRequest;

class TicketController extends Controller
{
    /**
     * TicketController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:tickets-manage');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tickets = Ticket::latest()->paginate();
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Show the specified resource.
     * @param  \App\Models\Ticket  $ticket
     * @return Response
     */
    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Add a reply to the specific ticket.
     *
     * @param  \App\Http\Requests\TicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $message = TicketMessage::create([
            'user_id'   => auth()->user()->id,
            'ticket_id' => $ticket->id,
            'body'      => $request->input('message'),
        ]);

        if($request->hasfile('attachment'))
        {
            $date = date('Y/m');
            foreach($request->file('attachment') as $key => $attachment)
            {
                $name = Str::random(64);
                if($attachment->storeAs('public/images/attachments/' . $date, $name . '.' . $attachment->extension()))
                {
                    $attachments[] = [
                        'message_id'    => $message->id,
                        'client_name'   => $attachment->getClientOriginalName(),
                        'name'          => $name,
                        'mime'          => $attachment->extension(),
                        'url'           => 'storage/images/attachments/' . $date . '/' . $name . '.' . $attachment->extension(),
                    ];
                }
            }
            TicketAttachment::insert($attachments);
        }
        $this->doneMessage('پیام شما با موفقیت ثبت گردید.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->all();
        $ticket = Ticket::findorFail($id);

        if (isset($data['status'])) {
            $stat = $data['status'];
            $stat = ($stat == 1 ? 1 : 0);
            $ticket->status = $stat;
            $ticket->save();
        }

        if ( isset($data['delete'] ))
            $ticket->delete();

        $this->doneMessage();
        return redirect()->route('admin.tickets.index');
    }
}
