<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function loginPage()
    {
        return view("login");
    }

    public function loginSubmit($id)
    {
        // direct login
        $user = User::findOrFail($id);
        if($user){
            auth()->login($user);
            return redirect()->route("plans");
        }
        auth()->login($user);
        return redirect()->route("plans");
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route("login");
    }

    public function plans()
    {
        $prices = [
            "montly" => Crypt::encryptString(env("STRIPE_PRODUCT_ID") . "|" . env("STRIPE_MONTHLY_PRICE_ID")),
            "yearly" => Crypt::encryptString(env("STRIPE_PRODUCT_ID") . "|" . env("STRIPE_YEARLY_PRICE_ID")),
            "longest" => Crypt::encryptString(env("STRIPE_PRODUCT_ID") . "|" . env("STRIPE_LONGEST_PRICE_ID")),
        ];
        return view("plans", compact("prices"));
    }

    public function planSelected($id)
    {
        // check if $id is valid
        $plan = Crypt::decryptString($id);
        if(!$plan){
            return redirect()->route("plans")->withErrors("Plano inválido.");
        }

        $plan = explode("|", $plan);
        $productId = $plan[0];
        $priceId = $plan[1];

        return auth()->user()
            ->newSubscription($productId, $priceId)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('plans'),
            ]);
    }

    public function subscriptionSuccess()
    {
        return view("subscription_success");
    }

    public function dashboard(){

        $data = [];
        $user = auth()->user();


//check the expiration of the subscription
        $timestamp = auth()->user()->subscription(env("STRIPE_PRODUCT_ID"))
            ->asStripeSubscription()
            ->current_period_end;

        $data["subscription_end"] = date("d/m/Y H:i:s", $timestamp);

        return view("dashboard", $data);
    }
}
