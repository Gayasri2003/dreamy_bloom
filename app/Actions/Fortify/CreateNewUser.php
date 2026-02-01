<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'] ?? null,
            'address' => $input['address'] ?? null,
            'role' => 'customer',
        ]);

        // Automatically create API token for new user
        $user->createToken('auth_token');

        // Handle cart intent - add product to cart if user came from product page
        if (session()->has('cart_intent')) {
            $cartIntent = session('cart_intent');
            
            $product = \App\Models\Product::find($cartIntent['product_id']);
            if ($product && $product->stock >= $cartIntent['quantity']) {
                \App\Models\Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $cartIntent['product_id'],
                    'quantity' => $cartIntent['quantity'],
                ]);
            }
            session()->forget('cart_intent');
        }

        return $user;
    }
}
