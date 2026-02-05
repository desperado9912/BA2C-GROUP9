class PayPalGateway implements PaymentGateway {

    public function pay(float $amount): string {
        return "Paid $amount using PayPal.";
    }
}