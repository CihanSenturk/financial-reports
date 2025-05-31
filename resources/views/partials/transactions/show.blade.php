<div class="py-6 px-4 max-w-7xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Transaction Info</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <span class="font-medium">Reference No:</span>
                <div>{{ $transaction->transaction['merchant']['referenceNo'] }}</div>
            </div>
            <div>
                <span class="font-medium">Transaction ID:</span>
                <div>{{ $transaction->transaction['merchant']['transactionId'] }}</div>
            </div>
            <div>
                <span class="font-medium">Status:</span>
                <div>{{ $transaction->transaction['merchant']['status'] }}</div>
            </div>
            <div>
                <span class="font-medium">Channel:</span>
                <div>{{ $transaction->transaction['merchant']['channel'] }}</div>
            </div>
            <div>
                <span class="font-medium">Type:</span>
                <div>{{ $transaction->transaction['merchant']['type'] }}</div>
            </div>
            <div>
                <span class="font-medium">Operation:</span>
                <div>{{ $transaction->transaction['merchant']['operation'] }}</div>
            </div>
            <div>
                <span class="font-medium">Code:</span>
                <div>{{ $transaction->transaction['merchant']['code'] }}</div>
            </div>
            <div>
                <span class="font-medium">Message:</span>
                <div>{{ $transaction->transaction['merchant']['message'] }}</div>
            </div>
            <div>
                <span class="font-medium">Amount:</span>
                <div>{{ $transaction->fx['merchant']['originalAmount'] . ' ' . $transaction->fx['merchant']['originalCurrency'] }}</div>
            </div>
            <div>
                <span class="font-medium">Currency:</span>
                <div>{{ $transaction->fx['merchant']['originalCurrency'] }}</div>
            </div>
        </div>
    </div>

    @if ($transaction->customerInfo)
        <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Customer Info</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                <div>
                    <span class="font-medium">ID:</span>
                    <div>{{ $transaction->customerInfo['id'] }}</div>
                </div>
                <div>
                    <span class="font-medium">Name:</span>
                    <div>{{ $transaction->merchant['name'] }}</div>
                </div>
                <div>
                    <span class="font-medium">Email:</span>
                    <div>{{ $transaction->customerInfo['email'] }}</div>
                </div>
                <div>
                    <span class="font-medium">Number:</span>
                    <div>{{ $transaction->customerInfo['number'] }}</div>
                </div>
                <div>
                    <span class="font-medium">Billing Name:</span>
                    <div>{{ $transaction->customerInfo['billingFirstName'] . ' ' . $transaction->customerInfo['billingLastName']}}</div>
                </div>
                <div>
                    <span class="font-medium">Billing Adress:</span>
                    <div>{{ $transaction->customerInfo['billingAddress1'] }}</div>
                </div>
                <div>
                    <span class="font-medium">Shipping Name:</span>
                    <div>{{ $transaction->customerInfo['shippingFirstName'] . ' ' . $transaction->customerInfo['shippingLastName']}}</div>
                </div>
                <div>
                    <span class="font-medium">Shipping Adress:</span>
                    <div>{{ $transaction->customerInfo['shippingAddress1'] }}</div>
                </div>
            </div>
        </div>
    @endif
</div>