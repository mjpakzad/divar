<?php
namespace App\Http\Controllers\Frontend;

use App\Models\Setting;
use Exception;
use Gateway;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Larabookir\Gateway\Exceptions\InvalidRequestException;
use Larabookir\Gateway\Exceptions\NotFoundTransactionException;
use Larabookir\Gateway\Exceptions\PortNotFoundException;
use Larabookir\Gateway\Exceptions\RetryException;

class PaymentController extends Controller
{
    public function request(Request $request, Invoice $invoice)
    {
        $user = auth()->user();
        abort_unless($invoice->user_id == $user->id, 403, 'شما اجازه انجام این عملیات را ندارید.');
        try {
            $price  = number_format($invoice->price * 10, 0, '', '');
            $gateway = Gateway::mellat();
            $gateway->setCallback(route('frontend.payments.callback'));
            $gateway->price($price)->ready(); // Rial
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();

            $payment = new Payment([
                'user_id'       => $user->id,
                'price'         => $invoice->price,
                'tracking_code' => uniqid($user->id),
                'ref_id'        => $refId,
                'status'        => false,
            ]);
            $invoice->payments()->save($payment);

            return $gateway->redirect();
        } catch (Exception $exception)
        {
            $invoice->load('commercial');
            return redirect()->route('frontend.promotes.show', $invoice->commercial->slug)->withErrors(['paymentError' => $exception->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        try {
            $gateway        = Gateway::verify(); // auto exception
            $trackingCode   = $gateway->trackingCode();
            $refId          = $gateway->refId();
            $cardNumber     = $gateway->cardNumber(); // Null in some gateways
            $payment        = Payment::with('invoice.commercial', 'invoice.services')->whereRefId($request->RefId)->firstOrFail();
            $payment->update(['status' => true]);
            $payment->invoice->update(['status' => Invoice::STATUS_PAID]);
            $commercial = $payment->invoice->commercial;
            foreach($payment->invoice->services as $service) {
                $field = $service->field;
                switch ($field) {
                    case 'laddered_at':
                        $commercial->laddered_at = now();
                        break;
                    case 'featured_at':
                        $featured = Setting::where('key', 'featured_days')->value('value');
                        $commercial->featured_at = now();
                        break;
                    case 'reportage_at':
                        $commercial->reportage_at = now();
                        break;
                    case 'expire_at':
                        $commercial->expire_at = now()->addMonth();
                        break;
                    default;
                }
                $commercial->save();
            }
            $this->doneMessage('پرداخت شما با موفقیت انجام شد. آگهی شما ارتقا یافت.');
            return redirect()->route('frontend.payments.result', $payment);
            return redirect()->route('frontend.commercials.show', $commercial->slug);
        } catch (RetryException $exception)
        {
            return redirect()->route('frontend.promotes.show', $commercial->slug)->withErrors(['paymentError' => $exception->getMessage()]);
        } catch (PortNotFoundException $exception)
        {
            return redirect()->route('frontend.promotes.show', $commercial->slug)->withErrors(['paymentError' => $exception->getMessage()]);
        } catch (InvalidRequestException $exception)
        {
            return redirect()->route('frontend.promotes.show', $commercial->slug)->withErrors(['paymentError' => $exception->getMessage()]);
        } catch (NotFoundTransactionException $exception)
        {
            return redirect()->route('frontend.promotes.show', $commercial->slug)->withErrors(['paymentError' => $exception->getMessage()]);
        } catch (Exception $exception)
        {
            return redirect()->route('frontend.promotes.show', $commercial->slug)->withErrors(['paymentError' => $exception->getMessage()]);
        }
    }
    
    public function result(Payment $payment)
    {
        abort_if($payment->user_id == auth()->id(), 403);
        return view('frontend.payments.result', compact('payments'));
    }
}
