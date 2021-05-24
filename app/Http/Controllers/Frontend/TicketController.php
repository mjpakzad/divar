<?php

namespace App\Http\Controllers\Frontend;

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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->latest()->paginate();
        return view('frontend.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('frontend.tickets.create');
    }

    /**
     * Store a new ticket in the resource.
     * @param  \App\Http\Requests\TicketRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TicketRequest $request)
    {
        $ticket = Ticket::create([
            'title'         => $request->input('title'),
            'user_id'       => auth()->user()->id,
            'slug'          => uniqid(auth()->user()->id),
            'priority'      => $request->input('priority'),
            'status'        => 1,
        ]);

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
                        'message_id' => $message->id,
                        'client_name'   => $attachment->getClientOriginalName(),
                        'name'          => $name,
                        'mime'          => $attachment->extension(),
                        'url'           => 'storage/images/attachments/' . $date . '/' . $name . '.' . $attachment->extension(),
                    ];
                }
            }
            TicketAttachment::insert($attachments);
        }
        $this->doneMessage("تیکت شما به شماره $ticket->slug ایجاد شد");
        return redirect()->route('frontend.tickets.index');
    }

    /**
     * Show the specified resource.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function show(Ticket $ticket)
    {
        abort_if ($ticket->user_id !== auth()->id(), 403, 'شما اجازه دسترسی به این تیکت را ندارید.');
        return view('frontend.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('ticket::edit');
    }

    /**
     * Add a reply to the specific ticket.
     *
     * @param  \App\Http\Requests\TicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreTicketMessageRequest $request, Ticket $ticket)
    {
        $ticket = Ticket::where(['slug' => $slug, 'user_id' => auth()->id()])->get();

        $message = TicketMessage::create([
            'user_id' => auth()->user()->id,
            'ticket_id' => $ticket->id,
            'body' => $request->input('message'),
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
                        'message_id' => $message->id,
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
     * Toggle the specified ticket status.
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->all();
        $ticket = Ticket::findorFail($id);

        if ($ticket->user_id !== auth()->user()->id)
        {
            abort(403, 'شما اجازه دسترسی به این تیکت را ندارید.');
        }

        if (isset($data['status'])) {
            $stat = $data['status'];
            $stat = ($stat == 1 ? 1 : 0);
            $ticket->status = $stat;
            $ticket->save();
        }


        $this->doneMessage();
        return redirect()->route('frontend.tickets.index');
    }
}
