<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Transactions List
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto space-y-6">
        <form method="GET" action="{{ route('transactions.index') }}" class="bg-white p-4 rounded-xl shadow-sm grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Filter
                </button>
            </div>
        </form>

        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center">
            <div class="text-gray-700">
                <strong>{{ count($transactions->data) }}</strong> Transaction(s) found
            </div>
            <div class="text-gray-700">
                Total transactions: <strong>{{ count($transactions->data) }}</strong>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Transaction ID</th>
                        <th class="px-4 py-2 text-left">Merchant</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Original Amount</th>
                        <th class="px-4 py-2 text-left">Converted Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions->data as $transaction)
                        <tr>
                            <td class="px-4 py-2 text-gray-800">{{ \Carbon\Carbon::parse($transaction['created_at'])->format('Y-m-d') ?? null }}</td>
                            <td class="px-4 py-2">            
                                <a href="#" class="open-inline-modal text-blue-600 font-semibold underline hover:text-blue-800" data-url="{{ route('transactions.show', $transaction['transaction']['merchant']['transactionId']) }}" data-title="Transaction: {{ $transaction['transaction']['merchant']['transactionId'] }}">
                                    {{ $transaction['transaction']['merchant']['transactionId'] }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="#" class="open-inline-modal text-blue-600 font-semibold underline hover:text-blue-800" data-url="{{ route('merchants.show', $transaction['transaction']['merchant']['transactionId']) }}" data-title="Merchant: {{ $transaction['merchant']['name'] }}">
                                    {{ $transaction['merchant']['name'] ?? 'N/A' }}
                                </a>
                            <td class="px-4 py-2">{{ $transaction['transaction']['merchant']['status'] }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ number_format($transaction['fx']['merchant']['originalAmount'], 2) }} {{ $transaction['fx']['merchant']['originalCurrency'] }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ number_format($transaction['fx']['merchant']['convertedAmount'], 2) }} {{ $transaction['fx']['merchant']['convertedCurrency'] }}</td>
                        <tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500"> No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="ajaxInlineModal" class="hidden fixed top-10 left-1/2 transform -translate-x-1/2 z-50 bg-white border rounded-lg shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-xl font-semibold" id="inlineModalTitle">Show</h2>
                <button id="closeInlineModal" class="text-gray-500 text-2xl hover:text-red-600">&times;</button>
            </div>
        
            <div id="inlineModalContent" class="space-y-4">
                <p class="text-gray-400">Showing...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('ajaxInlineModal');
            const modalContent = document.getElementById('inlineModalContent');
            const modalTitle = document.getElementById('inlineModalTitle');
            const closeModal = document.getElementById('closeInlineModal');
        
            document.querySelectorAll('.open-inline-modal').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.dataset.url;
                    const title = this.dataset.title || 'Show';
        
                    modalTitle.textContent = title;
                    modalContent.innerHTML = '<p class="text-gray-400">Showing...</p>';
                    modal.classList.remove('hidden');
        
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            modalContent.innerHTML = html;
                        })
                        .catch(error => {
                            modalContent.innerHTML = '<p class="text-red-500">Error</p>';
                            console.error(error);
                        });
                });
            });
        
            closeModal.addEventListener('click', function () {
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
