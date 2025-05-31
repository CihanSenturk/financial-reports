<div class="py-6 px-4 max-w-7xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Customer Detail</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <span class="font-medium">ID:</span>
                <div>{{ $merchant->customerInfo['id'] }}</div>
            </div>
            <div>
                <span class="font-medium">Email:</span>
                <div>{{ $merchant->customerInfo['email'] }}</div>
            </div>
            <div>
                <span class="font-medium">Number:</span>
                <div>{{ $merchant->customerInfo['number'] }}</div>
            </div>
            <div>
                <span class="font-medium">Expiry Date:</span>
                <div>{{ \Carbon\Carbon::createFromDate($merchant->customerInfo['expiryYear'], $merchant->customerInfo['expiryMonth'], 1) ?? null }}</div>
            </div>
            <div>
                <span class="font-medium">Birthday:</span>
                <div>{{ $merchant->customerInfo['birthday'] }}</div>
            </div>
            <div>
                <span class="font-medium">Gender:</span>
                <div>{{ $merchant->customerInfo['gender'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Billing Detail</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <span class="font-medium">Title:</span>
                <div>{{ $merchant->customerInfo['billingTitle'] }}</div>
            </div>
            <div>
                <span class="font-medium">Name:</span>
                <div>{{ $merchant->customerInfo['billingFirstName'] . ' ' . $merchant->customerInfo['billingLastName']}}</div>
            </div>
            <div>
                <span class="font-medium">Company:</span>
                <div>{{ $merchant->customerInfo['billingCompany'] }}</div>
            </div>
            <div>
                <span class="font-medium">Address1:</span>
                <div>{{ $merchant->customerInfo['billingAddress1'] }}</div>
            </div>
            <div>
                <span class="font-medium">Address2:</span>
                <div>{{ $merchant->customerInfo['billingAddress2'] }}</div>
            </div>
            <div>
                <span class="font-medium">City:</span>
                <div>{{ $merchant->customerInfo['billingCity'] }}</div>
            </div>
            <div>
                <span class="font-medium">State:</span>
                <div>{{ $merchant->customerInfo['billingState'] }}</div>
            </div>
            <div>
                <span class="font-medium">Post Code:</span>
                <div>{{ $merchant->customerInfo['billingPostcode'] }}</div>
            </div>
            <div>
                <span class="font-medium">Country:</span>
                <div>{{ $merchant->customerInfo['billingCountry'] }}</div>
            </div>
            <div>
                <span class="font-medium">Phone:</span>
                <div>{{ $merchant->customerInfo['billingPhone'] }}</div>
            </div>
            <div>
                <span class="font-medium">Fax:</span>
                <div>{{ $merchant->customerInfo['billingFax'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Shipping Detail</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <span class="font-medium">Title:</span>
                <div>{{ $merchant->customerInfo['shippingTitle'] }}</div>
            </div>
            <div>
                <span class="font-medium">Name:</span>
                <div>{{ $merchant->customerInfo['shippingFirstName'] . ' ' . $merchant->customerInfo['shippingLastName']}}</div>
            </div>
            <div>
                <span class="font-medium">Company:</span>
                <div>{{ $merchant->customerInfo['shippingCompany'] }}</div>
            </div>
            <div>
                <span class="font-medium">Address1:</span>
                <div>{{ $merchant->customerInfo['shippingAddress1'] }}</div>
            </div>
            <div>
                <span class="font-medium">Address2:</span>
                <div>{{ $merchant->customerInfo['shippingAddress2'] }}</div>
            </div>
            <div>
                <span class="font-medium">City:</span>
                <div>{{ $merchant->customerInfo['shippingCity'] }}</div>
            </div>
            <div>
                <span class="font-medium">State:</span>
                <div>{{ $merchant->customerInfo['shippingState'] }}</div>
            </div>
            <div>
                <span class="font-medium">Post Code:</span>
                <div>{{ $merchant->customerInfo['shippingPostcode'] }}</div>
            </div>
            <div>
                <span class="font-medium">Country:</span>
                <div>{{ $merchant->customerInfo['shippingCountry'] }}</div>
            </div>
            <div>
                <span class="font-medium">Phone:</span>
                <div>{{ $merchant->customerInfo['shippingPhone'] }}</div>
            </div>
            <div>
                <span class="font-medium">Fax:</span>
                <div>{{ $merchant->customerInfo['shippingFax'] }}</div>
            </div>
        </div>
    </div>
</div>